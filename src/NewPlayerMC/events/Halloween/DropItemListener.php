<?php


namespace NewPlayerMC\events\Halloween;


use pocketmine\event\inventory\InventoryPickupArrowEvent;
use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\network\mcpe\protocol\PlayerHotbarPacket;

class DropItemListener implements \pocketmine\event\Listener
{

    public function onDrop(PlayerDropItemEvent $event) {
        $item = $event->getItem();
        if($item->getCustomName() === "§cTerre de la loose") {
            $event->setCancelled(true);
        }
    }

    public function onM(InventoryPickupItemEvent $event) {
         $item = $event->getItem()->getItem();
         if($item->getCustomName() === "§cTerre de la loose") {
             $event->setCancelled(true);
         }
    }

}