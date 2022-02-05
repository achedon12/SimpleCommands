<?php

namespace achedon\simpleCommands\api;

use muqsit\invmenu\InvMenu;
use pocketmine\player\Player;

class simpleCommandsManager implements simpleCommandsMangerInterface {

    private $admin;

    public function __construct(Player $admin){
        $this->admin = $admin;
    }

    /* Get Player Inventory */
    public function getPlayerInventory(Player $target): InvMenu{
        $menu = InvMenu::create(InvMenu::TYPE_CHEST);
        foreach ($target->getInventory()->getContents() as $value => $item) {
            $menu->getInventory()->setItem($value, $item);
        }
        $menu->setName("§1- §8Inventory of §9{$target->getName()} §1-");
        return $menu;
    }

    /* Get Player EnderChest Inventory */
    public function getPlayerEnderChestInventory(Player $target): InvMenu{
        $menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
        foreach ($target->getEnderInventory()->getContents() as $value => $item) {
            $menu->getInventory()->setItem($value, $item);
        }
        $menu->setName("§1- §8Enderchest of §9{$target->getName()} §1-");
        return $menu;
    }
}