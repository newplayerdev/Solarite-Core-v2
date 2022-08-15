<?php


namespace NewPlayerMC\commands;


use pocketmine\block\BlockFactory;
use pocketmine\block\BlockIds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\Player;
use pocketmine\tile\EnderChest;
use pocketmine\tile\Tile;
use pocketmine\utils\TextFormat;

class Ec extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []){
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player){
            $sender->sendMessage("§cTu dois être joueur");
            return false;
        }
        if(!$sender->hasPermission("ec.use")){
            $sender->sendMessage(TextFormat::RED . "Tu n'as pas la permission d'utiliser cette commande");
            return false;
        }
        if(count($args) > 1){
            throw new InvalidCommandSyntaxException();
        }
        if(empty($args[0])){
            $block = BlockFactory::get(BlockIds::ENDER_CHEST);
            $block->x = (int)$sender->x;
            $block->y = (int)$sender->y;
            $block->z = (int)$sender->z;
            $block->level = $sender->level;
            $sender->getLevel()->sendBlocks([$sender], [$block]);
            $tile = Tile::createTile(Tile::ENDER_CHEST, $block->getLevel(), EnderChest::createNBT($block));
            $sender->getEnderChestInventory()->setHolderPosition($tile);
            $sender->addWindow($sender->getEnderChestInventory());
            return true;
        }
        if($this->getPlugin()->getServer()->getPlayer($args[0])){
            if(!$sender->hasPermission("seeec.command")){
                $sender->sendMessage(TextFormat::RED . "Tu n'as pas la permission d'utiliser cette commande");
                return false;
            }
            $player = $this->getPlugin()->getServer()->getPlayer($args[0]);
            $block = BlockFactory::get(BlockIds::ENDER_CHEST);
            $block->x = (int)$sender->x;
            $block->y = (int)$sender->y;
            $block->z = (int)$sender->z;
            $block->level = $sender->level;
            $sender->getLevel()->sendBlocks([$sender], [$block]);
            $tile = Tile::createTile(Tile::ENDER_CHEST, $block->getLevel(), EnderChest::createNBT($block));
            $player->getEnderChestInventory()->setHolderPosition($tile);
            $sender->addWindow($player->getEnderChestInventory());
        }
        else{
            $sender->sendMessage(TextFormat::RED . "Le joueur n'a pas été trouvé");
        }
        return true;
    }

}