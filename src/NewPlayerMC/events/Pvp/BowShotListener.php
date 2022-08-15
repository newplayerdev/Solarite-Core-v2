<?php


namespace NewPlayerMC\events;


use pocketmine\event\entity\EntityDamageByChildEntityEvent;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\item\Arrow;
use pocketmine\item\ProjectileItem;
use pocketmine\level\Position;
use pocketmine\level\sound\PopSound;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;

class BowShotListener implements \pocketmine\event\Listener
{
    public function sh(EntityShootBowEvent $ev) {
        $b = $ev->getBow();
        $p = $ev->getEntity();
        $ar = $ev->getProjectile();
        if($p instanceof Player) {
            $pk = new LevelSoundEventPacket();;
            $pk->sound = 63;
            $p->dataPacket($pk);
        }
    }

}