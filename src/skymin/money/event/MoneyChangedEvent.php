<?php
declare(strict_types = 1);

namespace skymin\money\event;

use pocketmine\event\Event;

class MoneyChangedEvent extends Event{

	protected $playerName;
	protected $beforeMoney;
	protected $afterMoney;

	public function __construct (string $playerName, int $beforeMoney, int $afterMoney){
		$this->playerName = $playerName;
		$this->beforeMoney = $beforeMoney;
		$this->afterMoney = $afterMoney;
	}
	public function getPlayerName () :string{
		return $this->playerName;
	}
	
	public function getBeforeMoney () :int{
		return $this->beforeMoney;
	}
	
	 public function getAfterMoney () :int{
		return $this->afterMoney;
	}

}
