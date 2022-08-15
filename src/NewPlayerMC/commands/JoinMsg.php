<?php


namespace NewPlayerMC\commands;


use jojoe77777\FormAPI\CustomForm;
use NewPlayerMC\Solarite\Main;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;

class JoinMsg extends \pocketmine\command\PluginCommand
{
    /**
     * @var Config $joinmsg
     */
    public $joinmsg;
    public static $instance;

    public $plugin;
    public function __construct(Main $plugin)
    {
        parent::__construct("joinmessage", $plugin);
        $this->plugin = $plugin;
        @mkdir($this->plugin->getDataFolder());
        $this->joinmsg = new Config($this->plugin->getDataFolder() . 'joinmsg', Config::YAML);
        self::$instance = $this;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
         if($sender instanceof Player && $sender->hasPermission("custommsg.use")) {
           $this->msgForm($sender);
         }
    }

    public function msgForm(Player $player) {
        $form = new CustomForm(function (Player $player, $data) {
           $res = $data;
           if($res === null) {
               $player->sendMessage("§cMerci de remplir d'écrire un message!");
           } else {
               switch ($res) {
                   case 0:
                       str_replace("{PLAYER}", $player->getName(), $res[1]);
                       $this->joinmsg->set($player->getName(), [
                           "type" => $res[0]
                       ]);
                       $player->sendMessage("§aVotre message de bienvenue a bien été défini en tant que:§f\n$res");
                       break;
                   case 1:
                       str_replace("{PLAYER}", $player->getName(), $res[1]);
                       $this->joinmsg->set($player->getName(), [
                           "type" => $res[1]
                       ]);
                       $player->sendMessage("§aVotre message de bienvenue a bien été défini en tant que:§f\n$res");

                       break;
                   case 2:
                       str_replace("{PLAYER}", $player->getName(), $res[1]);
                       $this->joinmsg->set($player->getName(), [
                           "type" => $res[2]
                       ]);
                       $player->sendMessage("§aVotre message de bienvenue a bien été défini en tant que:§f\n$res");
                       break;
               }
               str_replace("{PLAYER}", $player->getName(), $res[1]);
               $this->joinmsg->set($this->joinmsg->get($player->getName())["message"]);
               $player->sendMessage("§aVotre message de bienvenue a bien été défini en tant que:§f\n$res");

           }
        });

        $form->setTitle("§c[§fMessages de bienvenue§c]");
        $form->addLabel("Ici vous pouvez changer votre message de bienvenue.\nUtilisez {PLAYER} pour mettre votre nom.\n§c/!\Tout contenu offensif pourra être sanctionné et effacé");
        $form->addDropdown("Type de message", ["Popup", "Tip","Message"], 2);
        $form->addInput("Entrez votre message", "Bienvenue à moi ô grand {PLAYER}");
        $form->sendToPlayer($player);
        return $form;
    }

    public static function getInstance(): self {
        return self::$instance;
    }

}