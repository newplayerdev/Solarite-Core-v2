<?php


namespace NewPlayerMC\items;


use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\item\Food;
use pocketmine\item\Item;

class Gourde extends Food
{
    public function __construct()
    {
        parent::__construct(350, 0, "Cooked Fish");
    }

    public function getFoodRestore(): int
    {
        return 1;
    }

    public function getSaturationRestore(): float
    {
        return 1;
    }

    public function requiresHunger(): bool
    {
        return false;
    }
}