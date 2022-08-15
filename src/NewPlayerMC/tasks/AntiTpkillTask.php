<?php


namespace NewPlayerMC\tasks;


use NewPlayerMC\Solarite\Main;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\Player;

class AntiTpkillTask extends \pocketmine\scheduler\Task implements \pocketmine\event\Listener
{

    public $cl = 4;
    public $player;
    public $plugin;

    public function __construct(Main $plugin, Player $player) {
        $this->player = $player;
        $this->plugin = $plugin;
    }

    public function onRun(int $currentTick)
    {
        if($this->cl > 0) {
         $this->player->setInvisible(true);
        } else {
            $this->player->setInvisible(false);
            $this->plugin->getScheduler()->cancelTask($this->getTaskId());
        }
        $this->cl--;
    }
}