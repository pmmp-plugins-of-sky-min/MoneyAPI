<?php
declare(strict_types = 1);

namespace skymin\money\event;

use pocketmine\event\Event;

class MoneyAddEvent extends Event{
	
	protected $playerName;
	protected $addedMoney;
	
	public function __construct(string $playerName, int $addedMoney){
		$this->playerName = $playerName;
		$this->addedMoney = $addedMoney;
	}
	
	public function getPlayerName():string{
		return $this->playerName;
	}
	
	public function getAddedMoney(): int{
		return $this->addedMoney;
	}
	
}
