<?php namespace Taco\RU\utils;

// Copyright © 2022  TacoError

use pocketmine\console\ConsoleCommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use Taco\RU\Main;

class RankupUtils {

    /**
     * @return string
     *
     * Returns the first configured rank
     * (Used for prestiging)
     */
    public function getFirstRank() : string {
        foreach (array_keys(Main::getInstance()->config["ranks"]) as $name) {
            return $name;
        }
        return "A";
    }

    /**
     * @param string $rank
     * @return bool
     *
     * Checks if the specified rank is the last possible rank.
     */
    public function isTopRank(string $rank) : bool {
        $ranks = array_keys(Main::getInstance()->config["ranks"]);
        return $ranks[count($ranks) - 1] == $rank;
    }

    /**
     * @param string $rank
     * @return string
     *
     * Gets the rank after the specified rank
     */
    public function getRankAfter(string $rank) : string {
        $ranks = array_keys(Main::getInstance()->config["ranks"]);
        return $ranks[array_search($rank, $ranks) + 1];
    }

    /**
     * @param string $rank
     * @return int
     *
     * Gets the rankup price of the specified rank
     */
    public function getRankPrice(string $rank) : int {
        $ranks = Main::getInstance()->config["ranks"];
        return $ranks[$rank]["price"];
    }

    /**
     * @param int $prestige
     * @return bool
     *
     * Checks if the specified prestige is the max prestige
     */
    public function isTopPrestige(int $prestige) : bool {
        $prestiges = array_keys(Main::getInstance()->config["prestiges"]);
        return $prestiges[(string)(count($prestiges) - 1)] == $prestige;
    }

    /**
     * @param int $prestige
     * @return int
     *
     * Returns the next prestige
     */
    public function getNextPrestige(int $prestige) : int {
        return $prestige + 1;
    }

    /**
     * @param int $prestige
     * @return int
     *
     * Gets the prestige price of the specified prestige
     */
    public function getPrestigePrice(int $prestige) : int {
        $prestiges = Main::getInstance()->config["prestiges"];
        return $prestiges[(string)$prestige]["price"];
    }

    /**
     * @param int $prestige
     * @return array
     *
     * Returns an array of the commands that will be executed when the player
     * prestiges to the specified prestige
     */
    public function getCommandsForPrestige(int $prestige) : array {
        $prestiges = Main::getInstance()->config["prestiges"];
        return $prestiges[(string)$prestige]["commands"];
    }

    /**
     * @param string $rank
     * @return array
     *
     * Returns an array of the commands that will be executed when the player
     * ranks up to the specified rank
     */
    public function getCommandsForRank(string $rank) : array {
        $ranks = Main::getInstance()->config["ranks"];
        return $ranks[$rank]["commands"];
    }

    /**
     * @param Player $player
     * @param string $rank
     * @return void
     *
     * Executes the commands when for the player and their specified new rank
     * (USED ON RANKUP COMMAND)
     */
    public function executeCommandsForRank(Player $player, string $rank) : void {
        $commands = $this->getCommandsForRank($rank);
        foreach ($commands as $cmd) Server::getInstance()->dispatchCommand(
            new ConsoleCommandSender(Server::getInstance(), Server::getInstance()->getLanguage()),
            str_replace("{name}", $player->getName(), $cmd)
        );
    }

    /**
     * @param Player $player
     * @param int $prestige
     * @return void
     *
     * Executes the commands for the player and their specified new prestige.
     */
    public function executeCommandsForPrestige(Player $player, int $prestige) : void {
        $commands = $this->getCommandsForPrestige($prestige);
        foreach ($commands as $cmd) Server::getInstance()->dispatchCommand(
            new ConsoleCommandSender(Server::getInstance(), Server::getInstance()->getLanguage()),
            str_replace("{name}", $player->getName(), $cmd)
        );
    }

}