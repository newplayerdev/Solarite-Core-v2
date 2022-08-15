<?php


namespace NewPlayerMC\tasks;


use NewPlayerMC\Solarite\Main;
use pocketmine\event\entity\ItemDespawnEvent;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\Player;

class OreRain extends \pocketmine\scheduler\Task
{
    public $player;
    public $plug;
    public $cl = 10;

    public function __construct(Main $plug, Player $player) {
        $this->plug = $plug;
        $this->player = $player;
    }
    public function onRun(int $currentTick)
    {
       if($this->cl > 0) {
           $rand = rand(1, 100);
           $item = 0;
           if($rand >= 1 && $rand <= 2) {
               $item = 266;
           } elseif ($rand >= 2 && $rand <= 20) {
               $item = 264;
           } elseif ($rand >= 20 && $rand <= 55) {
               $item = 265;
           } elseif ($rand >= 55 && $rand <= 100) {
               $item = 263;
           }
           $this->player->getLevel()->dropItem(new Vector3($this->player->getX(), $this->player->getY() +  2, $this->player->getZ()), Item::get($item, 0, 1), null, 20*1);

           $this->player->sendMessage("Temps restant: §6" . $this->cl);
       } else {
           $this->plug->getScheduler()->cancelTask($this->getTaskId());
           $this->player->sendMessage("§cfini");
       }
       $this->cl--;
    }
}