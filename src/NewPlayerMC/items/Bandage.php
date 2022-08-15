<?php


namespace NewPlayerMC\items;


use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\level\particle\HeartParticle;
use pocketmine\math\Vector3;

class Bandage implements \pocketmine\event\Listener
{
    public function onInteract(PlayerInteractEvent $e) {
        if($e->getItem()->getId() === 468) {
            if($e->getPlayer()->getHealth() === $e->getPlayer()->getMaxHealth()) {
                $e->setCancelled(true);
                $e->getPlayer()->sendPopup("§cTu as déjà toute ta vie");
            }
            $e->getPlayer()->setHealth($e->getPlayer()->getHealth() + 5);
            $e->getPlayer()->getLevel()->addParticle(new HeartParticle(new Vector3($e->getPlayer()->getX(), $e->getPlayer()->getY() + 1, $e->getPlayer()->getZ())));
            $e->getPlayer()->getInventory()->removeItem(Item::get(Item::TURTLE_SHELL_PIECE, 0, 1));
        }
    }

}