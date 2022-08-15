<?php


namespace NewPlayerMC\events;


use NewPlayerMC\Solarite\Main;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class PoseBlockListener implements Listener
{
    public $main;

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public function onPose(BlockPlaceEvent $event)
    {
        $block = $event->getBlock();
        $item = $event->getItem();
        $player = $event->getPlayer();

        if($block->getId() === 54) {
            $chests = new Config($this->main->getDataFolder() . 'chests.yml', Config::YAML, array(
                "coffre1" => [
                    "x" => $block->getX(),
                    "y" => $block->getY(),
                    "z" => $block->getZ()
                ],
                "propriétaire" => $player->getName()
            ));
            $chests->save();
            if($player->getLevel()->getName() === "map2m2") {
                $event->setCancelled(true);
                $player->sendMessage("§cTu n'as pas le droit de poser ce bloc en minage");
            }
        }
        if($item->getCustomName() === "§cTerre de la loose") {
            $event->setCancelled(true);
        }
    }

}