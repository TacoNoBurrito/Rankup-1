<?php namespace Taco\RU\commands;

// Copyright © 2022  TacoError

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use Taco\RU\Main;

class RankupCommand extends Command {

    public function __construct() {
        parent::__construct("rankup", "Rise and be the richest!", "", ["ru"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : void {
        if ($sender instanceof Player) {
            $ru = Main::getRankupUtils();
            $cfg = Main::getInstance()->config;
            $session = Main::getSessionManager()->getSession($sender);
            $rank = $session->getRank();
            if ($ru->isTopRank($rank)) {
                $sender->sendMessage($cfg["max-rank"]);
                return;
            }
            $next = $ru->getRankAfter($rank);
            $price = $ru->getRankPrice($next);
            $money = $session->getMoney();
            if ($price > $money) {
                $sender->sendMessage(str_replace(
                    "{money}",
                    ($price - $money),
                    $cfg["rankup-lack-money"]
                ));
                return;
            }
            $session->takeMoney($price);
            $session->setRank($next);
            $sender->sendMessage(
                str_replace(
                    "{rank}",
                    $next,
                    $cfg["rankup"]
                )
            );
            Main::getRankupUtils()->executeCommandsForRank($sender, $next);
            return;
        }
        $sender->sendMessage("This command is meant to be used in-game.");
    }

}