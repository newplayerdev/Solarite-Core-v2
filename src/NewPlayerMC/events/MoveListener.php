<?php


namespace NewPlayerMC\events;


use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\math\Vector3;

class MoveListener implements Listener
{

public function onMove(PlayerMoveEvent $event)
{
    $player = $event->getPlayer();
    $obsi = Block::get(Block::GLOWING_OBSIDIAN);
    $glow = Item::get(Item::GLOWING_OBSIDIAN)->setCustomName("§fPiège");
    $block = $player->getLevel()->getBlock($player->subtract(0, 1, 0));
    $lvl = $player->getLevel();
    if ($block->getId() === 246) {
        if (!$event->isCancelled()) {
            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::BLINDNESS), 20 * 9999, 9));
            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SLOWNESS), 20 * 9999, 3));
            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::NAUSEA), 20 * 9999, 6));
            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::POISON), 20 * 9999, 2));
            $player->setOnFire(20);
            $lvl->setBlock(new Vector3($block->getX(), $block->getY() + 1, $block->getZ()), Block::get(Block::COBWEB));
            $player->sendPopup("Tu a été pris au piège !");
        } else {

        }

      } elseif ($block->getId() === 29) {
        $player->setMotion($player->getDirectionVector()->multiply(3));

    }
   }

}