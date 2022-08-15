<?php


namespace NewPlayerMC\armors;


use pocketmine\item\GoldLeggings;
use pocketmine\Player;

class JambieresSolarite extends GoldLeggings
{
    public function getDefensePoints(): int
    {
        return 7.5;
    }

    public function getMaxDurability(): int
    {
        return 992;
    }

    public function isUnbreakable(): bool
    {
        return false;
    }

    public function onReleaseUsing(Player $player): bool
    {
        return parent::onReleaseUsing($player); // TODO: Change the autogenerated stub
    }
}