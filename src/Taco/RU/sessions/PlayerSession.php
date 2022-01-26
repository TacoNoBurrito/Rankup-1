<?php namespace Taco\RU\sessions;

// Copyright © 2022  TacoError

use pocketmine\player\Player;
use Taco\RU\Main;

class PlayerSession {

    private Player $player;

    private string $rank;

    private int $prestige;

    public function __construct(Player $player) {
        $this->player = $player;
        if (!Main::getInstance()->storage->exists($player->getName())) {
            $this->rank = array_keys(Main::getInstance()->config["ranks"])[0];
            $this->prestige = 0;
            return;
        }
        $data = Main::getInstance()->storage->get($player->getName());
        $this->rank = $data["rank"];
        $this->prestige = $data["prestige"];
    }

    public function close() : void {
        $cfg = Main::getInstance()->storage;
        $cfg->set($this->player->getName(), [
            "rank" => $this->rank,
            "prestige" => $this->prestige
        ]);
        $cfg->save();
    }

    public function getRank() : string {
        return $this->rank;
    }

    public function getPrestige() : int {
        return $this->prestige;
    }

    public function setRank(string $new) : void {
        $this->rank = $new;
    }

    public function setPrestige(int $new) : void {
        $this->prestige = $new;
    }

    public function getMoney() : float|int {
        return Main::getInstance()->economy->myMoney($this->player);
    }

    public function takeMoney(int $amount) : void {
        Main::getInstance()->economy->reduceMoney($this->player, $amount);
    }

}