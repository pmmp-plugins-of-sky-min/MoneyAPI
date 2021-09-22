<?php
declare(strict_types = 1);

namespace skymin\money\event;

use pocketmine\event\Event;

class MoneyReduceEvent extends Event{

	protected $playerName;
	protected $reducedMoney;

	public function __construct (string $playerName, int $reducedMoney){
		$this->playerName = $playerName;
		$this->reducedMoney = $reducedMoney;
	}

	public function getPlayerName () :string{
		return $this->playerName;
   }
	
	public function getReducedMoney () :int{
		return $this->reducedMoney;
	}

}
