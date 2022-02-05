<?php

namespace achedon\simpleCommands\commands;

use achedon\simpleCommands\commands;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\CraftingTable;
use pocketmine\block\VanillaBlocks;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\crafting\CraftingManager;
use pocketmine\lang\Translatable;
use pocketmine\network\mcpe\protocol\ContainerOpenPacket;
use pocketmine\network\mcpe\protocol\CraftingEventPacket;
use pocketmine\network\mcpe\protocol\types\inventory\WindowTypes;
use pocketmine\player\Player;
use pocketmine\Server;

class craftCMD extends Command{

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
            if (!$sender->hasPermission("use.craft") && !Server::getInstance()->isOp($sender->getName())) {
                $sender->sendMessage($prefix.$errorPermission);
            }else{
                //TODO: faire la commande
            }
        }
    }

}