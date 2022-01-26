<?php namespace Taco\RU\sessions;

// Copyright © 2022  TacoError

use pocketmine\player\Player;

class SessionManager {

    /**
     * @var array<string, SessionManager>
     */
    private array $sessions = [];

    public function createSession(Player $player) : void {
        $this->sessions[$player->getName()] = new PlayerSession($player);
    }

    public function getSession(Player $player) : PlayerSession {
        return $this->sessions[$player->getName()];
    }

    public function closeSession(Player $player) : void {
        $this->getSession($player)->close();
        unset($this->sessions[$player->getName()]);
    }

}