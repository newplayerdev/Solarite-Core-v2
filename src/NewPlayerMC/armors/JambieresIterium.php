<?php


namespace NewPlayerMC\armors;


use pocketmine\item\Armor;
use pocketmine\item\LeatherPants;

class JambieresIterium extends Armor
{

    public function __construct()
    {
        parent::__construct(750, 0, "Netherite Leggings");
    }

    public function getDefensePoints(): int
    {
        return 8.7;
    }

    public function getMaxDurability(): int
    {
        return 1488;
    }

    public function isUnbreakable(): bool
    {
        return false;
    }
}