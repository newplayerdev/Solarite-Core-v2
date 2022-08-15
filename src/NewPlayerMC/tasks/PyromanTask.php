<?php


namespace NewPlayerMC\tasks;


use NewPlayerMC\Solarite\Main;
use pocketmine\block\BlockFactory;
use pocketmine\Player;

class PyromanTask extends \pocketmine\scheduler\Task
{

    public $player;

    public function  __construct(Player $player) {
        $this->player = $player;
    }
    public function onRun(int $currentTick)
    {
        $cl= 10;
        if($cl > 0) {
            $block = $this->player->getLevel()->getBlock($this->player->getPosition());
            $this->player->getLevel()->setBlock($block->asVector3(), BlockFactory::get(0, 0));
        } else {
            Main::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }
        $cl--;
     }
}