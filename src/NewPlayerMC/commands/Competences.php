<?php


namespace NewPlayerMC\commands;


use jojoe77777\FormAPI\SimpleForm;
use NewPlayerMC\Solarite\Main;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class Competences extends \pocketmine\command\PluginCommand
{
    public $main;
    public function __construct(Main $main)
    {
        parent::__construct("competences", $main);
        $this->setUsage("competences");
        $this->setDescription("Voir vos compétences dans différents domaines");
        $this->setAliases(["competence", "cp"]);
        $this->main = $main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {
            $form = new SimpleForm(function (Player $player, $data) {
                if($data === null) {
                    return true;
                }
                switch ($data) {
                    case 0:
                        $this->main->agriculteurUI($player);
                        break;
                    case 1:
                        $this->main->assassinUI($player);
                        break;
                    case 2:
                        $this->main->forgeronUI($player);
                        break;
                    case 3:
                        $this->main->mineurUI($player);
                        break;

                }
            });
            $form->setTitle("§c[§fCompétences§c]");
            $form->setContent("Choisissez votre compétence: ");
            $form->addButton("§c»§f Agriculteur", 0, "textures/other/agriculteur");
            $form->addButton("§c»§f Assassin", 0, "textures/other/assassin");
            $form->addButton("§c»§f Forgeron", 0, "textures/other/forgeron");
            $form->addButton("§c»§f Mineur", 0, "textures/other/mineur");
            $form->addButton("§c»§f Annuler");
        }
    }

}