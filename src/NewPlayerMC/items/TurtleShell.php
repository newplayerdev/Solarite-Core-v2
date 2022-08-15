<?php


namespace NewPlayerMC\items;



use pocketmine\item\Item;

class TurtleShell extends Item
{
    public function __construct()
    {
        parent::__construct(468, 0, "Bandages");
    }

    public function getMaxStackSize(): int
    {
        return 16;
    }


}