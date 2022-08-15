<?php


namespace NewPlayerMC\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Repair extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {

        if(!$sender instanceof Player) return false;
        if(!$this->hasPermissions($sender)){
            $sender->sendMessage(TextFormat::RED . "Tu n'as pas la permission d'utiliser cette commande");
            return false;
        }

        if(count($args) > 1){
            throw new InvalidCommandSyntaxException();
        }

        if(empty($args)){
            $itemInHand=$sender->getInventory()->getItemInHand();
            $index = $sender->getInventory()->getHeldItemIndex();
            if($itemInHand instanceof Tool || $itemInHand instanceof Armor){
                if($itemInHand->getDamage() > 0) {
                    $sender->getInventory()->setItem($index, $itemInHand->setDamage(0));
                    $sender->sendMessage(TextFormat::GREEN . "Votre item a été réparé!");
                    return true;
                }
            }
            $sender->sendMessage(TextFormat::RED . "Cet item ne peut pas être réparé");
            return false;
        }

        if($args[0] == "all"){
            foreach ($sender->getInventory()->getContents() as $index => $item){
                if($item instanceof Tool || $item instanceof Armor){
                    if($item->getDamage() > 0) {
                        $sender->getInventory()->setItem($index, $item->setDamage(0));
                    }
                }
            }

            foreach($sender->getArmorInventory()->getContents() as $index => $item){
                if($item instanceof Tool || $item instanceof Armor){
                    if($item->getDamage() > 0){
                        $sender->getArmorInventory()->setItem($index, $item->setDamage(0));
                    }
                }
            }
            $sender->sendMessage(TextFormat::GREEN . "Tous vos items on été réparé!");
        }
        return true;
    }

    public function hasPermissions(Player $sender):bool {
        return $sender->hasPermission("repair.use");
    }

}