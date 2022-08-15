<?php


namespace NewPlayerMC\commands\warps\tasks;


use NewPlayerMC\Solarite\Main;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\Player;
use pocketmine\scheduler\Task;

class SpawnTask extends Task
{
    public $player;
    private $plugin;
    public $cl = 3;


    public function __construct(Main $plugin,Player $player)
    {
        $this->plugin = $plugin;
        $this->player = $player;
    }

    public function onRun(int $tick)
    {
        if ($this->player instanceof Player) {
            if ($this->cl > 0) {
                $this->player->sendPopup("§aTéléportation en cours...§f\n§7Merci de ne pas bouger pendant la téléportation");
            } else {
                $this->player->teleport($this->player->getServer()->getDefaultLevel()->getSafeSpawn());
                $this->player->sendMessage("§fTu as bien été téléporté au spawn! §c«");
                $this->plugin->getScheduler()->cancelTask($this->getTaskId());
            }
        $this->cl--;
    }
 }
}