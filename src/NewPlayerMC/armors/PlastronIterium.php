<?php


namespace NewPlayerMC\armors;


use pocketmine\item\Armor;
use pocketmine\item\LeatherTunic;

class PlastronIterium extends Armor
{
    public function __construct()
    {
        parent::__construct(749, 0, "Netherite Chestplate");
    }

    public function getDefensePoints(): int
    {
        return 11;
    }

    public function getMaxDurability(): int
    {
        return 1587;
    }

    public function isUnbreakable(): bool
    {
        return false;
    }

}