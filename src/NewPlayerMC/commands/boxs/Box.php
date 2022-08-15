<?php


namespace NewPlayerMC\commands\boxs;


use jojoe77777\FormAPI\SimpleForm;
use NewPlayerMC\Solarite\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\item\Item;
use pocketmine\level\sound\FizzSound;
use pocketmine\level\sound\GhastShootSound;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\Server;
use onebone\economyapi\EconomyAPI;
use pocketmine\utils\Config;

class Box extends \pocketmine\command\Command
{


    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {
         $this->boxForm($sender);
        } else {
            $sender->sendMessage("Pas de console");
        }
    }

    public function boxForm(Player $player) {
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    $this->boxVoteForm($player);
                    break;
                case 1:
                    $this->boxMineraiForm($player);
                    break;
                case 2:
                    $this->boxEnchanted($player);
                    break;
                case 3:
                    $this->boxBasiqueForm($player);
                    break;
                case 7:
                    $this->boxKeyForm($player);
                    break;
            }
        });
        $f->setTitle("§c[§rBoxs§c]");
        $f->addButton("»Box Vote\n»Cliquer pour ouvrir", 0, "textures/other/vote");
        $f->addButton("»Box Minerai\n»Cliquer pour ouvrir", 0, "textures/other/cle_minerai");
        $f->addButton("»Box Enchantée\n»Cliquer pour ouvrir", 0, "textures/other/cle_enchante");
        $f->addButton("»Box Basique\n»Cliquer pour ouvrir", 0, "textures/other/basique");
        $f->addButton("»Box Solarite\n»Cliquer pour ouvrir", 0, "textures/other/cle_solarite");
        $f->addButton("»Box Itérium\n»Cliquer pour ouvrir", 0, "textures/other/cle_iterium");
        $f->addButton("»Box Topaze\n»Cliquer pour ouvrir", 0, "textures/other/cle_topaze");
        $f->addButton("»Box §bK§de§ay§2s\n»Cliquer pour ouvrir", 0, "textures/other/cle_key");
        $f->sendToPlayer($player);
        return $f;
    }

    public function boxVoteForm($player) {
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    $keys = new Config(Main::getInstance()->getDataFolder() . "/keys" . strtolower($player->getName()) . "yml", Config::YAML);
                    if ($keys->get("vote") <= 0) {
                        $player->sendMessage("§cTu n'as pas de clé vote!");
                    } else {
                        if (!$keys->exists("", "a"))
                            $loot = mt_rand(0, 100);
                        if ($loot >= 0 && $loot <= 6) {
                            $player->getInventory()->addItem(Item::get(Item::EGG, 0, 2));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 2 grenades dans une box vote! §c«");
                        } elseif ($loot >= 6 && $loot <= 28) {
                            EconomyAPI::getInstance()->addMoney($player, 5000);
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné §e5000$ §rdans une box vote! §c«");
                        } elseif ($loot >= 28 && $loot <= 40) {
                            $player->getInventory()->addItem(Item::get(Item::DIAMOND_HELMET, 0, 1));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné un casque en diamant dans une box vote! §c«");
                        } elseif ($loot >= 40 && $loot <= 52) {
                            $player->getInventory()->addItem(Item::get(Item::DIAMOND_CHESTPLATE, 0, 1));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné un plastron en diamant dans une box vote! §c«");
                        } elseif ($loot >= 52 && $loot <= 64) {
                            $player->getInventory()->addItem(Item::get(Item::DIAMOND_LEGGINGS, 0, 1));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné des jambières en diamant dans une box vote! §c«");
                        } elseif ($loot >= 64 && $loot <= 78) {
                            $player->getInventory()->addItem(Item::get(Item::DIAMOND_BOOTS, 0, 1));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné des bottes en diamant dans une box vote! §c«");
                        } elseif ($loot >= 78 && $loot <= 86) {
                            EconomyAPI::getInstance()->addMoney($player, 7500);
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné §e7500$ §rdans une box vote! §c«");
                        } elseif ($loot >= 86 && $loot <= 91) {
                            $player->getInventory()->addItem(Item::get(Item::DIAMOND, 0, 16));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 16 diamants dans une box vote! §c«");
                        } elseif ($loot >= 91 && $loot <= 100) {
                            $player->getInventory()->addItem(Item::get(468, 0, 4));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 4 bandages dans une box vote! §c«");
                        }
                        $keys->set("vote", $keys->get("vote") - 1);
                    }
                break;

            }
        });
        $f->setTitle("§c[§rBox Vote§c]");
        $f->setContent("Cette box contient:\n§c- §eBandages\n§c- §eGrenades\n§c- §e5000$ \n§c- §e7500$ \n§c- §eCasque en diamant \n§c- §ePlastron en diamant \n§c- §eJambières en diamant \n§c- §eBottes en diamants \n§c- §e16 diamants");
        $f->addButton("Ouvrir la box");
        $f->addButton("§l§cAnnuler");
        $f->sendToPlayer($player);
        return $f;
    }

    public function boxMineraiForm($player) {
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    $keys = new Config(Main::getInstance()->getDataFolder() . "/keys" . strtolower($player->getName()) . "yml", Config::YAML);
                    if ($keys->get("minerai") <= 0) {
                        $player->sendMessage("§cTu n'as pas de clé minerai!");
                    } else {
                        $loot = mt_rand(0, 100);
                        $item = Item::get(Item::NAME_TAG, 0, 1);
                        if (!$player->getInventory()->getItemInHand() === $item && $player->getInventory()->getItemInHand()->getLore() === ['Key Vote']) {
                            $player->sendMessage("§cTu n'as pas de key pour ouvrir cette box");
                        }
                        if ($loot >= 0 && $loot <= 0.25) {
                            $player->getInventory()->addItem(Item::get(Item::REDSTONE, 0, 1));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §r1 Topaze dans une box minerai!! §c«");
                            foreach (Server::getInstance()->getOnlinePlayers() as $p) {
                                $p->getLevel()->addSound(new FizzSound(new Vector3($p->getX(), $p->getY(), $p->getZ())));
                            }
                        } elseif ($loot >= 0.25 && $loot <= 1) {
                            $player->getInventory()->addItem(Item::get(Item::CONCRETE, 11, 1));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §r1 minerai d'itérium dans une box minerai!! §c«");
                            foreach (Server::getInstance()->getOnlinePlayers() as $p) {
                                $p->getLevel()->addSound(new FizzSound(new Vector3($p->getX(), $p->getY(), $p->getZ())));
                            }
                        } elseif ($loot >= 1 && $loot <= 2) {
                            $player->getInventory()->addItem(Item::get(Item::GOLD_ORE, 0, 1));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 1 minerai de solarite dans une box minerai!! §c«");
                        } elseif ($loot >= 2 && $loot <= 2.75) {
                            $player->getInventory()->addItem(Item::get(Item::GOLD_ORE, 0, 2));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 2 minerais de solarite dans une box minerai!! §c«");
                        } elseif ($loot >= 2.75 && $loot <= 3.25) {
                            $player->getInventory()->addItem(Item::get(Item::GOLD_ORE, 0, 4));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 4 minerais de solarite dans une box minerai!! §c«");
                        } elseif ($loot >= 3.25 && $loot <= 4.5) {
                            $player->getInventory()->addItem(Item::get(Item::EMERALD_ORE, 0, 2));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 2 minerai d'émeraude dans une box minerai! §c«");
                        } elseif ($loot >= 4.5 && $loot <= 5) {
                            $player->getInventory()->addItem(Item::get(Item::EMERALD_BLOCK, 0, 1));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 1 bloc d'émeraude dans une box minerai! §c«");
                        } elseif ($loot >= 5 && $loot <= 8) {
                            $player->getInventory()->addItem(Item::get(Item::DIAMOND_BLOCK, 0, 1));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 1 bloc de diamant dans une box minerai! §c«");
                        } elseif ($loot >= 8 && $loot <= 10) {
                            $player->getInventory()->addItem(Item::get(Item::DIAMOND_BLOCK, 0, 4));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 4 blocs de diamants dans une box minerai! §c«");
                        } elseif ($loot >= 10 && $loot <= 15) {
                            $player->getInventory()->addItem(Item::get(Item::DIAMOND_ORE, 0, 8));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 8 minerai diamants dans une box minerai! §c«");
                        } elseif ($loot >= 15 && $loot <= 19) {
                            $player->getInventory()->addItem(Item::get(Item::DIAMOND_ORE, 0, 16));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 16 minerais diamants dans une box minerai! §c«");
                        } elseif ($loot >= 19 && $loot <= 22) {
                            $player->getInventory()->addItem(Item::get(Item::DIAMOND_ORE, 0, 32));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 32 minerais de diamants dans une box minerai! §c«");
                        } elseif ($loot >= 22 && $loot <= 30) {
                            $player->getInventory()->addItem(Item::get(Item::LAPIS_ORE, 0, 8));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 8 minerais lapis-lazuli dans une box minerai! §c«");
                        } elseif ($loot >= 30 && $loot <= 38) {
                            $player->getInventory()->addItem(Item::get(Item::LAPIS_ORE, 0, 16));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 16 minerais lapis-lazuli dans une box minerai! §c«");
                        } elseif ($loot >= 38 && $loot <= 42) {
                            $player->getInventory()->addItem(Item::get(Item::LAPIS_ORE, 0, 32));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 32 minerais lapis-lazuli dans une box minerai! §c«");
                        } elseif ($loot >= 42 && $loot <= 45.5) {
                            $player->getInventory()->addItem(Item::get(Item::LAPIS_ORE, 0, 64));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 64 minerais lapis-lazuli dans une box minerai! §c«");
                        } elseif ($loot >= 45.5 && $loot <= 53) {
                            $player->getInventory()->addItem(Item::get(Item::IRON_BLOCK, 0, 32));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 64 blocs de fer dans une box minerai! §c«");
                        } elseif ($loot >= 53 && $loot <= 58) {
                            $player->getInventory()->addItem(Item::get(Item::IRON_BLOCK, 0, 16));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 16 blocs de fer §fdans une box minerai! §c«");
                        } elseif ($loot >= 58 && $loot <= 62) {
                            $player->getInventory()->addItem(Item::get(Item::IRON_ORE, 0, 32));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 32 minerais de fer §fdans une box minerai! §c«");
                        } elseif ($loot >= 62 && $loot <= 66) {
                            $player->getInventory()->addItem(Item::get(Item::IRON_ORE, 0, 16));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 16 minerais de fer §fdans une box minerai! §c«");
                        } elseif ($loot >= 66 && $loot <= 80) {
                            $player->getInventory()->addItem(Item::get(Item::COAL_ORE, 0, 64));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 64 minerais de charbon §fdans une box minerai! §c«");
                        } elseif ($loot >= 80 && $loot <= 92) {
                            $player->getInventory()->addItem(Item::get(Item::COAL_ORE, 0, 32));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 32 minerais de charbon §fdans une box minerai! §c«");
                        } elseif ($loot >= 92 && $loot <= 100) {
                            $player->getInventory()->addItem(Item::get(Item::COAL_BLOCK, 0, 16));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 16 blocs de charbon §fdans une box minerai! §c«");
                        }
                        $keys->set("minerai", $keys->get("minerai") - 1);
                    }
                    break;
            }
        });
        $f->setTitle("§c[§rBox Vote§c]");
        $f->setContent("Cette box contient:\n§c- §eTopaze\n§c- §eItérium\n§c- §eSolarite \n§c- §eEmeraude \n§c- §eDiamant \n§c- §Fer \n§c- §eCharbon \n§c- §eLapis-Lazuli");
        $f->addButton("Ouvrir la box");
        $f->addButton("§l§cAnnuler");
        $f->sendToPlayer($player);
        return $f;
    }

    public function boxBasiqueForm($player) {
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    $keys = new Config(Main::getInstance()->getDataFolder() . "/keys" . strtolower($player->getName()) . "yml", Config::YAML);
                    if ($keys->get("basique") <= 0) {
                        $player->sendMessage("§cTu n'as pas de clé basique!");
                    } else {
                        if (!$player->getInventory()->getItemInHand()->getId() === 421 && $player->getInventory()->getItemInHand()->getLore() === ['Key Basique']) {
                            $player->sendMessage("§cTu n'as pas de key pour ouvrir cette box");
                        }
                        $loot = mt_rand(0, 100);
                        if ($loot >= 0 && $loot <= 6) {
                            $player->getInventory()->addItem(Item::get(Item::EGG, 0, 16));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 16 grenades dans une box basique! §c«");
                        } elseif ($loot >= 6 && $loot <= 12) {
                            EconomyAPI::getInstance()->addMoney($player, 17500);
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné §e17500$ §rdans une box basique! §c«");
                        } elseif ($loot >= 12 && $loot <= 20) {
                            EconomyAPI::getInstance()->addMoney($player, 15000);
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné §e15000$ §rdans une box basique! §c«");
                        } elseif ($loot >= 20 && $loot <= 30) {
                            $player->getInventory()->addItem(Item::get(Item::SPONGE, 0, 8));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 8 LukcyBlocks dans une box basique! §c«");
                        } elseif ($loot >= 52 && $loot <= 64) {
                            $player->getInventory()->addItem(Item::get(Item::SPIDER_EYE, 0, 1));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné un stick de pvp dans une box basique! §c«");
                        } elseif ($loot >= 64 && $loot <= 72) {
                            Server::getInstance()->dispatchCommand(new ConsoleCommandSender(), "key " . $player->getName() . " 1 Vote");
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné une key vote dans une box basique! §c«");
                        } elseif ($loot >= 78 && $loot <= 86) {
                            EconomyAPI::getInstance()->addMoney($player, 10000);
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné §e10000$ §rdans une box basique! §c«");
                        } elseif ($loot >= 86 && $loot <= 91) {
                            $player->getInventory()->addItem(Item::get(Item::DIAMOND, 0, 16));

                        } elseif ($loot >= 91 && $loot <= 100) {
                            $player->getInventory()->addItem(Item::get(468, 0, 16));
                            Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §ra gagné 16 bandages dans une box basique! §c«");
                        }
                        $keys->set("basique", $keys->get("basique") - 1);
                    }
                    break;
                case 1:

                    break;
            }
        });
        $f->setTitle("§c[§rBox Basique§c]");
        $f->setContent("Cette box contient:\n§c- §eBandages\n§c- §eGrenades\n§c- §e10000$ \n§c- §e15000$ \n§c- §eSeringue \n§c- §eLuckyBlocks \n§c- §eObsiBreaker \n§c- §ePommes en solarite \n§c- §eKey Vote \n§c- §eStick de pvp");
        $f->addButton("Ouvrir la box");
        $f->addButton("§l§cAnnuler");
        $f->sendToPlayer($player);
        return $f;
    }

    public function boxKeyForm($player) {
        $api = Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        $f = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }
            switch ($result) {
                case 0:
                    $keys = new Config(Main::getInstance()->getDataFolder() . "/keys" . strtolower($player->getName()) . "yml", Config::YAML);
                    if($keys->get("key") <= 0) {
                        $player->sendMessage("§cTu n'as pas de clé à clés");
                    } else {
                        $loot = mt_rand(0, 100);
                        if ($loot >= 0 && $loot <= 4) {
                           $keys->set("key", $keys->get("key") + 1);
                            Server::getInstance()->broadcastMessage("§c» §f" . $player->getName() . " §ra gagné un stick de pvp dans une box basique! §c");
                        }
                        $keys->set("key", $keys->get("key") - 1);
                    }
                    break;
                case 1:

                    break;
            }
        });
        $f->setTitle("§c[§rBox à clés§c]");
        $f->setContent("Cette box contient:\n§c- §eClé de vote\n§c- §eClé à minerais\n§c- §eClé enchantée\n§c- §eClé basique\n§c- §eClé en solarite\n§c- §eClé en itérium\n§c §e-Clé en topaze");
        $f->addButton("Ouvrir la box");
        $f->addButton("§l§cAnnuler");
        $f->sendToPlayer($player);
        return $f;
    }

     public function boxEnchanted($player)
     {
         $form = new SimpleForm(function (Player $player, $data){
            if($data === null) {
                $this->boxForm($player);
            }
            switch ($data) {
                case 0:
                    $keys = new Config(Main::getInstance()->getDataFolder() . "/keys" . strtolower($player->getName()) . "yml", Config::YAML);
                    if($keys->get("enchante") <= 0) {
                        $player->sendMessage("§cTu n'as pas de clé enchantée");
                    } else {
                        $rand = mt_rand(1, 110);
                        if ($rand >= 1 && $rand <= 10) {
                            $player->getInventory()->addItem(Item::get(Item::ENCHANTED_BOOK, 0, 1)->setLore(["Vous permet d'améliorer votre vitesse"])->setCustomName("§dVitesse"));
                        } elseif ($rand >= 10 && $rand <= 20) {
                            $player->getInventory()->addItem(Item::get(Item::ENCHANTED_BOOK, 0, 1)->setLore(["Propulsion", "Vous permet de vous propulser dans les airs"])->setCustomName("§dPropulsion"));
                        } elseif ($rand >= 20 && $rand <= 30) {
                            $player->getInventory()->addItem(Item::get(Item::ENCHANTED_BOOK, 0, 1)->setLore(["Vous permet de chercher un coffre prêt de vous"])->setCustomName("§dChercheur de coffre"));
                        } elseif ($rand >= 30 && $rand <= 40) {
                            $player->getInventory()->addItem(Item::get(Item::ENCHANTED_BOOK, 0, 1)->setLore(["Vous permet de vous soigner"])->setCustomName("§dSoin"));
                        } elseif ($rand >= 40 && $rand <= 50) {
                            $player->getInventory()->addItem(Item::get(Item::ENCHANTED_BOOK, 0, 1)->setLore(["Vous permet de vous téléporter aléatoirement sur la map"])->setCustomName("§dTéléportation aléatoire"));
                        } elseif ($rand >= 50 && $rand <= 60) {
                            $player->getInventory()->addItem(Item::get(Item::ENCHANTED_BOOK, 0, 1)->setLore(["Vous permet de mettre les blocs sur lesquels vous marchez en feu"])->setCustomName("§dPyroman"));
                        } elseif ($rand >= 60 && $rand <= 61) {
                            $player->getInventory()->addItem(Item::get(Item::ENCHANTED_BOOK, 0, 1)->setLore(["Vous permet de vous prendre pour un dieu"])->setCustomName("§dComme un dieu"));
                        } elseif ($rand >= 61 && $rand <= 70) {
                            $player->getInventory()->addItem(Item::get(Item::ENCHANTED_BOOK, 0, 1)->setLore(["Vous permet de ralentir votre adversaire"])->setCustomName("§dRampant"));
                        } elseif ($rand >= 70 && $rand <= 80) {
                            $player->getInventory()->addItem(Item::get(Item::ENCHANTED_BOOK, 0, 1)->setLore(["Vous permet de créer une explosion"])->setCustomName("§dKaboum"));
                        } elseif ($rand >= 80 && $rand <= 90) {
                            $player->getInventory()->addItem(Item::get(Item::ENCHANTED_BOOK, 0, 1)->setLore(["Vous permet de repousser les joueurs autour de vous"])->setCustomName("§dRépulsion"));
                        } elseif ($rand >= 99 && $rand <= 110) {
                            $player->getInventory()->addItem(Item::get(Item::ENCHANTED_BOOK, 0, 1)->setLore(["Vous permet de lancer une boule de feu"])->setCustomName("§dBoule de feu"));
                        }
                        $keys->set("enchante", $keys->get("enchante") - 1);
                    }
                    break;
            }
         });
         $form->setTitle("§c[§rBox Enchantée§c]");
         $form->setContent("Cette box contient:\n§c- §eLivres enchantés");
         $form->addButton("§c» Ouvrir la box");
         $form->addButton("§c»§l Annuler");
         $form->sendToPlayer($player);
         return $form;
     }
}