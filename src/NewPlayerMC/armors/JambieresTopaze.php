<?php


namespace NewPlayerMC\armors;


use pocketmine\item\ChainLeggings;

class JambieresTopaze extends ChainLeggings
{
    public function getDefensePoints(): int
    {
        return 10;
    }

    public function getMaxDurability(): int
    {
        return 2232;
    }

    public function isUnbreakable(): bool
    {
        return false;
    }
}