<?php


namespace NewPlayerMC\items;


use pocketmine\item\Item;

class Grenade extends \pocketmine\item\ProjectileItem
{

    public function __construct(int $meta = 0)
    {
        parent::__construct(Item::EGG, $meta, "Grenade");
    }

    public function getMaxStackSize() : int{
        return 1;
    }

    public function getProjectileEntityType() : string{
        return "Egg";
    }

    public function getThrowForce() : float{
        return 5;
    }
}