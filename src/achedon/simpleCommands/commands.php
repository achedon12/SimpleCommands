<?php

namespace achedon\simpleCommands;

use achedon\simpleCommands\commands\clearEnderChestCMD;
use achedon\simpleCommands\commands\clearinvCMD;
use achedon\simpleCommands\commands\craftCMD;
use achedon\simpleCommands\commands\ecCMD;
use achedon\simpleCommands\commands\enderInvSeeCMD;
use achedon\simpleCommands\commands\feedCMD;
use achedon\simpleCommands\commands\furnaceCMD;
use achedon\simpleCommands\commands\healCMD;
use achedon\simpleCommands\commands\invseeCMD;
use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginOwned;
use pocketmine\utils\Config;

class commands extends PluginBase implements PluginOwned{
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
            new clearinvCMD("clearinv","clear inv ","/clearinv",["invclear"]),
            new ecCMD("ec","ec","/ec"),
            new craftCMD("craft","craft","/craft"),
            new invseeCMD("invsee","see inventory","/invsee",["seeinv"]),
            new enderInvSeeCMD("enderinvsee","see enderchest inventory","/enderinvsee",["ecsee","seeec"]),
        ]);

        $perms = [
            "use.feed",
            "use.heal",
            "use.furnace",
            "use.clearinv",
            "use.ec",
            "use.craft",
            "use.invsee"
        ];
        foreach($perms as $perm){
            PermissionManager::getInstance()->addPermission(new Permission($perm));
        }
    }

    protected function onDisable(): void{
        $this->saveResource("config.yml");
    }

    public static function config(): Config{
        return new Config(self::$instance->getDataFolder() . "config.yml", Config::YAML);
    }

    /** @return commands*/
    public static function getInstance(): commands{
        return self::$instance;
    }

    public function getOwningPlugin(): Plugin{
        return self::getInstance();
    }
}