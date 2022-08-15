<?php


namespace NewPlayerMC\events;


use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\item\ItemIds;

class InventoryTransactionListener implements \pocketmine\event\Listener
{

    public function transacEvent(InventoryTransactionEvent $event)
    {
        if($event instanceof InventoryPickupItemEvent)
        {
          if($event->getItem()->getItem()->getId() === 3 && $event->getItem()->getItem()->getCustomName() === "§cTerre de la loose") {

          }
        }
    }

}