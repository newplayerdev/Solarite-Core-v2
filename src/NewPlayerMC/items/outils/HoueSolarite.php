<?php


namespace NewPlayerMC\items\outils;


use pocketmine\entity\Entity;
use pocketmine\item\Hoe;

class HoueSolarite extends Hoe
{
    public function __construct(int $meta = 0)
    {
        parent ::__construct(294, $meta, "Houe en Solarite", 5);
    }

    public function onAttackEntity(Entity $victim): bool
    {
        return $this -> applyDamage(1);
    }

    public function getMaxDurability(): int
    {
        return 1951;
    }

}