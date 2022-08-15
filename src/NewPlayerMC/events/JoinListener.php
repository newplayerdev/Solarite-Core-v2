<?php


namespace NewPlayerMC\events;


use NewPlayerMC\commands\JoinMsg;
use NewPlayerMC\Solarite\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\Server;
use pocketmine\utils\Config;

class JoinListener implements Listener
{
    public $plugin;
    public $keys;
    public $staffsOnline;
    public static $join;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        $this->staffsOnline = new Config($this->plugin->getDataFolder() . 'staffonlines.yml', Config::YAML);
    }

    public function onJoin(PlayerJoinEvent $event)
   {
       $player = $event->getPlayer();
       if($player->hasPermission("staff.perm")) {
         $this->staffsOnline->set(strtolower($player->getName()));
       }
       if(!$player->hasPlayedBefore())
       {
           $this->keys = new Config($this->plugin->getDataFolder() . 'keys.yml', Config::YAML, array(
               strtolower($player->getName()) => [
                   "keys" => [
                       "vote" => 0,
                       "basique" => 0,
                       "minerai" => 0,
                       "enchante" => 0,
                       "solarite" => 0,
                       "iterium" => 0,
                       "topaze" => 0,
                       "clé" => 0
                   ]
               ]
           ));

           $config = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML, array(
               strtolower($player->getName()) => [
                   "atm" => 1 ,
                   "rank" => "normal"
               ]
           ));
           $config->save();
           $event->setJoinMessage("§c» §a" . $player->getName() . " §fa rejoins pour la première fois le serveur!\n§eSouhaitez lui la bienvenue!");
       } else {
           $event->setJoinMessage(" ");
           Server::getInstance()->broadcastPopup("§a+ §7[§a" . $player->getName() . "§7]");
       }
   }

   public function onLeave(PlayerQuitEvent $event)
   {

       $player = $event->getPlayer();
       $item = $player->getInventory()->getItemInHand();
       if($player->hasPermission("staff.perm")) {
           $this->staffsOnline->remove($player->getName());
       }

       if($item->getId() == Item::BLAZE_POWDER){
           $player->removeEffect(24);
       }
       $event->setQuitMessage(" ");
       Server::getInstance()->broadcastPopup("§c- §7        z[§c" . $player->getName() . "§7        z]");
   }

   public function onPreLogin(PlayerPreLoginEvent $event) {

       if(!$event->getPlayer()->isWhitelisted()) {
           $event->setKickMessage("§cLe serveur est actuelement en maitenance pour la §bV2\n\n---------------[§6On revient bientôt!§f]---------------");
           $event->setCancelled(true);
       }
   }

   public static function getInstance(): self{
        return self::$join;
   }

}