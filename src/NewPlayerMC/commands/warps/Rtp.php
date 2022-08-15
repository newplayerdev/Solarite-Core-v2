<?php


namespace NewPlayerMC\commands\warps;


use NewPlayerMC\commands\warps\tasks\RtpTask;
use NewPlayerMC\Solarite\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class Rtp extends PluginCommand
{
    public $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("rtp", $plugin);
        $this->plugin = $plugin;
        $this->setDescription("Se téléporter aléatoirement dans la map");
        $this->setUsage("rtp");
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player instanceof Player) {
           $this->plugin->getScheduler()->scheduleRepeatingTask(new RtpTask($this->plugin, $player), 20*3);
        }

    }

}