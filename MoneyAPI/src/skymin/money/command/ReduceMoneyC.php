<?php
declare(strict_types = 1);

namespace skymin\money\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use skymin\money\MoneyAPI;


class ReduceMoneyC extends Command{
	
	public function __construct(){
		parent::__construct('돈뺏기', '돈을 뻇습니다', '/돈뺏기 [닉네임] [금액]');
		$this->setPermission('money.op');
		$this->setPermissionMessage('§c사용할 권한이 없습니다');
	}
	
	public function execute(CommandSender $player, string $label, array $args) :void{
		$api = MoneyApi::getInstance();
		if(!$player->hasPermission($this->getPermission())){
			$player->sendMessage($this->getPermissionMessage());
			return;
		}
		if (!isset($args[0]) || !isset($args[1])) {
			$player->sendMessage(MoneyAPI::$prefix . $this->usageMessage);
			return;
		}
		if (!is_numeric($args[1])) {
			$player->sendMessage(MoneyAPI::$prefix . '숫자로 입력해주세요');
			return;
		}
		$target = $args[0];
		$targetPlayer = Server::getInstance()->getPlayerByPrefix($target);
		if (!is_null($targetPlayer)) $target = $targetPlayer->getName();
		if (!$api->isPlayerData($target)) {
			$player->sendMessage(MoneyAPI::$prefix . "{$target}님은 서버에 접속한 적이 없습니다");
			return;
		}
		$api->reduceMoney($target, (int)$args[1]);
		$player->sendMessage(MoneyAPI::$prefix . "{$target}님의 돈 " . $api->koreanFormat((int)$args[1]) . "을 성공적으로 뺏었습니다");
	}
	
}