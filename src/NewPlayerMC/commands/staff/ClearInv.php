<?php


namespace NewPlayerMC\commands\staff;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;

class ClearInv extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            if(!$sender->hasPermission("clear.use")) {
                $sender->sendMessage("Tu n'as pas la permission d'utiliser cette commande");
                return false;
            }

            if (count($args) > 1) {
                $sender->sendMessage("§cMerci de respecter le nombre d'arguments à fournir");
              return;
            }
            elseif(count($args) < 1) {
               $sender->getInventory()->setContents(array(Item::get(0, 0, 0)));
               $sender->sendMessage("§aVotre inventaire a bien été clear");
               return;
            }
        }

        $name = strtolower(array_shift($args));
        $player = $sender->getServer()->getPlayer($name);
        if ($player instanceof Player) {
            $player->getInventory()->setContents(array(Item::get(0, 0, 0)));
            $sender->sendMessage("§aL'inventaire de " . $player->getName() . " a été clear");
        } else {
            $sender->sendMessage("§cLe joueur n'existe pas ou ne s'est jamais connecté!");
        }
    }

}