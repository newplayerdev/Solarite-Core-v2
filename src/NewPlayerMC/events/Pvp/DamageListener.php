<?php


namespace NewPlayerMC\events;


use NewPlayerMC\Solarite\Main;
use NewPlayerMC\tasks\SneakingTask;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\item\ItemIds;
use pocketmine\Player;

class DamageListener implements Listener
{

    public function onDamage(EntityDamageEvent $event) {

        $player = $event->getEntity();

        if($player instanceof Player) {
            if ($event->getEntity()->getInventory()->getItemInHand()->getId() === 415) {
                if ($event->getCause() === EntityDamageEvent::CAUSE_FALL) {

                    $event->setCancelled();

                } else {
                }
            }
            if ($event->getEntity()->getInventory()->getItemInHand()->getId() === 369) {
                if ($event->getCause() === EntityDamageEvent::CAUSE_FALL) {

                    $event->setCancelled();

                }
            }
            if($event instanceof EntityDamageByEntityEvent) {
                 $damager = $event->getDamager();
                 if($damager instanceof Player) {
                     if($event->getEntity() instanceof Player) {
                         if ($damager->getInventory()->getItemInHand()->getId() === ItemIds::ENCHANTED_BOOK && $damager->getInventory()->getItemInHand()->getCustomName() === "§dRampant") {
                             Main::getInstance()->getScheduler()->scheduleRepeatingTask(new SneakingTask($event->getEntity()), 20);
                             $damager->getInventory()->removeItem($damager->getInventory()->getItemInHand()->setCount(1));
                         }
                     }
                     if ($damager->getInventory()->getItemInHand()->getId() === ItemIds::ENCHANTED_BOOK && $damager->getInventory()->getItemInHand()->getCustomName() === "§dRépulsion") {
                         $event->setKnockBack(2);
                         $damager->getInventory()->removeItem($damager->getInventory()->getItemInHand()->setCount(1));

                     }
                 }
            }
        }
    }

}