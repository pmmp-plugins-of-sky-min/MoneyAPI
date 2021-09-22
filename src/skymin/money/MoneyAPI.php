<?php
declare(strict_types = 1);

namespace skymin\money;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

use pocketmine\Server;

use pocketmine\scheduler\ClosureTask;

use skymin\money\event\{
	MoneyChangedEvent,
	MoneyAddEvent,
	MoneyReduceEvent
};

use skymin\money\command\{
	CheckMoneyC,
	MyMoneyC,
	PayMoneyC,
	MoneyRankC,
	SetMoneyC,
	ReduceMoneyC,
	AddMoneyC
};

use skymin\json\Data;
use skymin\traits\{SingletonTrait, NameTrait};

use function floor;
use function count;
use function implode;
use function arsort;

class MoneyAPI extends PluginBase{
	use SingletonTrait, NameTrait;
	
	public static string $unit = '원';
	public static int $defaultMoney = 50000;
	
	public static string $prefix = '§6[MONEY] §r§7';
	
	public array $data = [];
	public array $rank = [];
	
	public function onLoad() :void{
		self::$instance = $this;
	}
	
	public function onEnable(): void{
		$this->data = Data::call($this->getDataFolder(), 'data');
		$this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
		$this->getServer()->getCommandMap()->registerAll('c', [
			new CheckMoneyC(),
			new MyMoneyC(),
			new PayMoneyC(),
			new MoneyRankC(),
			new SetMoneyC(),
			new ReduceMoneyC(),
			new AddMoneyC()
		]);
	}
	
	public function onDisable() :void{
		Data::save($this->getDataFolder(), 'data', $this->data);
	}
	
	public function koreanFormat(int $money) :string{
		$elements = [];
		if ($money >= 1000000000000) {
			$elements[] = floor($money / 1000000000000) . "조";
			$money %= 1000000000000;
		}
		if ($money >= 100000000) {
			$elements[] = floor($money / 100000000) . "억";
			$money %= 100000000;
		}
		if ($money >= 10000) {
			$elements[] = floor($money / 10000) . "만";
			$money %= 10000;
		}
		if (count($elements) == 0 || $money > 0) {
			$elements[] = $money;
		}
		return implode(" ", $elements) . self::$unit;
	}
	
	public function isPlayerData($p) :bool{
		$player = $this->getLowerCaseName($p);
		return (isset($this->data[$player]));
	}
	
	public function getMoney($p): int{
		$player = $this->getLowerCaseName($p);
		return $this->data[$player] ?? -1;
	}
	
	public function getAllMoney(): array{
		return $this->data ?? [];
	}
	
	public function setMoney($p, int $money) :void{
		if ($money < 0) $money = 0;
		$player = $this->getLowerCaseName($p);
		(new MoneyChangedEvent ($player, $this->getMoney($p), $money))->call();
		$this->data[$player] = $money;
	}
	
	public function addMoney($p, int $money) :void{
		$player = $this->getLowerCaseName($p);
		(new MoneyAddEvent ($player, $money))->call();
		$this->setMoney($p, $this->getMoney($p) + $money);
	}
	
	public function reduceMoney($p, int $money) :bool{
		$player = $this->getLowerCaseName($p);
		(new MoneyReduceEvent ($player, $money))->call();
		if ($this->getMoney($p) < $money) return false;
		$this->setMoney($p, $this->getMoney($p) - $money);
		return true;
	}
	
	public function getRank($p) :int{
		$this->updateRank();
		$player = $this->getLowerCaseName($p);
		return $this->rank['player'][$player] ?? -1;
	}
	
	public function getPlayerByRank($rank) :?string{
		$this->updateRank();
		return $this->rank['rank'][$rank] ?? null;
	}
	
	public function updateRank() :void{
		arsort($this->data);
		$i = 0;
		$this->rank = [];
		foreach ($this->data as $p => $k) {
			$i++;
			$this->rank['player'][$p] = $i;
			$this->rank['rank'][$i] = $p;
		}
	}
	
}