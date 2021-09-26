<?php
declare(strict_types=1);

namespace skymin\money\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use skymin\money\MoneyAPI;

class MyMoneyC extends Command{
	
	public function __construct(){
		parent::__construct('돈', '내 돈을 확인합니다', '/돈');
		$this->setPermission('money.true');
		$this->setPermissionMessage('§c사용할 권한이 없습니다');
	}
	
	public function execute(CommandSender $player, string $label, array $args) :void{
		$api = MoneyApi::getInstance();
		$money = $api->getMoney($player);
		$player->sendMessage(MoneyAPI::$prefix . "나의 돈 : " . $api->koreanFormat($money));
		$player->sendMessage(MoneyAPI::$prefix . "나의 순위 : " . $api->getRank($player) . "위");
	}
}