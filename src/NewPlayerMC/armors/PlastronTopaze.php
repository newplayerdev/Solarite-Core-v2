<?php


namespace NewPlayerMC\armors;


use pocketmine\item\ChainChestplate;

class PlastronTopaze extends ChainChestplate
{
    public function getDefensePoints(): int
    {
        return 13;
    }

    public function getMaxDurability(): int
    {
        return 2380;
    }

    public function isUnbreakable(): bool
    {
        return false;
    }
}