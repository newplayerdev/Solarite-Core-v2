<?php


namespace NewPlayerMC\commands\staff;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\level\Position;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\Player;
use pocketmine\Server;

class Tps extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player->hasPermission("tps.solarite.use") && $player instanceof Player) {
            $tps = Server::getInstance()->getTicksPerSecond();
            $player->sendMessage("Le serveur à §6" . $tps . " §fde tps");
        }
   }

}