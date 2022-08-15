<?php


namespace NewPlayerMC\commands\staff;


use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\Server;

class Broacast extends \pocketmine\command\Command
{


    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender->hasPermission("broacast.use")) {
            $sender->sendMessage("§cTu n'as pas la permission d'utiliser cette commande");
            return false;
        }

        if(count($args) < 1) {
            $sender->sendMessage("Veuillez insérer un message");
            return false;
        }
        Server::getInstance()->broadcastMessage(implode(" ", $args));

        return true;
    }
}