<?php
declare(strict_types = 1);

namespace skymin\money\event;

use pocketmine\event\{
	Event,
	Cancellable,
	CancellableTrait
};

class MoneyChangedEvent extends Event implements Cancellable{
	use CancellableTrait;

	public function __construct (
		private string $player,
		private int $beforeMoney,
		private int $afterMoney
	){}
	
	public function getPlayerName() :string{
		return $this->player;
	}
	
	public function getBeforeMoney () :int{
		return $this->beforeMoney;
	}
	
	 public function getAfterMoney () :int{
		return $this->afterMoney;
	}

}
