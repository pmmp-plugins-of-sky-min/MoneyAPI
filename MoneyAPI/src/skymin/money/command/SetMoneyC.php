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


class SetMoneyC extends Command{
	
	public function __construct(){
		parent::__construct('돈설정', '돈을 설정합니다', '/돈설정 [닉네임] [금액]');
		$this->setPermission('money.op');
		$this->setPermissionMessage('§c사용할 권한이 없습니다');
	}
	
	public function execute(CommandSender $player, string $label, array $args) :void{
		$api = MoneyApi::getInstance();
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
		$targetPlayer = Server::getInstance()->getPlayerByPrefix($target);
		if (!is_null($targetPlayer)) $target = $targetPlayer->getName();
		if (!$api->isPlayerData($target)) {
			$player->sendMessage($api->$prefix . "{$target}님은 서버에 접속한 적이 없습니다");
			return;
		}
		$api->setMoney($target, (int)$args[1]);
		$player->sendMessage(MoneyAPI::$prefix . "{$target}님의 돈을 " . $api->koreanFormat((int)$args[1]) . "으로 설정했습니다.");
	}
	
}