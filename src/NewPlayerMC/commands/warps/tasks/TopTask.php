<?php


namespace NewPlayerMC\commands\warps\tasks;


use NewPlayerMC\Solarite\Main;
use pocketmine\level\Position;
use pocketmine\Player;

class TopTask extends \pocketmine\scheduler\Task
{
    public $plugin;
    public $player;
    public $cl = 3;

    public function __construct(Main $plugin, Player $player)
    {
        $this->plugin = $plugin;
        $this->player = $player;
    }

    public function onRun(int $currentTick)
    {
        $player = $this->player;
        if($player instanceof Player) {
            if(!$player->hasPermission("top.use")) {
                $player->sendMessage("§cVous n'avez pas la permission d'utiliser cette commande.");
            }
            if($this->cl > 0) {
                $this->player->sendPopup("§aTéléportation en cours...");
            } else {
                $x = $player->getX();
                $z = $player->getZ();
                $y = $player->getLevel()->getHighestBlockAt($x, $z);
                $player->teleport($player->getLevel()->getSafeSpawn(new Position($x, $y, $z, $player->getLevel())));
                $this->plugin->getScheduler()->cancelTask($this->getTaskId());
            }
            $this->cl--;
        }
    }
}