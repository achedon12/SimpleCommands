<?php

namespace achedon\simpleCommands;

use achedon\simpleCommands\commands\clearEnderChestCMD;
use achedon\simpleCommands\commands\clearinvCMD;
use achedon\simpleCommands\commands\feedCMD;
use achedon\simpleCommands\commands\furnaceCMD;
use achedon\simpleCommands\commands\healCMD;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class commands extends PluginBase {
    /** @var commands $instance */
    private static $instance;

    protected function onEnable(): void{
        @mkdir($this->getDataFolder());
        self::$instance = $this;
        $this->saveResource("config.yml");

        $this->getServer()->getCommandMap()->registerAll('Commands',[
            new feedCMD("feed","feed","/feed"),
            new healCMD("heal","heal","/heal"),
            new furnaceCMD("furnace","furnace ","/furnace"),
            new clearEnderChestCMD("clearec","clear ec ","/clearec",["ecclear"]),
            new clearinvCMD("clearinv","clear inv ","/clearinv",["invclear"])
        ]);

        $perms = [
            "use.feed",
            "use.heal",
            "use.furnace",
            "use.clearinv",
            "use.invsee"
        ];
        foreach($perms as $perm){
            PermissionManager::getInstance()->addPermission(new Permission($perm));
        }

        if(!InvMenuHandler::isRegistered()){
            InvMenuHandler::register($this);
        }
    }

    protected function onDisable(): void{
        $this->saveResource("config.yml");
    }

    public static function config(): Config{
        return new Config(self::$instance->getDataFolder() . "config.yml", Config::YAML);
    }

    public static function getInstance(): commands{
        return self::$instance;
    }
}