<?php


namespace NewPlayerMC\commands\gamemode;


use http\Exception\InvalidArgumentException;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\Player;

class GmcCmd extends \pocketmine\command\Command
{

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {
            if(!$sender->hasPermission("gmc.use")) {
                $sender->sendMessage("§cTu n'as pas la permission d'utiliser cette commande");
                return false;
            }

         if(empty($args)) {
             $sender->setGamemode(1);
         } else {
             throw new InvalidArgumentException();
         }
        } else {
            $sender->sendMessage("Pas console");
        }

    }
}