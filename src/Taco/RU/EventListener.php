<?php namespace Taco\RU;

// Copyright © 2022  TacoError

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener {

    public function onLogin(PlayerLoginEvent $event) : void {
        $player = $event->getPlayer();
        Main::getSessionManager()->createSession($player);
    }

    public function onQuit(PlayerQuitEvent $event) : void {
        $player = $event->getPlayer();
        Main::getSessionManager()->closeSession($player);
    }

}