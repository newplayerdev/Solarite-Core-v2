<?php


namespace NewPlayerMC\events\Halloween;


use pocketmine\block\Air;
use pocketmine\block\Block;
use pocketmine\entity\Human;
use pocketmine\entity\Zombie;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\math\Vector3;

class CitrouilleHead implements Listener
{
    public function onDrop(EntityDeathEvent $event) {
        $ent = $event->getEntity();
        if($ent instanceof Zombie) {
            $event->setDrops(array(Item::get(Item::PAPER, 0, 1)->setLore(["Key Basique"])));
        }
    }

}