<?php

namespace achedon\simpleCommands\commands;

use achedon\simpleCommands\commands;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;

class clearEnderChestCMD extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        $cfg = commands::config();
        $prefix = $cfg->get("Prefix");
        $errorPermission = $cfg->get("ErrorPermission");
        $confirmClear = $cfg->getNested("Clear.enderChest.confirm");
        $confirmSend = $cfg->getNested("Clear.enderChest.send");

        if (!$sender instanceof Player) {
            $sender->sendMessage("please execute this command in game");
        }else{
            if (!$sender->hasPermission("use.clearinv") && !Server::getInstance()->isOp($sender->getName())) {
                $sender->sendMessage($prefix. $errorPermission);
            }else{
                if (empty($args)) {
                    $sender->getEnderInventory()->clearAll();
                    $sender->sendMessage($prefix.$confirmClear);
                } else {
                    if (count($args) != 1) {
                        $sender->sendMessage(self::getUsage()." <player>");
                    }else{
                        $joueur = Server::getInstance()->getPlayerByPrefix($args[0]);
                        if (!$joueur instanceof Player) {
                            $sender->sendMessage($args[0]." is not a player");
                        }else{
                            $joueur->getEnderInventory()->clearAll();
                            $joueur->sendMessage($prefix.str_replace("{player}", $joueur->getName(), $confirmClear));
                            $sender->sendMessage($prefix.str_replace("{player}", $joueur->getName(), $confirmSend));
                        }
                    }
                }

            }
        }
    }
}