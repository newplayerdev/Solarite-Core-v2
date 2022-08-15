<?php


namespace NewPlayerMC\commands\warps;


use NewPlayerMC\commands\warps\tasks\TopTask;
use NewPlayerMC\Solarite\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class Top extends PluginCommand
{
    public $plugin;
    private $time = [];

    public function __construct(Main $plugin)
    {
        parent::__construct("top", $plugin);
        $this->setDescription("Se téléporter au bloc le plus haut");
        $this->setUsage("top");
        $this->setPermission("top.cmd.use");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player instanceof Player) {
            if (isset($this->time[$player->getName()])){
                if ($this->time[$player->getName()] <= time()){
                    $this->time[$player->getName()] = time() + 120;
                }else{
                    $time = $this->time[$player->getName()] - time();
                    $time = gmdate("i:s",$time);
                    $player->sendMessage("La commande est en cooldown, merci d'attendre encore {$time} minute(s)");
                    return;
                }
            }
            $this->plugin->getScheduler()->scheduleRepeatingTask(new TopTask($this->plugin, $player), 20);
            $this->time[$player->getName()] = time() + 120;
        }

    }

}