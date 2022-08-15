<?php


namespace NewPlayerMC\commands\fakes;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;

class FakeJoin extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender->hasPermission("fake.use")) {
            $sender->sendMessage("Tu n'as pas la permission d'utiliser cette commande");
            return false;
        }

        if($sender instanceof Player) {
            Server::getInstance()->broadcastMessage("§e" . $sender->getName() . " a rejoint la partie");
            $sender->setGamemode(1);
        } else {
            $sender->sendMessage("pas le droit");
        }

    }

}