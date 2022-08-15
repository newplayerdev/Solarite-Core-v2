<?php


namespace NewPlayerMC\armors;


use pocketmine\item\Armor;
use pocketmine\item\LeatherBoots;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\utils\Color;

class BottesIterium extends Armor
{
    public function __construct(int $meta = 0)
    {
        parent ::__construct(751, $meta, "Netherite Boots");
    }

    public function getDefensePoints(): int
    {
        return 5;
    }

    public function getMaxDurability(): int
    {
        return 1290;
    }

    public function isUnbreakable(): bool
    {
        return false;
    }
}