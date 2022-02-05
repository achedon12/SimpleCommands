<?php

namespace achedon\simpleCommands\api;

use muqsit\invmenu\InvMenu;
use pocketmine\player\Player;

interface simpleCommandsMangerInterface{

    /**
     * get player inventory
     * @param Player $target
     * @return InvMenu
     */
    public function getPlayerInventory(Player $target): InvMenu;

    /**
     * get player enderchest inventory
     * @param Player $target
     * @return InvMenu
     */
    public function getPlayerEnderChestInventory(Player $target): InvMenu;
}