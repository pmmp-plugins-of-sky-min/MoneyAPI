<?php
/*
*       _                       _        
*      | |                     (_)       
*  ___ | | __ _   _  _ __ ___   _  _ __  
* / __|| |/ /| | | || '_ ` _ \ | || '_ \ 
* \__ \|   < | |_| || | | | | || || | | |
* |___/|_|\_\ \__, ||_| |_| |_||_||_| |_|
*              __/ |                     
*             |___/                      
* 
* This program is free software: you can redistribute it and/or modify
* it under the terms of the MIT License. see <https://opensource.org/licenses/MIT>.
*/

declare(strict_types = 1);

namespace skymin\money\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\Server;

use skymin\money\MoneyAPI;
use skymin\money\event\PayMoneyEvent;


class PayMoneyC extends Command{
	
	public function __construct(){
		parent::__construct('지불', '돈을 지불합니다', '/지불 [닉네임] [금액]');
		$this->setPermission('money.op');
		$this->setPermissionMessage('§c사용할 권한이 없습니다');
	}
	
	public function execute(CommandSender $player, string $label, array $args) :void{
		$api = MoneyApi::getInstance();
		$myMoney = $api->getMoney($player);
		if(!$player->hasPermission($this->getPermission())){
			$player->sendMessage($this->getPermissionMessage());
			return;
		}
		if (!isset($args[0]) || !isset($args[1])) {
			$player->sendMessage(MoneyAPI::$prefix . $this->usageMessage);
			return;
		}
		if (!is_numeric($args[1])) {
			$player->sendMessage(MoneyAPI::$prefix . '숫자로 입력해주세요');
			return;
		}
		$target = $args[0];
		$payMoney = $args[1];
		if ($payMoney > $myMoney) {
			$player->sendMessage(MoneyAPI::$prefix . "금액을 정확하게 입력해주세요");
			return;
		}
		if (strtolower($target) == strtolower($player->getName())) {
			$player->sendMessage(MoneyAPI::$prefix . "자신에게 줄 수 없습니다");
			return;
		}
		$targetPlayer = Server::getInstance()->getPlayerByPrefix($target);
		if (!is_null($targetPlayer)) $target = $targetPlayer->getName();
		if (!$api->isPlayerData($target)) {
			$player->sendMessage(MoneyAPI::$prefix . "{$target}님은 서버에 접속한 적이 없습니다");
			return;
		}
		if ($payMoney > $api->getMoney($player)) {
			$player->sendMessage(MoneyAPI::$prefix . "돈이 부족합니다");
			return;
		}
		$api->reduceMoney($player, (int)$payMoney);
		$api->addMoney($target, (int)$payMoney);
		$player->sendMessage(MoneyAPI::$prefix . "{$target}님에게 " . MoneyAPI::koreanFormat((int)$payMoney) . "을 지불 했습니다");
		if (!is_null($targetP = Server::getInstance()->getPlayerExact($target))) {
			$targetP->sendMessage(MoneyAPI::$prefix . "{$player->getName()}에게 " . $api->koreanFormat((int)$payMoney) . "을 받았습니다");
		}
	}
}