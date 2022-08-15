<?php



namespace NewPlayerMC\tasks;

use NewPlayerMC\Solarite\Main;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class MessagesTask extends Task
{
    public $plugin;

    public function __construct(Main $plugin)
    {
       $this->plugin = $plugin;
    }

    public function onRun(int $currentTick)
    {

        $r = mt_rand(1, 5);
      if ($r >= 1 && $r <= 2) {
          Server::getInstance()->broadcastMessage("§b»§f N'oubliez pas d'aller voter sur \n§6https://minecraftpocket-servers.com/server/94649/\n§rCela vous permettra de gagner des récompenses!");
      } elseif ($r >= 2 && $r <= 3) {
          Server::getInstance()->broadcastMessage("§b»§f Vous n'êtes pas encore sur notre discord ? Rejoignez-nous!\n§e");
      } elseif($r >= 3 && $r <= 4) {
          Server::getInstance()->broadcastMessage("§b»§f N'hésitez pas à faire un tour sur notre §l§6boutique §rhttps://solarite.tebex.io!");
      } elseif($r >= 4 && $r <= 5) {
          Server::getInstance()->broadcastMessage("§b»§f Besoin d'aides ou des questions? Contactez un §l§amembre du staff §fou posez votre question sur notre discord!");
      }

    }

}