<?php

namespace NewPlayerMC\commands\factions;


use NewPlayerMC\jobs\JobsListener;
use NewPlayerMC\Solarite\Main;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use pocketmine\utils\Config;

class RecrutementCommand extends \pocketmine\command\PluginCommand
{

    public $recruts;
    public $name;
    public $joueur;

    public function __construct(Main $owner)
    {
        parent::__construct("recrutements", $owner);
        $this->setUsage("recrutement");
        $this->setDescription("Poster un avis de recrutement ou chercher une faction");
        $this->setAliases(['rc']);
        @mkdir($owner->getDataFolder());
        $owner->saveResource('profils.yml');
        $this->recruts = new Config($owner->getDataFolder() . 'profils.yml', Config::YAML);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {
            $this->mainRcForm($sender);
        }
    }

    public function mainRcForm(Player $player)
    {
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    $this->findProfilForm($player);
                    break;
                case 1:
                    $this->profilCreateForm($player);
                    break;
                case 2:
                    break;
            }
        });
        $f->setTitle("§c[§rRecrutements§c]");
        $f->addButton("§c»§f Recruter un joueur");
        $f->addButton("§c»§f Créer un profil");
        $f->addButton('§c§lFermer');
        $f->sendToPlayer($player);
        return $f;
    }

    public function profilCreateForm($player)
    {
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if($result === null) {
               return true;
            }
            switch ($result) {
                case 0:
                    if ($this->recruts->exists($player->getName())) {
                        $player->sendMessage("§cTu as déjà crée un profil!");
                        return true;
                    }
                    $player->sendMessage("§aTon profil a bien été crée");
                    $this->recruts->set($player->getName(), $player->getName());
                    $this->recruts->save();
                    break;
                case 1:
                    $this->mainRcForm($player);
                    break;
             }
        });
        $f->setTitle("§c[§rRecrutements§c]");
        $f->setContent("En créent votre profil, les factions recherchent des membres pourront le voir et voir vos niveaux de métiers");
        $f->addButton("Créer un profil");
        $f->addButton("§c§lRetour");
        $f->sendToPlayer($player);
        return $f;
    }

    public function findProfilForm($player)
    {
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if($result === null) {
                return true;
            }
            if($result === 0) {
                $this->mainRcForm($player);
            }elseif ($result >= 1 && $result->isOnline() === true) {
                Server::getInstance()->dispatchCommand($player, "f invite $result");
            }
        });
        $f->setTitle("§c[§rRecrutements§c]");
        $f->addButton("§c§lRetour");
        foreach ($this->recruts->getAll() as $profil) {
            $f->addButton("$profil");
        }
        $f->sendToPlayer($player);
        return $f;
    }

}