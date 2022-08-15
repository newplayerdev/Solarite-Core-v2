<?php


namespace NewPlayerMC\armors;


use pocketmine\item\ChainHelmet;

class CasqueTopaze extends ChainHelmet
{

    public function getMaxDurability(): int
    {
        return 1638;
    }

    public function getDefensePoints(): int
    {
        return 6;
    }

    public function isUnbreakable(): bool
    {
        return false;
    }
}