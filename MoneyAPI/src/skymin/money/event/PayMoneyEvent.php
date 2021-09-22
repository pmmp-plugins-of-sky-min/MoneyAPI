<?php
declare(strict_types = 1);

namespace skymin\money\event;

use pocketmine\event\Event;

class PayMoneyEvent extends Event{

	protected $giverName;
	protected $receiverName;
	protected $paidMoney;

	public function __construct (string $giverName, string $receiverName, int $paidMoney){
		$this->giverName = $giverName;
		$this->receiverName = $receiverName;
		$this->paidMoney = $paidMoney;
	}

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
