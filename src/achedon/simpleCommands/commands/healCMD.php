<?php

namespace achedon\simpleCommands\commands;

use achedon\simpleCommands\commands;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;

class healCMD extends Command{

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        $cfg = commands::config();
        $prefix = $cfg->get("Prefix");
        $errorPermission = $cfg->get("ErrorPermission");
        $errorheal = $cfg->getNested("Heal.error");
        $confirmHeal = $cfg->getNested("Heal.confirm");

        if($sender instanceof Player){
            if(!$sender->hasPermission("use.heal") && !Server::getInstance()->isOp($sender->getName())){
                $sender->sendMessage($prefix.$errorPermission);
            }else{
                if($sender->getHealth() == $sender->getMaxHealth()){
                    $sender->sendMessage($prefix.$errorheal);
                }else{
                    $sender->setHealth($sender->getMaxHealth());
                    $sender->sendMessage($prefix.$confirmHeal);
                }
            }
        }
    }
}