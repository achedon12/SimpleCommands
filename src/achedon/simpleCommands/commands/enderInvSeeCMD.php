<?php

namespace achedon\simpleCommands\commands;

use achedon\simpleCommands\commands;
use muqsit\invmenu\InvMenu;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;

class enderInvSeeCMD extends Command{

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        $cfg = commands::config();
        $prefix = $cfg->get("Prefix");
        $errorPermission = $cfg->get("ErrorPermission");

        if (!$sender instanceof Player){
            $sender->sendMessage("please execute this command in game");
        }else{
            if (!$sender->hasPermission("use.invsee") && !Server::getInstance()->isOp($sender->getName())) {
                $sender->sendMessage($prefix.$errorPermission);
            }else{
                if(empty($args) && count($args) != 1){
                    $sender->sendMessage(self::getUsage()." <player>");
                }else{
                    $joueur = Server::getInstance()->getPlayerByPrefix($args[0]);
                    if(!$joueur instanceof Player){
                        $sender->sendMessage($args[0]." is not a player");
                    }else{
                       self::SeePlayerEnderchestInventory($joueur)->send($sender);
                    }
                }
            }
        }
    }

    private function SeePlayerEnderchestInventory(Player $target): InvMenu{

        $menu = InvMenu::create(InvMenu::TYPE_CHEST);
        foreach ($target->getEnderInventory()->getContents() as $value => $item) {
            $menu->getInventory()->setItem($value, $item);
        }
        $menu->setName("§1- §9{$target->getName()}'s §8enderChest §1-");
        $menu->setListener(InvMenu::readonly());
        return $menu;
    }

}