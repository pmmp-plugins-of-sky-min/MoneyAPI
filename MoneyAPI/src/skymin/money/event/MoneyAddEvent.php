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

namespace skymin\money\event;

use pocketmine\event\{
	Event,
	Cancellable,
	CancellableTrait
};


class MoneyAddEvent extends Event implements Cancellable{
	use CancellableTrait;
	
	public function __construct(
		private string $player,
		private int $money
	){}
	
	public function getPlayerName() :string{
		return $this->player;
	}
	
	public function getMoney(): int{
		return $this->money;
	}
	
}
