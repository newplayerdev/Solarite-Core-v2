<?php


namespace NewPlayerMC\armors;


use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\GoldBoots;

class BottesSolarite extends GoldBoots
{
   public function getDefensePoints(): int
   {
      return 4.5;
   }

   public function getMaxDurability(): int
   {
      return 860;
   }

   public function isUnbreakable(): bool
   {
      return false;
   }
}