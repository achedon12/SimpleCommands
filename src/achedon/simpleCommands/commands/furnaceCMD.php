<?php

namespace achedon\simpleCommands\commands;

use achedon\simpleCommands\commands;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\ItemFactory;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;

class furnaceCMD extends Command{

    private array $equal = [
        15 => '265:0',
        14 => '266:0',
        56 => '264:0',
        21 => '351:4',
        73 => '331:0',
        16 => '263:0',
        129 => '388:0',
    ];

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        $cfg = commands::config();
        $prefix = $cfg->get("Prefix");
        $errorPermission = $cfg->get("ErrorPermission");
        $errorMessage = $cfg->getNested("Furnace.noblockInHand");
        $errorItem = $cfg->getNested("Furnace.errorItemInHand");

        if($sender instanceof Player){
            if(!$sender->hasPermission("use.furnace") && !Server::getInstance()->isOp($sender)){
                $sender->sendMessage($prefix.$errorPermission);
            }else{
                if (isset($this->equal[$sender->getInventory()->getItemInHand()->getId()])) {
                    $block = $sender->getInventory()->getItemInHand();
                    $count = $block->getCount();
                    switch ($block->getId()) {
                        case 15:
                            $this->burn(15, $count, $sender);
                            return;
                        case 14:
                            $this->burn(14, $count, $sender);
                            return;
                        case 56:
                            $this->burn(56, $count, $sender);
                            return;
                        case 21:
                            $this->burn(21, $count, $sender);
                            return;
                        case 73:
                            $this->burn(73, $count, $sender);
                            return;
                        case 16:
                            $this->burn(16, $count, $sender);
                            return;
                        case 129:
                            $this->burn(129, $count, $sender);
                            return;
                    }
                    $sender->sendMessage($prefix.$errorMessage);
                } else {
                    $sender->sendMessage($prefix.$errorItem);
                }
            }
        }
    }

    private function burn(int $id, int $count, Player $sender){
        $cfg = commands::config();
        $confirmMessage = $cfg->getNested("Furnace.confirmFurnace");
        if ($sender->getInventory()->getItemInHand()->getId() === $id) {
            (int)$equalId = explode(':', $this->equal[$id])[0];
            (int)$equalDamage = explode(':', $this->equal[$id])[1];
            $burnItem = ItemFactory::getInstance()->get($equalId, $equalDamage, $count);
            $sender->getInventory()->setItemInHand($burnItem);
            $sender->sendMessage(str_replace(["{count},{item}"],[$count,$sender->getInventory()->getItemInHand()->getName()],$cfg->get("Prefix").$confirmMessage));
        }
    }
}