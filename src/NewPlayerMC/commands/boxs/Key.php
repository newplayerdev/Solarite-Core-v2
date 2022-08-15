<?php


namespace NewPlayerMC\commands\boxs;


use NewPlayerMC\Solarite\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use NewPlayerMC\events\JoinListener;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;

class Key extends PluginCommand
{
    public $owner;

    public function __construct(Main $owner)
    {
        $this->owner = $owner;
        parent::__construct("key", $owner);
        $this->setUsage("key <joueur> <nombre> <type>");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
            if (!$sender->hasPermission("key.core.use")) {
                $sender->sendMessage("§cTu n'as pas la permission d'utiliser cette commande");
                return true;
            }
            if (count($args) < 2) {
                $sender->sendMessage("Usage: /key [joueur] [nombre] [type]");
                return true;
            }

            $player = $sender->getServer()->getPlayer($args[0]);
            if ($player instanceof Player) {
                if(!is_numeric($args[1])) {
                    $sender->sendMessage("Usage: /key [joueur] [nombre] [type]");
                    return true;
                }
              $player->getInventory()->addItem();
            } else {
                $sender->sendMessage("§cCe jouer n'existe pas ou ne s'est jamais connecté");
                return true;
            }
       }
}