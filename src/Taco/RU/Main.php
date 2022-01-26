<?php namespace Taco\RU;

// Copyright © 2022  TacoError

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Taco\RU\commands\PrestigeCommand;
use Taco\RU\commands\RankupCommand;
use Taco\RU\sessions\SessionManager;
use Taco\RU\utils\RankupUtils;

class Main extends PluginBase {

    private static self $instance;

    private static SessionManager $sessionManager;

    private static RankupUtils $rankupUtils;

    public Config $storage;

    public array $config = [];

    public Plugin $economy;

    public function onEnable() : void {
        self::$instance = $this;
        self::$sessionManager = new SessionManager();
        self::$rankupUtils = new RankupUtils();
        $this->saveConfig();
        $this->config = $this->getConfig()->getAll();
        $this->storage = new Config($this->getDataFolder() . "data.yml", Config::YAML);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        if (is_null($eco)) {
            $this->getLogger()->warning("Rankup plugin by Taco will not enable unless EconomyAPI is installed.\nDownload here: https://poggit.pmmp.io/p/EconomyAPI/5.7.3-PM4");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }
        $this->economy = $eco;
        $this->getServer()->getCommandMap()->registerAll("Rankup", [
            new RankupCommand(),
            new PrestigeCommand()
        ]);
    }

    public static function getInstance() : self {
        return self::$instance;
    }

    public static function getSessionManager() : SessionManager {
        return self::$sessionManager;
    }

    public static function getRankupUtils() : RankupUtils {
        return self::$rankupUtils;
    }

}