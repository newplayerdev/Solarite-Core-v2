<?php


namespace NewPlayerMC\events;


use NewPlayerMC\Solarite\Main;
use NewPlayerMC\tasks\ChestFinderTask;
use NewPlayerMC\tasks\PyromanTask;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockIds;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\item\Tool;
use pocketmine\item\Totem;
use pocketmine\level\Explosion;
use pocketmine\level\format\Chunk;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\HeartParticle;
use pocketmine\level\Position;
use pocketmine\level\sound\AnvilBreakSound;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\network\mcpe\protocol\OnScreenTextureAnimationPacket;
use pocketmine\Player;
use pocketmine\scheduler\TaskHandler;
use pocketmine\Server;
use pocketmine\tile\EnderChest;
use pocketmine\tile\Tile;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class InteractListener implements Listener
{
    /**
     * @var Config
     */
    public $db;

    /**
     * @var Config
     */
    public $recompenses;

    /**
     * @var int
     */
    public $count = 0;

    public $cooldown = [];
    public $boostCooldown = [];
    public $stickCoolDown = [];
    public $main;

    public function __construct(Main $main) {
       $this->main = $main;
       $this->recompenses = new Config($this->main->getDataFolder() . 'recompenses.yml', Config::YAML);
       $this->db = new Config($this->main->getDataFolder() . 'db', Config::YAML);
    }

    public function damage(EntityDamageByEntityEvent $event) {
        $damager = $event->getDamager();
        $entity = $event->getEntity();
        if($damager instanceof Player && $entity->namedtag->hasTag("§2==-§e Cadeau quotidien des §612 Coups De l'Horloge §2-==\n§6- §e§o Cliquez pour récupérer votre cadeau §r§6-")) {
          $time = $this->db->get($damager->getName());
          $timeN = time();
          if(empty($time)) {
              $time = 0;
          }
          if($timeN - $time >= 24*60*60) {
              $this->count++;
              $this->recompenses->get($this->count);
              $this->db->set($damager->getName(), $timeN);
              $this->db->save();
              $damager->sendMessage("§aTu as bien récupéré ton cadeau quotidien");
          } else {
              $hms = explode(":", gmdate("H:i:s", (24*60*60) - ($timeN - $time)));
              $damager->sendMessage("§cReviens dans $hms[0] heures(s) $hms[1] minute(s) et $hms[2] seconde(s)");
          }
        }
    }

    public function onInteract(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        $item = $event->getItem();

        if ($item->getId() === ItemIds::PAPER) {
            $lore = $item->getLore();
            if (intval($lore[0])) {
                EconomyAPI::getInstance()->addMoney($player, intval($lore[0]));
                $p = intval($lore[0]);
                $player->sendMessage("§c$p $ ont été ajouté(s) ");
                $player->getInventory()->remove($item);
            }
        }
        $block = $event->getBlock();
        $obsidian = Item::get(437, 0, 1);
        $level = $player->getLevel();

        if ($item->getId() === 1002 && $block->getId() === 49) {
            $lvl = $player->getLevel();
            $lvl->setBlock(new Vector3($block->getX(), $block->getY(), $block->getZ()), Block::get(0, 0));
            $player->getInventory()->removeItem($item->setCount(1));
        }
        if ($item->getId() == 351 && $item->getDamage() == 8) {
            if (!isset($this->cooldown[$player->getName()])) {
                $this->cooldown[$player->getName()] = time() + 180;
                foreach ($player->getInventory()->getContents() as $index => $item) {
                    if ($item instanceof Tool || $item instanceof Armor) {
                        if ($item->getDamage() > 0) {
                            $player->getInventory()->setItem($index, $item->setDamage(0));
                            $item->getMaxDurability();
                            $item->setDamage($item->getMaxDurability() - 1);

                        }
                    }
                }

                foreach ($player->getArmorInventory()->getContents() as $index => $item) {
                    if ($item instanceof Tool || $item instanceof Armor) {
                        if ($item->getDamage() > 0) {
                            $player->getArmorInventory()->setItem($index, $item->setDamage(0));
                        }
                    }
                }
                $player->sendPopup("§aTes items ont bien été réparé");
                $minX = $player->x - 1;
                $maxX = $player->x + 1;

                $minY = $player->y - 1;
                $maxY = $player->y + 1;

                $minZ = $player->z - 1;
                $maxZ = $player->z + 1;

                for ($x = $minX; $x <= $maxX; $x++) {

                    for ($y = $minY; $y <= $maxY; $y++) {

                        for ($z = $minZ; $z <= $maxZ; $z++) {

                            $player->getLevel()->addParticle(new HeartParticle(new Vector3($x, $y, $z)));
                        }

                    }

                }
            } else {
                if (time() < $this->cooldown[$player->getName()]) {
                    $remaining = $this->cooldown[$player->getName()] - time();

                } else {
                    unset($this->cooldown[$player->getName()]);
                }

            }
        }
        if ($item->getId() === 1001) {
            $effects = [
              new EffectInstance(Effect::getEffect(Effect::SPEED), 20*30, 1),
              new EffectInstance(Effect::getEffect(Effect::STRENGTH), 20*30, 1),
              new EffectInstance(Effect::getEffect(Effect::HEALTH_BOOST), 20*30,1)
            ];
            foreach ($effects as $effect) {
               $player->addEffect($effect);
             }
            } elseif ($item->getId() === 369) {
                if ($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR) {
                    if (!isset($this->boostCooldown[$player->getName()])) {
                        $this->boostCooldown[$player->getName()] = time() + 120;
                        $level->addSound(new AnvilBreakSound(new Vector3($player->getX(), $player->getY(), $player->getZ())));
                        $level->addParticle(new FlameParticle(new Vector3($player->getX(), $player->getY(), $player->getZ())));
                        $player->setMotion($player->getDirectionVector()->multiply(15));
                        $player->jump();
                    } else {
                        if (time() < $this->boostCooldown[$player->getName()]) {
                            $remaining = $this->boostCooldown[$player->getName()] - time();
                            $player->sendPopup("§cCooldown: " . $remaining . " secondes");
                        } else {
                            unset($this->boostCooldown[$player->getName()]);
                        }
                    }
                }
            } elseif ($item->getId() === 467) {
                $block = BlockFactory::get(BlockIds::ENDER_CHEST);
                $block->x = (int)$player->x;
                $block->y = (int)$player->y;
                $block->z = (int)$player->z;
                $block->level = $player->level;
                $player->getLevel()->sendBlocks([$player], [$block]);
                $tile = Tile::createTile(Tile::ENDER_CHEST, $block->getLevel(), EnderChest::createNBT($block));
                $player->getEnderChestInventory()->setHolderPosition($tile);
                $player->addWindow($player->getEnderChestInventory());
            }elseif ($item->getId() === ItemIds::ENCHANTED_BOOK && $item->getCustomName() === "§dVitesse") {
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 20*25, 1, true));
                $player->getInventory()->remove($item->setCount(1));
            }elseif ($item->getId() === ItemIds::ENCHANTED_BOOK && $item->getCustomName() === "§dTéléportation aléatoire") {
            $player->teleport(Server::getInstance()->getLevelByName("map2f")->getSafeSpawn(new Vector3(rand(rand(2300, -2300), rand(-2300, 2300)), rand(70, 100), rand(rand(2300, -2300), rand(-2300, 2300)))));
            $player->sendMessage("§aTu as bien été téléporté");
            $player->getInventory()->remove($item->setCount(1));
            }elseif ($item->getId() === ItemIds::ENCHANTED_BOOK && $item->getCustomName() === "§dChercheur de coffre") {
                $chunk = $this->getChunkFromPlayer($event->getPlayer());
                $numberOfChest = $this->getNumberOfChestInChunk($chunk);
                $player->sendMessage("$numberOfChest coffre se trouve autour de toi");
                $player->getInventory()->remove($item->setCount(1));
            }elseif ($item->getId() === ItemIds::ENCHANTED_BOOK && $item->getCustomName() === "§dSoin") {
            $player->setHealth($player->getMaxHealth());
            $player->getInventory()->remove($item->setCount(1));
            }elseif ($item->getId() === ItemIds::ENCHANTED_BOOK && $item->getCustomName() === "§dPyroman") {
            $this->main->getScheduler()->scheduleRepeatingTask(new PyromanTask($player), 20);
            $player->getInventory()->remove($item->setCount(1));
            }elseif ($item->getId() === ItemIds::ENCHANTED_BOOK && $item->getCustomName() === "§dComme un dieu") {
            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::HEALTH_BOOST), 20*4, 2));
            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::REGENERATION), 20*4, 2));
            $player->getInventory()->remove($item->setCount(1));
            }elseif ($item->getId() === ItemIds::ENCHANTED_BOOK && $item->getCustomName() === "§dKaboum") {
            $pos = new Position($player->getX(), $player->getY(), $player->getZ());
            $explos = new Explosion($pos, 2.3, true);
            $explos->explodeA();
            $explos->explodeB();
            }elseif ($item->getId() === ItemIds::ENCHANTED_BOOK && $item->getCustomName() === "§dBoule de feu" && $event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR) {
            $pos = $player->asVector3();
            $pos->y += $player->getEyeHeight();
            $nbt = Entity::createBaseNBT($pos);
            $entity = Entity::createEntity(Entity::FIREBALL, $player->getLevel(), $nbt, $player);
            $entity->spawnToAll();

            $direction = $player->getDirectionVector();
            $entity->setRotation($player->yaw, $player->pitch);
            $entity->setMotion($direction->multiply(1.5));
            }
    }

    private function getNumberOfChestInChunk(Chunk $chunk):int{
        $numberOfChest=0;
        for ($y = 0; $y < 256; $y++) {
            for ($x = 0; $x < 16; $x++) {
                for ($z = 0; $z < 16; $z++) {
                    $blockId = $chunk->getBlockId($x, $y, $z);
                    if($blockId===Block::CHEST){
                        $numberOfChest++;
                    }
                }
            }
        }
        return $numberOfChest;
    }
    private function getChunkFromPlayer(Player $player): Chunk{
        return $player->getLevel()->getChunk($player->getX() >> 4, $player->getZ() >> 4);
    }


}