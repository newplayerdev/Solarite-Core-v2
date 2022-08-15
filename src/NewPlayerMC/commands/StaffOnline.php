<?php


namespace NewPlayerMC\commands;


use NewPlayerMC\events\JoinListener;
use NewPlayerMC\jobs\JobsListener;
use NewPlayerMC\Solarite\Main;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class StaffOnline extends \pocketmine\command\PluginCommand
{
    public function __construct(Main $owner)
    {
        parent::__construct("staffs", $owner);
        $this->setDescription("Voir la liste des staffs en ligne");
        $this->setUsage("staffs");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
       if($sender instanceof Player) {
           foreach (JoinListener::getInstance()->staffsOnline as $staffs) {
               $count = count(JoinListener::getInstance()->staffsOnline);
               $sender->sendMessage("§cIl y a §6$count §cstaffs en ligne:" . ":§f" . implode("§f, §e", $staffs));
           }
       }
    }

}