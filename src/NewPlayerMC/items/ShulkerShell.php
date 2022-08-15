<?php


namespace NewPlayerMC\items;


use pocketmine\item\Item;

class ShulkerShell extends \pocketmine\item\Item
{
    public function __construct()
    {
        parent::__construct(445, 0, "Seringue");
    }

    public function getMaxStackSize(): int
    {
        return 8;
    }

}