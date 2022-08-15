<?php


namespace NewPlayerMC\commands\atm;


use NewPlayerMC\Solarite\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\Server;
use onebone\economyapi\EconomyAPI;

class ATMCommand extends PluginCommand
{
    public $atm;

    public function __construct(Main $atm)
    {
        parent::__construct("atm", $atm);
        $this->setDescription("Voir combien vous avez sur votre atm");
        $this->setUsage("atm");
        $this->atm = $atm;
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player instanceof Player) {
         $this->atmForm($player);
        } else {
            $player->sendMessage("pas console");
        }
    }

    public function atmForm(Player $player) {
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    EconomyAPI::getInstance()->addMoney($player, $this->atm->getConfig()->getAll()[$player->getName()]["atm"]);
                    $player->sendMessage("§c»§fTu as bien récupérer §6" . $this->atm->getConfig()->getAll()[$player->getName()]["atm"] . "$ §f!");
                    $this->atm->getConfig()->set($this->atm->getConfig()->getAll()[$player->getName()]["atm"], 0);
                    $this->atm->saveConfig();
                    break;
                case 1:
                    $this->upgradeAtmForm($player);
                    break;
                case 2:
                    $player->sendMessage("§c»§aTu viens de quitter l'atm");
                    break;
            }
        });
        $f->setTitle("§c[§rATM§c]");
        $f->setContent("§c»§fTu as §6" . $this->atm->getConfig()->getAll()[$player->getName()]["atm"] . "$ §fsur ton ATM");
        $f->addButton("§c» §fRécupérer l'argent");
        $f->addButton("§c» §fAméliorer l'atm");
        $f->addButton("§c»§lAnnuler");
        $f->sendToPlayer($player);
        return $f;
    }

    public function upgradeAtmForm(Player $player) {
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    if(EconomyAPI::getInstance()->myMoney($player) < 10) {
                        $player->sendMessage("Tu n'as pas assez d'argent pour acheter cette amélioration");
                        return true;
                    }elseif ($this->atm->getConfig()->getAll()[$player->getName()]["rank"] === "mutliplicateurx2") {
                        $player->sendMessage("Tu as déjà cet amélioration");
                        return true;
                    }

                    $this->atm->getConfig()->set($this->atm->getConfig()->getAll()[$player->getName()]["rank"], "multiplicateurx2");
                    break;
                case 1:
                    if(EconomyAPI::getInstance()->myMoney($player) < 20) {
                        $player->sendMessage("Tu n'as pas assez d'argent pour acheter cette amélioration");
                    }elseif ($this->atm->getConfig()->getAll()[$player->getName()]["rank"] === "mutliplicateurx3") {
                        $player->sendMessage("Tu as déjà cet amélioration");
                        return true;
                    }
                    $this->atm->getConfig()->set($this->atm->getConfig()->getAll()[$player->getName()]["rank"], "multiplicateurx4");
                    break;
                case 2:
                    if(EconomyAPI::getInstance()->myMoney($player) < 80) {
                        $player->sendMessage("Tu n'as pas assez d'argent pour acheter cette amélioration");
                    }elseif ($this->atm->getConfig()->getAll()[$player->getName()]["rank"] === "mutliplicateurx8") {
                        $player->sendMessage("Tu as déjà cet amélioration");
                        return true;
                    }
                    $this->atm->getConfig()->set($this->atm->getConfig()->getAll()[$player->getName()]["rank"], "multiplicateurx8");
                    EconomyAPI::getInstance()->reduceMoney($player, 80);
                    break;
            }
        });
        $f->setTitle("§c[§rATMc]");
        $f->setContent("§c» §fTon atm est au rang: §6" . $this->atm->getConfig()->get($this->atm->getConfig()->getAll()[$player->getName()]["rank"]));
        $f->addButton("§c» §fMultiplicateur x2");
        $f->addButton("§c» §fMultiplicateur x4");
        $f->addButton("§c» §fMultiplicateur x8");
        $f->addButton("§c»§l Annuler");
        $f->sendToPlayer($player);
        return $f;
    }
}