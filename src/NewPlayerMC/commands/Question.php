<?php


namespace NewPlayerMC\commands;


use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\SimpleForm;
use NewPlayerMC\Solarite\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\command\utils\CommandException;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;

class Question extends PluginCommand
{
   public $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("question", $plugin);
        $this->setUsage("question");
        $this->setDescription("Ouvrir un menu avec des réponses aux questions");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {
            $this->questionForm($sender);
            if($sender->hasPermission("staff.perm")) {
                $form = new SimpleForm(function (Player $player, $data) {
                    if($data === null) {
                        return true;
                    }
                    switch ($data) {
                        case 0:
                            $this->tailleQuestionForm($player);
                            break;
                        case 1:
                            $this->coucheQuestionForm($player);
                            break;

                    }
                    if($data === 2) {
                        $form = new CustomForm(function (Player $player, $data) {
                            if($data === null) {
                                $this->questionForm($player);
                            }
                            $questions = new Config($this->plugin->getDataFolder() . "questions.yml", Config::YAML);
                            $questions->set($player->getName(), $data[0]);
                        });
                        $form->setTitle("§c[§fQuestions§c]");
                        $form->addInput("Votre question", "Question");
                        $form->sendToPlayer($player);
                        return $form;
                    }
                    if($data === 3) {
                        $questions = new Config($this->plugin->getDataFolder() . "questions.yml", Config::YAML);
                        $form = new SimpleForm(function (Player $player, $data) {
                            if($data === null) {
                                $this->questionForm($player);
                            } else {
                                $rep = new CustomForm(function (Player $player, $data) {
                                    if($data instanceof Player && $data->isOnline()) {
                                        $data->sendMessage($data[0]);
                                    }
                                });
                                $rep->setTitle("§c[§fQuestions§c]");
                                $rep->addInput("Réponse", "Réponse");
                                $rep->sendToPlayer($player);
                                return $rep;
                            }
                        });
                        $form->setTitle("§c[§fQuestions§c]");
                        foreach ($questions->getAll() as $question) {
                            $form->addButton($question);
                        }
                        $form->sendToPlayer($player);
                        return $form;
                    }
                });
                $form->setTitle("§c[§fQuestions§c]");
                $form->addButton("§c»§f Quelle est la taille de la map ?");
                $form->addButton("§c»§f Quelle est la couche de x minerai ?");
                $form->addButton("§c»§f Autres");
                $form->addButton("§c»§f Répondre");
                $form->sendToPlayer($sender);
            }
        }
    }

    public function questionForm($player)
    {
        $api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
        $f = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    $this->tailleQuestionForm($player);
                    break;
                case 1:
                    $this->coucheQuestionForm($player);
                break;

            }
            if($data === 2) {
                $form = new CustomForm(function (Player $player, $data) {
                    if($data === null) {
                        $this->questionForm($player);
                    }
                    $questions = new Config($this->plugin->getDataFolder() . "questions.yml", Config::YAML);
                    $questions->set($player->getName(), $data[0]);
                });
                $form->setTitle("§c[§fQuestions§c]");
                $form->addInput("Votre question", "Question");
                $form->sendToPlayer($player);
                return $form;
            }
        });
        $f->setTitle("§c[§rQuestions§c]");
        $f->addButton("§c»§f Quelle est la taille de la map ?");
        $f->addButton("§c»§f Quelle est la couche de x minerai ?");
        $f->addButton("§c»§f Autres");
        $f->sendToPlayer($player);
        return $f;
    }

    public function tailleQuestionForm($player)
    {
        $api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
        $f = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    break;
            }
        });
        $f->setTitle("§c[§rQuestions§c]");
        $f->setContent("La taille de la map faction est de 8400x8400 blocs. \nUn nouveau monde faction ouvrira sûrement prochainement");
        $f->addButton("§c§lFermer");
        $f->sendToPlayer($player);
        return $f;
    }

    public function coucheQuestionForm($player)
    {
        $api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
        $f = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    break;
            }
        });
        $f->setTitle("§c[§rQuestions§c]");
        $f->setContent("Vous pourrez retrouver du:\nSolarite: \ncouche 3 à 14\n\nItérium: \ncouche 2 à 4");
        $f->addButton("§c§lFermer");
        $f->sendToPlayer($player);
        return $f;
    }


}