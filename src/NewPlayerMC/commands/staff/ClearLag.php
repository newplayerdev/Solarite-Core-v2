<?php


namespace NewPlayerMC\commands\staff;


use NewPlayerMC\Solarite\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\entity\object\ItemEntity;
use pocketmine\Player;

class ClearLag extends PluginCommand
{
    public $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("clearlag", $plugin);
        $this->setPermission("core.commands.clearlag");
        $this->setUsage("clearlag");
        $this->setDescription("Clear toute les entité");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {

            foreach($this->plugin->getServer()->getLevels() as $level) {
                foreach($level->getEntities() as $entity) {
                    $nbEntity= count($level->getEntities());
                    if($entity instanceof ItemEntity) {
                        $entity->close();

                    }
                }
                $sender->sendMessage("§c$nbEntity §fentités ont été supprimées.");
            }

    }

}