<?php


namespace NewPlayerMC\armors;


use pocketmine\item\GoldChestplate;

class PlastronSolarite extends GoldChestplate
{

    public function getDefensePoints(): int
    {
        return 9.5;
    }

    public function getMaxDurability(): int
    {
        return 1058;
    }

    public function isUnbreakable(): bool
    {
        return false;
    }
}