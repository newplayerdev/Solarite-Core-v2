<?php


namespace NewPlayerMC\commands\staff;


use NewPlayerMC\Solarite\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\command\utils\CommandException;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class GiveAll extends PluginCommand
{

    public $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("giveall", $plugin);
        $this->setDescription("Téléporter tout le monde à vous ou à quelqu'un");
        $this->setUsage("tpall");
        $this->setPermission("core.command.use");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {
            foreach ($this->plugin->getServer()->getOnlinePlayers() as $p) {
                $p->getInventory()->addItem($sender->getInventory()->getItemInHand());
            }
            $sender->sendMessage("§aTout le monde a été téléporté");
        }
    }
}