<?php


namespace NewPlayerMC\tasks;


use NewPlayerMC\Solarite\Main;
use pocketmine\entity\Entity;
use pocketmine\Player;

class SneakingTask extends \pocketmine\scheduler\Task
{
    public $player;
    public function __construct(Entity $player) {
        $this->player = $player;
    }

    public function onRun(int $currentTick)
    {
        $cl = 10;
        if($cl > 0) {
          $this->player->setSneaking(true); 
        } else {
            $this->player->setSneaking(false);
            Main::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }
        $cl--;
    }
}