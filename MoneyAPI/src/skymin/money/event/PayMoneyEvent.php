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

use pocketmine\event\{Event,
	Cancellable,
	CancellableTrait
};

class PayMoneyEvent extends Event implements Cancellable{
	use CancellableTrait;

	public function __construct (
		private string $giverName,
		private string $receiverName,
		private int $paidMoney
	){}

	public function getGiverName () :string{
		return $this->giverName;
	}
	
	public function getReceiverName () :string{
		return $this->receiverName;
	}
	
	public function getPaidMoney () :int{
		return $this->paidMoney;
	}

}
