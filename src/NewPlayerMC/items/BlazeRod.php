<?php


namespace NewPlayerMC\items;


use pocketmine\item\Item;

class BlazeRod extends Item
{

    public function __construct()
    {
        parent::__construct(369, 0, "Crafts");
    }

    public function getMaxStackSize(): int
    {
        return 1;
    }

}