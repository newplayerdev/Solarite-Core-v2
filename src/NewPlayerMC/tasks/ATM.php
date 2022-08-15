<?php


namespace NewPlayerMC\tasks;

;
use NewPlayerMC\Solarite\Main;
use pocketmine\utils\Config;

class ATM extends \pocketmine\scheduler\Task
{
    public $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onRun(int $currentTick)
    {

       foreach($this->plugin->getServer()->getOnlinePlayers() as $p) {
           $config = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
           if(!$config->exists(strtolower($p->getName()))) {
               $config = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML, array(
                   strtolower($p->getName()) => [
                       "atm" => 1 ,
                       "rank" => "normal"
                   ]
               ));
               $config->save();
           }
        $this->plugin->getConfig()->set($this->plugin->getConfig()->getAll()[strtolower($p->getName())]["atm"], $this->plugin->getConfig()->getAll()[$p->getName()]["atm"] + 1);
        $this->plugin->getConfig()->save();
        $p->sendPopup("+§61$ §fsur l'ATM");
       }
    }
}