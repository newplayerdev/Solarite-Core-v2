<?php


namespace NewPlayerMC\events\worlds;


use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\Player;

class LimitPlayersWolrdListener implements \pocketmine\event\Listener
{
    public function limitPlayer(EntityLevelChangeEvent $ev) {
        $player = $ev->getEntity();
        if($ev->getTarget()->getFolderName() === "map2m" && count($ev->getTarget()->getPlayers()) > 25) {
            if($player instanceof Player) {
                $player->sendMessage("§c» §fCe monde est plein! Merci d'attendre que quelqu'un se déconnecte ou change de monde");
                $ev->setCancelled(true);
            }
        }
    }

}