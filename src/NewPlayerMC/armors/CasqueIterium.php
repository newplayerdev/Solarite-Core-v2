<?php


namespace NewPlayerMC\armors;


use pocketmine\item\Armor;
use pocketmine\item\LeatherCap;

class CasqueIterium extends Armor
{
    public function __construct()
    {
        parent::__construct(748, 0, "Netherite Helmet");
    }

    public function getDefensePoints(): int
    {
        return 5;
    }

    public function getMaxDurability(): int
    {
        return 1092;
    }

    public function isUnbreakable(): bool
    {
        return false;
    }
}