<?php


namespace NewPlayerMC\armors;


use pocketmine\item\GoldHelmet;

class CasqueSolarite extends GoldHelmet
{
    public function getDefensePoints(): int
    {
        return 4.5;
    }

    public function getMaxDurability(): int
    {
        return 728;
    }

    public function isUnbreakable(): bool
    {
        return false;
    }
}