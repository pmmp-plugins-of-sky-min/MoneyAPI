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

use pocketmine\form\Form;
use pocketmine\Server;

use skymin\money\MoneyAPI;

class MoneyRankC extends Command{
	
	public function __construct(){
		parent::__construct('돈순위', '돈 순위를 확인합니다', '/돈순위 [인덱스]');
		$this->setPermission('money.true');
		$this->setPermissionMessage('§c사용할 권한이 없습니다');
	}
	
	public function execute(CommandSender $player, string $label, array $args) :void{
		$api = MoneyApi::getInstance();
		$data = $api->getAllMoney();
		$maxPage = ceil(count($data) / 5);
		$page = $args[0] ?? -1;
		
		if (!is_numeric($page) || $page < 1) $page = 1;
		
		if ($maxPage < $page) $page = $maxPage;
		$player->sendMessage("§6==========현재 페이지: {$page}/{$maxPage} 페이지==========");
		for ($i = $page * 5 - 4; $i <= $page * 5; $i++) {
			$target = $api->getPlayerByRank($i);
			if (!is_null($target)) {
				$player->sendMessage('§6[' . $i . '위] §7' . $target . ' : ' . $api->koreanFormat($api->getMoney($target)));
			}
		}
		$player->sendMessage('§6=========================');
	}
	
}