<?php
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
