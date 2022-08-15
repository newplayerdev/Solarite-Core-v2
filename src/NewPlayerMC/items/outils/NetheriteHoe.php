<?php


namespace NewPlayerMC\items\outils;


use pocketmine\entity\Entity;

class NetheriteHoe extends \pocketmine\item\Hoe
{
    public function __construct(int $meta = 0)
    {
        parent::__construct(747, $meta, "Netherite Hoe", 5);
    }

    public function onAttackEntity(Entity $victim): bool
    {
        return $this->applyDamage(1);
    }

    public function getMaxDurability(): int
    {
        return 2439;
    }

}