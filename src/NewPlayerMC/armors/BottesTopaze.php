<?php


namespace NewPlayerMC\armors;


use pocketmine\item\ChainBoots;

class BottesTopaze extends ChainBoots
{
    public function getDefensePoints(): int
    {
        return 6;
    }

    public function getMaxDurability(): int
    {
        return 1935;
    }

    public function isUnbreakable(): bool
    {
        return false;
    }
}