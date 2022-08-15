<?php


namespace NewPlayerMC\commands\warps\tasks;


use NewPlayerMC\Solarite\Main;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\entity\Entity;
use pocketmine\level\particle\PortalParticle;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\Server;

class RtpTask extends \pocketmine\scheduler\Task
{
    public $main;
    public $player;
    public $cl = 3;

    public function __construct(Main $main, Player $player)
    {
        $this->player = $player;
        $this->main = $main;
    }

    public function onRun(int $currentTick)
    {
        if ($this->player instanceof Player) {
            if ($this->cl > 0) {
                $this->player->sendPopup("§aTéléportation en cours...");
                $this->player->getLevel()->addParticle(new PortalParticle(new Vector3($this->player->x, $this->player->y, $this->player->z)));
                $this->player->addEffect(new EffectInstance(Effect::getEffect(Effect::NAUSEA), 20*3, 1));

            } else {
                if(!$this->player->getLevel()->getName() === "map2f") {
                    $this->player->sendMessage("Tu ne peux pas faire cette commande dans ce monde");
                }

                $this->player->teleport(Server::getInstance()->getLevelByName("map2f")->getSafeSpawn(new Vector3(rand(rand(2300, -2300), rand(-2300, 2300)), rand(70, 100), rand(rand(2300, -2300), rand(-2300, 2300)))));
                $this->player->sendMessage("§aTu as bien été téléporté");
                $this->main->getScheduler()->cancelTask($this->getTaskId());
            }
            $this->cl--;
        }
    }
}