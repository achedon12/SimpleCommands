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
        12 => '20:0',
        4 => '1:0',
        392 => '393:0',
        395 => '396:0',
        19 => '19:0',
        319 => '320:0',
        363 => '364:0',
        423 => '424:0',
        411 => '412:0',
        349 => '350:0',
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

        if(!$sender instanceof Player){
            $sender->sendMessage("please execute this command in game");
        }else{
            if(!$sender->hasPermission("use.furnace") && !Server::getInstance()->isOp($sender->getName())){
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
                        case 12:
                            $this->burn(12, $count, $sender);
                            return;
                        case 4:
                            $this->burn(4, $count, $sender);
                            return;
                        case 392:
                            $this->burn(392, $count, $sender);
                            return;
                        case 395:
                            $this->burn(395, $count, $sender);
                            return;
                        case 19:
                            $this->burn(19, $count, $sender);
                            return;
                        case 319:
                            $this->burn(319, $count, $sender);
                            return;
                        case 363:
                            $this->burn(363, $count, $sender);
                            return;
                        case 423:
                            $this->burn(423, $count, $sender);
                            return;
                        case 411:
                            $this->burn(411, $count, $sender);
                            return;
                        case 349:
                            $this->burn(349, $count, $sender);
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
            $sender->sendMessage($cfg->get("Prefix").str_replace(["{count}","{item}"],[$count,$sender->getInventory()->getItemInHand()->getName()],$confirmMessage));
        }
    }
}