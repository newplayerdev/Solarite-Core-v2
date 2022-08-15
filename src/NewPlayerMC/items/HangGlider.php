<?php


namespace NewPlayerMC\items;


use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;

class HangGlider implements \pocketmine\event\Listener
{
    public function ItemHeld(PlayerItemHeldEvent $event) {
        $player = $event->getPlayer();
        $item = $event->getItem();
        if($item->getId() == Item::RABBIT_HIDE){

            $eff = new EffectInstance(Effect::getEffect(Effect::LEVITATION), 100 * 99999, -3, true);
            $player->addEffect($eff);

        } elseif($event->isCancelled()) {
            $player->removeEffect(24);
        }
    }

    public function onDamage(EntityDamageEvent $event) {

                if ($event->getCause() === EntityDamageEvent::CAUSE_FALL && $event->getEntity()->getInventory()->getItemInHand()->getId() === 415){

                    $event->setCancelled();

                }
    }



    public function onQuit(PlayerQuitEvent $event) {
        $player = $event->getPlayer();
        $item = $player->getInventory()->getItemInHand();

        if($item->getId() == ItemIds::RABBIT_HIDE){
            $player->removeEffect(24);
        }
    }

}