<?php


namespace NewPlayerMC\events;


use pocketmine\event\entity\EntityDamageByEntityEvent;

class PvpKnockListener implements \pocketmine\event\Listener
{
    public function pvpKnock(EntityDamageByEntityEvent $ev) {
        $ev->setKnockBack(0.2);
    }

}