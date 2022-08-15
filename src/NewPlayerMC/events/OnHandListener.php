<?php


namespace NewPlayerMC\events;


use pocketmine\block\Block;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\item\Item;
use pocketmine\level\format\Chunk;
use pocketmine\Player;

class OnHandListener implements Listener
{
    public function onHand(PlayerItemHeldEvent $event)
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        if ($item->getId() == Item::RABBIT_HIDE) {
            if (!$player->isOnline()) {
                $player->removeEffect(24);
            } elseif ($event->isCancelled()) {
                $player->removeEffect(24);
            }
            $eff = new EffectInstance(Effect::getEffect(Effect::LEVITATION), 100 * 99999, -3, true);
            $player->addEffect($eff);
        } elseif ($item->getId() === 1000) {
            $chunk=$this->getChunkFromPlayer($event->getPlayer());
            $numberOfChest=$this->getNumberOfChestInChunk($chunk);
            $event->getPlayer()->sendTip("Il y a $numberOfChest coffre(s) dans ton chunck");

        }

    }

    private function getNumberOfChestInChunk(Chunk $chunk):int{
        $numberOfChest=0;
        for ($y = 0; $y < 256; $y++) {
            for ($x = 0; $x < 16; $x++) {
                for ($z = 0; $z < 16; $z++) {
                    $blockId = $chunk->getBlockId($x, $y, $z);
                    if($blockId===Block::CHEST){
                        $numberOfChest++;
                    }
                }
            }
        }
        return $numberOfChest;
    }
    private function getChunkFromPlayer(Player $player): Chunk{
        return $player->getLevel()->getChunk($player->getX() >> 4, $player->getZ() >> 4);
    }

}