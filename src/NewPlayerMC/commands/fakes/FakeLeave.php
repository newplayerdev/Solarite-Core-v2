<?php


namespace NewPlayerMC\commands\fakes;


use Grpc\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class FakeLeave extends Command
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
            \pocketmine\Server::getInstance()->broadcastPopup("§c- [§6" . $sender->getName() . "§c]");
            $sender->setGamemode(3);
        } else {
            $sender->sendMessage("pas le droit");
        }
    }

}