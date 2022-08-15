<?php


namespace NewPlayerMC\commands;


use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;
use onebone\economyapi\EconomyAPI;

class Cheque extends \pocketmine\command\Command
{

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {
            if (!$args) {
                $sender->sendMessage("Usage : /cheque <prix>");
                return true;
            }
            if (is_numeric($args[0])) {
                $item = Item::get(Item::PAPER, 0, 1);
                if ($sender->getInventory()->canAddItem($item)) {
                    if (EconomyAPI::getInstance()->myMoney($sender) > $args[0]) {
                        EconomyAPI::getInstance()->reduceMoney($sender->getName(), $args[0]);
                        $item->setCustomName("Chèque");
                        $item->setLore([$args[0] . "$"]);
                        $sender->getInventory()->addItem($item);
                        $sender->sendMessage("§aVotre chèque a bien été crée");
                    }
                }else{
                    $sender->sendMessage("§cIl n'y a pas de places dans votre inventaire  ");
                }
            }else{
                $sender->sendMessage("Usage : /cheque <prix>");
             }
        } else {
            $sender->sendMessage("pas console");
        }
        return true;
    }
}