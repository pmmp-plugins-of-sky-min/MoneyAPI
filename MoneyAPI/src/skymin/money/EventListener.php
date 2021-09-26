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

namespace skymin\money;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use skymin\money\event\MoneyChangedEvent;
use skymin\money\event\MoneyAddEvent;
use skymin\money\event\MoneyReduceEvent;
use skymin\money\event\PayMoneyEvent;

use function date;

class EventListener implements Listener{
	
	public function onJoin (PlayerJoinEvent $event) :void{
		$api = MoneyApi::getInstance();
		$player = $event->getPlayer();
		$money = $api->getMoney ($player);
		$defaultMoney = MoneyAPI::$defaultMoney;
		if ($money < 0){
			$api->setMoney ($player, $defaultMoney);
			$player->sendMessage (MoneyAPI::$prefix . '현재 잔액은 '.$api->koreanFormat ($defaultMoney).' 입니다');
			return;
		}
		$player->sendMessage (MoneyAPI::$prefix . '현재 잔액은 '.$api->koreanFormat ($money).' 입니다');
	}

}