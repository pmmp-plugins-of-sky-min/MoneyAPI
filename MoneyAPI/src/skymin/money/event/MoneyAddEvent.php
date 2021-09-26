<?php
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
