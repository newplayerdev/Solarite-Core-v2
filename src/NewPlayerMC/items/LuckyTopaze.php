<?php


namespace NewPlayerMC\items;


use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\entity\Entity;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\level\Explosion;
use pocketmine\level\Position;
use pocketmine\level\sound\GhastShootSound;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\Server;
use onebone\economyapi\EconomyAPI;
use pocketmine\utils\Color;

class LuckyTopaze implements Listener
{
    public function onBreakEvent(BlockBreakEvent $event) {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        $loots = mt_rand(0, 100);
        if($block->getId() === 236 && $block->getDamage() === 10) {
         if($loots >= 1 && $loots <= 5) {
             $event->setXpDropAmount(30);
             $event->setDrops(array(Item::get(Item::LAPIS_ORE, 0, 16)));
             $player->sendPopup("§c» §fTu as gagné 30 niveaux et 16 lapis lazuli!");
         } elseif($loots >= 5 && $loots <= 7) {
             $item = Item::get(Item::GOLDEN_BOOTS, 0, 1);
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 2));
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné des bottes en Solarite protection 1!");
         } elseif($loots >= 7 && $loots <= 9) {
             $item = Item::get(Item::GOLDEN_LEGGINGS, 0, 1);
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 2));
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné des jambières en Solarite protection 2!");
         } elseif($loots >= 9 && $loots <= 11) {
             $item = Item::get(Item::GOLDEN_CHESTPLATE, 0, 1);
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 2));
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné un plastron en Solarite protection 2!");
         } elseif($loots >= 11 && $loots <= 13) {
             $item = Item::get(Item::GOLDEN_HELMET, 0, 1);
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 2));
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné un casque en Solarite protection 2!");
         }  elseif ($loots >= 13 && $loots <= 14.5) {
             $bottes = Item::get(Item::LEATHER_BOOTS, 0, 1);
             $event->setDrops(array($bottes));
             $player->sendPopup("§c» §fTu as gagné des bottes en Iterium protection 1!");
         } elseif ($loots >= 14.5 && $loots <= 16) {
             $item = Item::get(Item::LEATHER_PANTS, 0, 1);
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné des jambières en Iterium protection 1!");
         } elseif ($loots >= 16 && $loots <= 17.5) {
             $item = Item::get(Item::LEATHER_TUNIC, 0, 1);
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné un plastron en Iterium protection 1!");
         } elseif ($loots >= 17.5 && $loots <= 19) {
             $item = Item::get(Item::LEATHER_HELMET, 0, 1);
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné un casque en Iterium protection 1!");
         } elseif($loots >= 19 && $loots <= 19.25) {
             $item = Item::get(Item::CHAIN_BOOTS, 0, 1);
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné des bottes en Topaze protection 2!");
         } elseif($loots >= 19.25 && $loots <= 19.5) {
             $item = Item::get(Item::CHAIN_LEGGINGS, 0, 1);
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné des jambières en Topaze protection 2!");
         } elseif($loots >= 19.5 && $loots <= 19.75) {
             $item = Item::get(Item::CHAIN_CHESTPLATE, 0, 1);
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné un plastron en Topaze protection 2!");
         } elseif($loots >= 19.75 && $loots <= 20) {
             $item = Item::get(Item::CHAIN_HELMET, 0, 1);
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné des bottes en Topaze protection 2!");
         } elseif($loots >= 20 && $loots <= 23.5) {
             $item = Item::get(Item::TURTLE_SHELL_PIECE, 0, 32);
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné 32 bandages!");
         } elseif($loots >= 23.5 && $loots <= 30) {
             $player->kill();
             Server::getInstance()->broadcastMessage("§c»" . $player->getName() . " §6est mort par un LuckyBlock");
         } elseif($loots >= 30 && $loots <= 100) {
             $player->sendPopup("§c» §fKaboum!");
             $explos = new Explosion(new Position($player->x, $player->y, $player->z, $player->getLevel()), 2, $this);
             $explos->explodeB();
             $explos->explodeA();
         } elseif ($loots >= 33 && $loots <= 38) {
             $player->sendPopup("§c» §fRécompense explosive");
             $explos = new Explosion(new Position($player->x, $player->y, $player->z, $player->getLevel()), 5, $this);
             $explos->explodeB();
         } elseif ($loots >= 38 && $loots <= 41) {
             $player->setOnFire(30);
             $effects = [
               new EffectInstance(Effect::getEffect(Effect::SLOWNESS), 20*30, 3),
               new EffectInstance(Effect::getEffect(Effect::BLINDNESS), 20*30, 3)
             ];
             foreach ($effects as $effect) {
                 $player->addEffect($effect);
             }
             $player->sendPopup("§c» Allumer le feu");
         } elseif ($loots >= 41 && $loots <= 46) {
             $event->setDrops(array(Item::get(Item::EGG)));
             $player->sendPopup("§c» §fTu as gagné 32 grenades");
         } elseif ($loots >= 46 && $loots <= 46.15) {
             Server::getInstance()->broadcastMessage("§c" . $player->getName() . " §6§l a gagné une couronne dans un LuckyBlock en Topaze§f§6!");
             $event->setDrops(array(Item::get(Item::DRAGON_BREATH, 0, 1)));
             $player->sendMessage("§e[§6o:§e] §cTu as gagné un item collector!");
             foreach (Server::getInstance()->getOnlinePlayers() as $p) {
                 $p->getLevel()->addSound(new GhastShootSound(new Vector3($p->getX(), $p->getY(), $p->getZ())));
             }
         } elseif ($loots >= 46.15 && $loots <= 50) {
             $event->setDrops(array(Item::get(463, 0, 2)));
             $player->sendPopup("§c» §fTu as gagné 2 spacecakes");
         } elseif ($loots >= 50 && $loots <= 59) {
             EconomyAPI::getInstance()->addMoney($player, 15000);
             $player->sendPopup("§c» §fTu as gagné §615000$");
         } elseif($loots >= 59 && $loots <= 63) {
             $item = Item::get(Item::DIAMOND_HELMET, 0, 1);
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 6));
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné un casque en diamant protection 6");
         } elseif($loots >= 63 && $loots <= 67) {
             $item = Item::get(Item::DIAMOND_HELMET, 0, 1);
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 6));
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné un plastron en diamant protection 6");
         } elseif($loots >= 67 && $loots <= 71) {
             $item = Item::get(Item::DIAMOND_LEGGINGS, 0, 1);
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 6));
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné des jambières en diamant protection 6");
         } elseif($loots >= 71 && $loots <= 75) {
             $item = Item::get(Item::DIAMOND_BOOTS, 0, 1);
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 6));
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné des bottes en diamant protection 6");
         } elseif($loots >= 75 && $loots <= 78) {
             EconomyAPI::getInstance()->setMoney($player, EconomyAPI::getInstance()->myMoney($player) / 2);
             $player->sendPopup("§c»§f Tu as perdu la moitié de ta money");
         } elseif ($loots >= 78 && $loots <= 79) {
             $player->sendPopup("§c»§f Tu as money a été mise à 0");
             EconomyAPI::getInstance()->setMoney($player, 0);
         } elseif ($loots >= 79 && $loots <= 87) {
             $player->getInventory()->addItem(Item::get(Item::HEART_OF_THE_SEA, 0, 1));
             $player->sendPopup("§c»§f Tu as gagné un sac à dos");
         } elseif ($loots >= 87 && $loots <= 90) {
             $item = Item::get(Item::DIAMOND_PICKAXE, 0, 1);
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY), 6));
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné une pioche en diamant efficacité 6 solidité 3");
         } elseif ($loots >= 90 && $loots <= 92) {
             $item = Item::get(Item::DIAMOND_HOE, 0, 1);
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY), 6));
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné une houe en diamant efficacité 6 solidité 3");
         } elseif ($loots >= 92 && $loots <= 94) {
             $item = Item::get(Item::DIAMOND_SWORD, 0, 1);
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 6));
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::FIRE_ASPECT), 2));
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné une épée en diamant tranchant 6 solidité 3 aura de feu 2");
         } elseif ($loots >= 94 && $loots <= 96) {
             $item = Item::get(Item::DIAMOND_AXE, 0, 1);
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY), 6));
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné une hache en diamant efficacité 6 solidité 3");
         } elseif ($loots >= 96 && $loots <= 98) {
             $item = Item::get(Item::DIAMOND_SHOVEL, 0, 1);
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
             $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY), 6));
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné une pelle en diamant efficacité 6 solidité 3");
         } elseif ($loots >= 98 && $loots <= 100) {
             $item = Item::get(Item::GOLDEN_SWORD, 0, 1);
             $event->setDrops(array($item));
             $player->sendPopup("§c» §fTu as gagné une épée en solarite");
         }
       }
    }

}