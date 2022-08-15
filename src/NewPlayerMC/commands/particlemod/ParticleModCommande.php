<?php


namespace NewPlayerMC\commands\particlemod;


use NewPlayerMC\commands\particlemod\tasks\FireParticleTask;
use NewPlayerMC\Solarite\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;

class ParticleModCommande extends \pocketmine\command\PluginCommand
{
    public $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct("particlemod", $plugin);
        $this->setDescription("Ouvrir le menu des particules");
        $this->setUsage("particlemod");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {
            $sender->sendMessage("§cÀ venir");
        }
    }

    public function particleModForm($player) {
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                  if($player->hasPermission("fire.particlemod.use")) {
                    $this->plugin->getScheduler()->scheduleRepeatingTask(new FireParticleTask($this, $player), 20*999999);
                  } else {
                      $player->sendMessage("§cTu n'as pas la permission d'utiliser cette commande");
                  }
                    break;
                case 1:
                    $this->plugin->getScheduler()->cancelTask($this->plugin->getScheduler()->scheduleRepeatingTask(new FireParticleTask())->getTaskId());
                    break;
            }
        });
        $f->setTitle("§c[§rBox Basique§c]");
        $f->setContent("Choisis les particules que tu veux avoir");
        $f->addButton("§c» §6Particules de feu§c «\n§fCliquer pour mettre");
        $f->addButton("§l§cAnnuler");
        $f->sendToPlayer($player);
        return $f;
    }

}