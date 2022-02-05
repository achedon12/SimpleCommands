<?php

namespace achedon\simpleCommands;

use achedon\simpleCommands\commands\feedCMD;
use achedon\simpleCommands\commands\furnaceCMD;
use achedon\simpleCommands\commands\healCMD;
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

        $this->getServer()->getCommandMap()->register('Commands',new feedCMD("feed","feed","/feed"));
        $this->getServer()->getCommandMap()->register('Commands',new healCMD("heal","heal","/heal"));
        $this->getServer()->getCommandMap()->register('Commands',new furnaceCMD("furnace","furnace ","/furnace"));

        PermissionManager::getInstance()->addPermission(new Permission("use.feed"));
        PermissionManager::getInstance()->addPermission(new Permission("use.heal"));
        PermissionManager::getInstance()->addPermission(new Permission("use.furnace"));
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