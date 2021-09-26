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

declare(strict_types=1);

namespace skymin\money\command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\Server;
use skymin\money\MoneyAPI;

class AddMoneyC extends Command{
	
	public function __construct(){
		parent::__construct('돈주기', '돈을 지급합니다', '/돈주기 [닉네임] [금액]');
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
			$player->sendMessage(MoneyAPI::$prefix . "{$target}님은 서버에 접속한 적이 없습니다");
			return;
		}
		$api->addMoney($target, (int)$args[1]);
		$player->sendMessage(MoneyAPI::$prefix . "{$target}님에게 돈 " . $api->koreanFormat((int)$args[1]) . "(을)를 지급했습니다.");
	}
}