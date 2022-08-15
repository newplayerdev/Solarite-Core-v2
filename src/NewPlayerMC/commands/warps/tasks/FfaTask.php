<?php


namespace NewPlayerMC\commands\warps\tasks;


use NewPlayerMC\Solarite\Main;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\particle\PortalParticle;
use pocketmine\math\Vector3;
use pocketmine\Player;

class FfaTask extends \pocketmine\scheduler\Task
{

    private $player;
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
                $this->player->sendPopup("§aTéléportation en cours...");
                $this->player->getLevel()->addParticle(new PortalParticle(new Vector3($this->player->x, $this->player->y, $this->player->z)));
                $this->player->addEffect(new EffectInstance(Effect::getEffect(Effect::NAUSEA), 20*3, 1));
            } else {
                $this->player->teleport($this->player->getServer()->getLevelByName("map2ffa")->getSafeSpawn());
                $this->player->sendMessage("§fTu as bien été téléporté au spawn! §c«");
                $this->plugin->getScheduler()->cancelTask($this->getTaskId());
            }
            $this->cl--;
        }
    }
}