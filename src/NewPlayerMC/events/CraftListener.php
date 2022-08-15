<?php


namespace NewPlayerMC\events;


use NewPlayerMC\Solarite\Main;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\Listener;
use pocketmine\inventory\transaction\CraftingTransaction;
use pocketmine\item\Item;
use NewPlayerMC\jobs\JobsListener;
use pocketmine\item\ItemIds;
use pocketmine\level\Explosion;
use pocketmine\level\Position;
use pocketmine\utils\Config;

class CraftListener implements Listener
{
    public $main;

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public function onCraft(CraftItemEvent $e)
    {
        $player = $e->getPlayer();
        foreach ($e->getInputs() as $input) {
            foreach ($e->getOutputs() as $output) {
                if ($input->getId() === 742 && $player->getArmorInventory()->getHelmet()->getId() !== 397 && $player->getArmorInventory()->getHelmet()->getDamage() !== 1){
                    $rand = mt_rand(1, 2);
                    if ($rand === 1) {
                        $pos = new Position($e->getPlayer()->getX(), $e->getPlayer()->getY(), $e->getPlayer()->getZ(), $e->getPlayer()->getLevel());
                        $explod = new Explosion($pos, 1.5);
                        $explod->explodeA();
                        $explod->explodeB();
                        $player->getInventory()->remove($output->setCount($e->getRepetitions()-1));
                        $player->sendPopup("§cTon craft a été loupé");
                    }
                }
            }
        }
    }
}