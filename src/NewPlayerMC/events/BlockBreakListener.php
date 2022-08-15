<?php


namespace NewPlayerMC\events;


use NewPlayerMC\Solarite\Main;
use NewPlayerMC\tasks\MeteorTask;
use NewPlayerMC\tasks\OreRain;
use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use onebone\economyapi\EconomyAPI;
use _64FF00\PurePerms\PurePerms;
use pocketmine\item\ItemIds;
use pocketmine\level\Explosion;
use pocketmine\level\Position;
use pocketmine\Server;
use pocketmine\utils\Config;

class BlockBreakListener implements Listener
{
    public $main;

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public function onBreak(BlockBreakEvent $event)
    {
        // Minerais \\
        $it = $event->getItem();
        $block = $event->getBlock();
        $player = $event->getPlayer();
        if($block->getId() === 236 && $block->getDamage() === 11 && $it->getId() === 285) {
            if(!$player->hasPermission("iterium.break")) {
                $event->setCancelled(true);
            }
            $randex = mt_rand(1, 3);
            if($randex >= 1 && $randex <= 2) {
                $pos = new Position($event->getBlock()->getX(), $event->getBlock()->getY(), $event->getBlock()->getZ(), $event->getBlock()->getLevel());
                $explod = new Explosion($pos, 1.5);
                $explod->explodeA();
                $explod->explodeB();
            }
            $event->setDrops(array(Item::get(Item::LEATHER, 0, 1)));
        }
        if ($event->getBlock()->getId() === 244 && $event->getBlock()->getDamage() === 7) {
            $rand = mt_rand(1, 200);
            $graine = mt_rand(1, 200);
          if($event->getItem()->getId() === 414) {
              if($graine >= 1 && $graine <= 2) {
                  $event->setDrops(array(Item::get(Item::GHAST_TEAR, 0, 1)));
              }
              elseif($graine >= 2 && $graine <= 80) {
                  $event->setDrops(array(Item::get(Item::BEETROOT_SEEDS, 0, 1)));
                  $player->sendPopup("§cMerci la houe");
              }
              elseif($graine >= 80 && $graine <= 200) {
                  $event->setDrops(array(Item::get(Item::AIR, 0, 1)));
              }
              return;
          }
            if ($rand >= 1 && $rand <= 2) {
                $event->setDrops(array(Item::get(Item::GHAST_TEAR, 0, 1)));
            }
            elseif ($rand >= 2 && $rand <= 60) {
                $event->setDrops(array(Item::get(Item::BEETROOT_SEEDS, 0, 1)));

            } elseif ($rand >= 60 && $rand <= 200) {
                $event->setDrops(array(Item::get(Item::AIR, 0, 1)));

            }
        }
        elseif ($event->getBlock()->getId() === 31 && $event->getBlock()->getDamage() === 1) {
            $random = mt_rand(1, 150);
          if($event->getItem()->getID() === 414) {
            if ($random >= 1 && $random <= 2) {
                $event->setDrops(array(Item::get(Item::BEETROOT_SEEDS, 0, 1)));
            } elseif ($random >= 2 && $random <= 150) {
                $event->setDrops(array(Item::get(Item::AIR, 0, 1)));
            }
         }
      }
            if ($event->getBlock()->getId() === 19) {
                $drop = mt_rand(1, 100);

                if ($drop >= 1 && $drop <= 100) {
                    $event->setDrops(array(Item::get(Item::GOLD_ORE, 0, 1)));
                    $player->sendPopup("Tu as gagné §61 lingot en solarite §f!");
                } elseif ($drop >= 2 && $drop <= 5) {
                    $event->setDrops(array(Item::get(Item::DIAMOND_BLOCK, 0, 16)));
                    $player->sendPopup("Tu as gagné §616 blocs en diamant §f!");
                } elseif ($drop >= 5 && $drop <= 10) {
                    EconomyAPI::getInstance()->addMoney($player, 5000);
                    $player->sendPopup("Tu as gagné §6000$ §r!");
                    $event->setDrops(array(Item::get(Item::AIR, 0, 1)));
                } elseif ($drop >= 10 && $drop <= 25) {
                    $enchantement = new EnchantmentInstance(Enchantment::getEnchantment(9));
                    $enchantement->setLevel(3);
                    $item = Item::get(Item::DIAMOND_SWORD, 0, 1);
                    $item->addEnchantment($enchantement);
                    $event->setDrops(array($item));
                    $player->sendPopup("Tu as gagné une§6 épée en diamant §f!");
                } elseif ($drop >= 25 && $drop <= 35) {
                    $enchantement = new EnchantmentInstance(Enchantment::getEnchantment(0));
                    $enchantement->setLevel(2);
                    $item = Item::get(Item::DIAMOND_CHESTPLATE, 0, 1);
                    $item->addEnchantment($enchantement);
                    $event->setDrops(array($item));
                    $player->sendPopup("Tu as gagné un§6 plastron en diamant protection 2 §f!");
                } elseif ($drop >= 35 && $drop <= 45) {
                    $enchantement = new EnchantmentInstance(Enchantment::getEnchantment(0));
                    $enchantement->setLevel(2);
                    $item = Item::get(Item::DIAMOND_HELMET, 0, 1);
                    $item->addEnchantment($enchantement);
                    $event->setDrops(array($item));
                    $player->sendPopup("Tu as gagné un§6 casque en diamant protection 2 §f!");
                } elseif ($drop >= 45 && $drop <= 55) {
                    $enchantement = new EnchantmentInstance(Enchantment::getEnchantment(0));
                    $enchantement->setLevel(2);
                    $item = Item::get(Item::DIAMOND_BOOTS, 0, 1);
                    $item->addEnchantment($enchantement);
                    $event->setDrops(array($item));
                    $player->sendPopup("Tu as gagné des§6 bottes en diamant protection 2 §f!");
                } elseif ($drop >= 55 && $drop <= 62) {
                    $enchantement = new EnchantmentInstance(Enchantment::getEnchantment(0));
                    $enchantement->setLevel(2);
                    $item = Item::get(Item::DIAMOND_LEGGINGS, 0, 1);
                    $item->addEnchantment($enchantement);
                    $event->setDrops(array($item));
                    $player->sendPopup("Tu as gagné des§6 jambières en diamant protection 2 §f!");
                } elseif ($drop >= 62 && $drop <= 74) {
                    $event->setDrops(array(Item::get(Item::DIAMOND, 0, 32)));
                    $player->sendPopup("Tu as gagné §632 lingots de fer §r!");
                } elseif ($drop >= 74 && $drop <= 82) {
                    $this->main->getScheduler()->scheduleRepeatingTask(new OreRain($this->main, $player), 20);
                } elseif ($drop >= 82 && $drop <= 90) {
                    $event->setDrops(array(Item::get(Item::SPONGE, 0, 1)));
                    $player->sendPopup("Tu as gagné un§6 LuckyBlock §f!");
                } elseif ($drop >= 90 && $drop <= 95) {
                    $event->setDrops(array(Item::get(Item::DIRT, 0, 1)->setCustomName("§cTerre de la loose")));
                    $player->sendPopup("§cPerdu!");
                } elseif ($drop >= 95 && $drop <= 100) {
                    $player->kill();
                    Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §6est mort par un LuckyBlock");
                }

            }
           $topluck = new Config($this->main->getDataFolder()."topluck/".strtolower($event->getPlayer()->getName()).".yml", Config::YAML);
              if($block->getId() === 14) {
                  $topluck->set('solarite', $topluck->get('solarite') + 1);
              } elseif ($block->getId() === 236 && $block->getId() === 12) {
                  $topluck->set('iterium', $topluck->get('iterium') + 1);
              } elseif ($block->getId() === 56) {
                  $topluck->set('diamant', $topluck->get('diamant') + 1);
              } elseif ($block->getId() === 1) {
                  $topluck->set('roche', $topluck->get('roche') + 1);
              }
    }

}