<?php
declare(strict_types=1);

namespace skymin\money\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use skymin\money\MoneyAPI;

class CheckMoneyC extends Command{
	
	public function __construct(){
		parent::__construct('돈보기', '플레이어의 돈을 확인합니다', '/돈보기 [닉네임]');
		$this->setPermission ('money.true');
		$this->setPermissionMessage('§c사용할 권한이 없습니다');
	}
	
	public function execute(CommandSender $player, string $label, array $args) :void{
		$api = MoneyApi::getInstance();
		if(!$player->hasPermission($this->getPermission())){
			$player->sendMessage($this->getPermissionMessage());
			return;
		}
		if(!isset($args[0])){
			$player->sendMessage(MoneyAPI::$prefix . $this->usageMessage);
			return;
		}
		$target = $args[0];
		$targetPlayer = Server::getInstance()->getPlayerByPrefix($target);
		if (!is_null($targetPlayer)) $target = $targetPlayer->getName();
		if (!$api->isPlayerData($target)) {
			$player->sendMessage(MoneyAPI::$prefix . "{$target}님은 서버에 접속한 적이 없습니다");
			return;
		}
		$money = $api->getMoney($target);
		
		$player->sendMessage(MoneyAPI::$prefix . "{$target}의 돈: " . $api->koreanFormat($money));
		$player->sendMessage(MoneyAPI::$prefix . "{$target}의 순위: " .  $api->getRank($target) . "위");
	}
}