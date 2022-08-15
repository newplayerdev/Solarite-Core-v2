<?php


namespace NewPlayerMC\commands\particlemod\tasks;


use NewPlayerMC\Solarite\Main;
use pocketmine\level\particle\LavaParticle;
use pocketmine\math\Vector3;
use pocketmine\Player;

class FireParticleTask extends \pocketmine\scheduler\Task
{
    public $plugin;
    public $player;

    public function __construct(Main $plugin, Player $player)
    {
        $this->plugin = $plugin;
        $this->player = $player;
    }

    public function onRun(int $currentTick)
    {
       $player = $this->player;
       $player->getLevel()->addParticle(new LavaParticle(new Vector3($player->getX(), $player->getY(), $player->getZ())));
    }
}