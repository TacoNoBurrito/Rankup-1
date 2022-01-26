<?php namespace Taco\RU\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use Taco\RU\Main;

class PrestigeCommand extends Command {

    public function __construct() {
        parent::__construct("prestige", "Rise and be the richest!", "", ["pres"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : void {
        if ($sender instanceof Player) {
            $ru = Main::getRankupUtils();
            $cfg = Main::getInstance()->config;
            $session = Main::getSessionManager()->getSession($sender);
            $prestige = $session->getPrestige();
            if ($ru->isTopPrestige($prestige)) {
                $sender->sendMessage($cfg["max-prestige"]);
                return;
            }
            if (!$ru->isTopRank($session->getRank())) {
                $sender->sendMessage($cfg["need-be-max-to-prestige"]);
                return;
            }
            $next = $ru->getNextPrestige($prestige);
            $price = $ru->getPrestigePrice($next);
            $money = $session->getMoney();
            if ($price > $money) {
                $sender->sendMessage(str_replace(
                    "{money}",
                    ($price - $money),
                    $cfg["prestige-lack-money"]
                ));
                return;
            }
            $session->takeMoney($price);
            $session->setPrestige($next);
            $sender->sendMessage(str_replace(
                "{prestige}",
                $next,
                $cfg["prestige"]
            ));
            Main::getRankupUtils()->executeCommandsForPrestige($sender, $next);
            $session->setRank($ru->getFirstRank());
            return;
        }
        $sender->sendMessage("This command is meant to be used in-game.");
    }

}