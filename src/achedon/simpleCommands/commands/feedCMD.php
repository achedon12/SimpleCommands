<?php

namespace achedon\simpleCommands\commands;

use achedon\simpleCommands\commands;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;

class feedCMD extends Command{

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        $cfg = commands::config();
        $prefix = $cfg->get("Prefix");
        $errorPermission = $cfg->get("ErrorPermission");
        $errorFeed = $cfg->getNested("Feed.error");
        $confirmFeed = $cfg->getNested("Feed.confirm");

       if($sender instanceof Player){
           if(!$sender->hasPermission("use.feed") && !Server::getInstance()->isOp($sender->getName())){
               $sender->sendMessage($prefix.$errorPermission);
           }else{
               if($sender->getHungerManager()->getFood() == $sender->getHungerManager()->getMaxFood()){
                   $sender->sendMessage($prefix.$errorFeed);
               }else{
                   $sender->getHungerManager()->setFood(20);
                   $sender->sendMessage($prefix.$confirmFeed);
               }
           }
       }
    }
}