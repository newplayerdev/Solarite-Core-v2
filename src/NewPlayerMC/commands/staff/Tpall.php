<?php


namespace NewPlayerMC\commands\staff;


use NewPlayerMC\Solarite\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\Item;
use pocketmine\Player;

class Tpall extends PluginCommand
{
    public $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("tpall", $plugin);
        $this->setDescription("Téléporter tout le monde à vous ou à quelqu'un");
        $this->setUsage("tpall");
        $this->setPermission("core.command.use");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {
            foreach ($this->plugin->getServer()->getOnlinePlayers() as $p) {
                $p->teleport($sender);
            }
            $sender->sendMessage("§aTout le monde a été téléporté");
        }
    }

}