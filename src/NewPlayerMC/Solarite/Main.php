<?php


namespace NewPlayerMC\Solarite;


use jojoe77777\FormAPI\SimpleForm;
use NewPlayerMC\armors\BottesIterium;
use NewPlayerMC\armors\BottesSolarite;
use NewPlayerMC\armors\BottesTopaze;
use NewPlayerMC\armors\CasqueIterium;
use NewPlayerMC\armors\CasqueSolarite;
use NewPlayerMC\armors\CasqueTopaze;
use NewPlayerMC\armors\JambieresIterium;
use NewPlayerMC\armors\JambieresSolarite;
use NewPlayerMC\armors\JambieresTopaze;
use NewPlayerMC\armors\PlastronIterium;
use NewPlayerMC\armors\PlastronSolarite;
use NewPlayerMC\armors\PlastronTopaze;
use NewPlayerMC\commands\atm\ATMCommand;
use NewPlayerMC\commands\boxs\Box;
use NewPlayerMC\commands\Competences;
use NewPlayerMC\commands\staff\Broacast;
use NewPlayerMC\commands\Cheque;
use NewPlayerMC\commands\staff\ClearInv;
use NewPlayerMC\commands\staff\GiveAll;
use NewPlayerMC\commands\staff\ClearLag;
use NewPlayerMC\commands\Ec;
use NewPlayerMC\commands\factions\RecrutementCommand;
use NewPlayerMC\commands\Feed;
use NewPlayerMC\commands\Furnace;
use NewPlayerMC\commands\gamemode\GmcCmd;
use NewPlayerMC\commands\gamemode\GmsCmd;
use NewPlayerMC\commands\gamemode\GmspcCmd;
use NewPlayerMC\commands\JoinMsg;
use NewPlayerMC\commands\Repair;
use NewPlayerMC\commands\StaffOnline;
use NewPlayerMC\commands\warps\Rtp;
use NewPlayerMC\commands\warps\Top;
use NewPlayerMC\commands\staff\Tpall;
use NewPlayerMC\commands\staff\Tps;
use NewPlayerMC\commands\warps\tasks\FfaTask;
use NewPlayerMC\commands\warps\tasks\MinageTask;
use NewPlayerMC\commands\warps\tasks\SpawnTask;
use NewPlayerMC\crafts\Crafts;
use NewPlayerMC\entities\Fireball;
use NewPlayerMC\entities\Iron_Golem;
use NewPlayerMC\events\BlockBreakListener;
use NewPlayerMC\events\CraftListener;
use NewPlayerMC\events\EatListener;
use NewPlayerMC\events\Halloween\CitrouilleHead;
use NewPlayerMC\events\Halloween\DropItemListener;
use NewPlayerMC\events\InteractListener;
use NewPlayerMC\events\JoinListener;
use NewPlayerMC\commands\fakes\FakeLeave;
use NewPlayerMC\events\PoseBlockListener;
use NewPlayerMC\events\worlds\LimitPlayersWolrdListener;
use NewPlayerMC\items\Bandage;
use NewPlayerMC\items\Grenade;
use NewPlayerMC\items\Hammer;
use NewPlayerMC\items\HangGlider;
use NewPlayerMC\items\LuckyTopaze;
use NewPlayerMC\commands\fakes\FakeJoin;
use NewPlayerMC\items\outils\Dague;
use NewPlayerMC\items\outils\NetheritePickaxe;
use NewPlayerMC\items\outils\NetheriteSword;
use NewPlayerMC\items\outils\EpeeSolarite;
use NewPlayerMC\items\outils\EpeeTopaze;
use NewPlayerMC\items\outils\NetheriteAxe;
use NewPlayerMC\items\outils\HacheSolarite;
use NewPlayerMC\items\outils\NetheriteHoe;
use NewPlayerMC\items\outils\HoueSolarite;
use NewPlayerMC\items\outils\PiocheSolarite;
use NewPlayerMC\items\outils\Seringue;
use NewPlayerMC\items\outils\Shulk;
use NewPlayerMC\items\ShulkerShell;
use NewPlayerMC\items\Spacecake;
use NewPlayerMC\items\TurtleShell;
use NewPlayerMC\tasks\ATM;
use NewPlayerMC\tasks\MessagesTask;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\BlazeRod;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\nbt\tag\StringTag;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use onebone\economyapi\EconomyAPI;
use pocketmine\utils\TextFormat as TF;

class Main extends PluginBase implements Listener
{
    public $config;
    public $slapper;
    public static $main;

    public function onEnable()
    {
        self::$main = $this;
        $this->getLogger()->info("§3SolariteCore §6enabled");

        //[Levels]\\
        $this->getServer()->loadLevel("map2f");
        $this->getServer()->loadLevel("map2m2");
        $this->getServer()->loadLevel("map2ffa");

        @mkdir($this->getDataFolder());
        @mkdir($this->getDataFolder()."players/");
        $this->saveResource('config.yml');
        $config = new Config($this->getDataFolder().'config.yml', Config::YAML);
        $this->config = $config;

        //[Commands]\\
        $this->getServer()->getCommandMap()->registerAll("commands", [
            new Feed("feed", "Régénérer votre barre de faim", "feed"),
            new Repair("repair", "Réparer vos items", "repair [all]", ['repair']),
            new Ec("ec", "Ouvrir votre enderchest", "ec", ['ender', 'echest']),
            new Furnace("furnace", "Faire cuire vos items", "furnace [all]"),
            new ClearInv("clear", "clear l'inventaire", "clear"),
            new FakeLeave("leave",  "simuler un message de deconnexion", "leave"),
            new FakeJoin("join", "simuler un message de connexion", "join"),
            new Tps("tps", "Voir les tps du serveur", "tps"),
            new Broacast("broadcast", "Envoyer un message à tout le monde", "broadcast <message>", ['bc']),
            new GmcCmd("gmc", "Changer votre mode de jeu en créatif", "gmc"),
            new GmsCmd("gms", "Changer votre mode de jeu en survie", "gms"),
            new GmspcCmd("gmspc", "Changer votre mode de jeu en spectateur", "gmspc"),
            new Cheque("cheque", "Créer un chèque", "cheque <prix>"),
            new Box("box", "Ouvrir une box", "box")
        ]);
        $this->getServer()->getCommandMap()->register("clearlag", new ClearLag($this));
        $this->getServer()->getCommandMap()->register("tpall", new Tpall($this));
        $this->getServer()->getCommandMap()->register("giveall", new GiveAll($this));
        $this->getServer()->getCommandMap()->register("atm", new  ATMCommand($this));
        $this->getServer()->getCommandMap()->register("top", new Top($this));
        $this->getServer()->getCommandMap()->register("rtp", new Rtp($this));
        $this->getServer()->getCommandMap()->register("recrutements", new RecrutementCommand($this));
        $this->getServer()->getCommandMap()->register("staffs", new StaffOnline($this));
        $this->getServer()->getCommandMap()->register("joinmsg", new JoinMsg($this));
        $this->getServer()->getCommandMap()->register("competences", new Competences($this));

        //[Events\\
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getPluginManager()->registerEvents(new CraftListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new EatListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new BlockBreakListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PoseBlockListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new JoinListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new InteractListener($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new LimitPlayersWolrdListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new HangGlider(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new CitrouilleHead(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new DropItemListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new Seringue(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new Bandage(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new LuckyTopaze(), $this);

        //[Items]\\
        ItemFactory::registerItem(new Hammer(), true);
        ItemFactory::registerItem(new Dague(), true);
        ItemFactory::registerItem(new Shulk(), true);
        ItemFactory::registerItem(new Spacecake(), true);
        ItemFactory::registerItem(new EpeeTopaze(), true);
        ItemFactory::registerItem(new ShulkerShell(), true);
        ItemFactory::registerItem(new TurtleShell(), true);
        ItemFactory::registerItem(new Spacecake(), true);
        ItemFactory::registerItem(new BlazeRod(), true);
        ItemFactory::registerItem(new Grenade(), true);
        ItemFactory::registerItem(new EpeeSolarite(), true);
        ItemFactory::registerItem(new PiocheSolarite(), true);
        ItemFactory::registerItem(new HoueSolarite(), true);
        ItemFactory::registerItem(new HacheSolarite(), true);

        ItemFactory::registerItem(new NetheriteHoe(), true);
        ItemFactory::registerItem(new NetheriteSword(), true);
        ItemFactory::registerItem(new NetheritePickaxe(), true);
        ItemFactory::registerItem(new NetheriteAxe(), true);
        ItemFactory::registerItem(new NetheritePickaxe(), true);
        Item::initCreativeItems();

        //[Armures]\\
        ItemFactory::registerItem(new BottesIterium(), true);
        ItemFactory::registerItem(new BottesSolarite(), true);
        ItemFactory::registerItem(new BottesTopaze(), true);
        ItemFactory::registerItem(new CasqueIterium(), true);
        ItemFactory::registerItem(new CasqueSolarite(), true);
        ItemFactory::registerItem(new CasqueTopaze(), true);
        ItemFactory::registerItem(new JambieresIterium(), true);
        ItemFactory::registerItem(new JambieresSolarite(), true);
        ItemFactory::registerItem(new JambieresTopaze(), true);
        ItemFactory::registerItem(new PlastronIterium(), true);
        ItemFactory::registerItem(new PlastronSolarite(), true);
        ItemFactory::registerItem(new PlastronTopaze(), true);

        //[Tasks]\\
        $this->getScheduler()->scheduleRepeatingTask(new MessagesTask($this), 20*rand(600, 1200));
        $this->getScheduler()->scheduleRepeatingTask(new ATM($this), 20*550);


        //[Crafts]\\
        $c = new Crafts();
        $c->init();

        //[Entities]\\
        Entity::registerEntity(Fireball::class, false, ['Fireball', 'minecraft:fireball']);
    }

    public function updateTopMoney() {
        $allMoney = EconomyAPI::getInstance()->getAllMoney();
        arsort($allMoney);

        $counter = 1;
        $text = "§6-§c§o Joueurs les plus riches du serveur §r§6-";

        foreach ($allMoney as $name => $money) {
            $text .= "\n" . $counter . "-" . $name . "-" . $money;
            $counter++;

        }

        foreach ($this->getServer()->getLevels() as $level) {
          foreach ($level->getEntities() as $entity) {
             if($entity->namedtag->hasTag("topmoney", StringTag::class)) {
              if($entity->namedtag->getString("topmoney") == "topmoney") {
                $entity->setNameTag($text);
                $entity->getDataPropertyManager()->setFloat(Entity::DATA_BOUNDING_BOX_HEIGHT, 3);
                $entity->getDataPropertyManager()->setFloat(Entity::DATA_SCALE, 0.0);
              }
             }
          }
        }
    }



    public function onCommand(CommandSender $player, Command $command, string $label, array $args): bool
    {
        if($player instanceof Player) {
            switch ($command->getName()) {
                case "spawn":
                   $this->getScheduler()->scheduleRepeatingTask(new SpawnTask($this, $player), 20);
                    break;
                case "minage":
                    $this->getScheduler()->scheduleRepeatingTask(new MinageTask($this, $player), 20);
                    break;
                case "ffa":
                    $this->getScheduler()->scheduleRepeatingTask(new FfaTask($this, $player), 20);
                    break;
            }
            return true;
        }
    }

    public static function getInstance(): self {
        return self::$main;
    }

    public function onJoin(PlayerJoinEvent $event)
    {
        if(!file_exists($this->getDataFolder()."players/".strtolower($event->getPlayer()->getName()).".yml")){

            $config = new Config($this->getDataFolder()."players/".strtolower($event->getPlayer()->getName()).".yml", Config::YAML);

            $config->set('mineur-xp',0);
            $config->set('assassin-xp',0);
            $config->set('agriculteur-xp',0);
            $config->set('athlete-xp',0);
            $config->set('forgeron-xp',0);

            $config->set('assassin-lvl',1);
            $config->set('mineur-lvl', 1);
            $config->set('agriculteur-lvl',1);
            $config->set('athlete-lvl',1);
            $config->set('forgeron-lvl',1);
            $config->save();

        }
        if(!file_exists($this->getDataFolder()."keys/".strtolower($event->getPlayer()->getName()).'yml')) {
           $keys = new Config($this->getDataFolder()."keys/".strtolower($event->getPlayer()->getName())."yml", Config::YAML);

           $keys->set("vote", 0);
           $keys->set("basique", 0);
           $keys->set("enchante", 0);
           $keys->set("minerai", 0);
           $keys->set("solarite", 0);
           $keys->set("iterium", 0);
           $keys->set("topaze", 0);
           $keys->set("key", 0);
        }

    }

    public function onCraft(CraftItemEvent $event)
    {
        $config = new Config($this->getDataFolder()."players/".strtolower($event->getPlayer()->getName()).".yml", Config::YAML);
        $player = $event->getPlayer();

        foreach($event->getOutputs() as $item){

//Partie d'interdiction des crafts (exemple)
            if($config->get('mineur-lvl') < 2) {

                if($item->getId() === 344){

                    $event->setCancelled(true);
                    $player->sendMessage(TF::RED . "Tu ne peux pas fabriquer ceci car tu n'es pas niveau 2 en mineur, execute '/job' pour savoir ton niveau. ");

                }
            }
//gains d'xp craft
            if ($config->get('forgeron-lvl') < 20) {
                if ($config->get('forgeron-xp') < 500 * $config->get('forgeron-lvl')) {

                    if($item->getId() === 300){
                        $rand = mt_rand(10,20);
                        $config->set('forgeron-xp', $config->get('forgeron-xp') + $rand);
                        $config->save();
                        $player->sendPopup("§2+ " . $rand . " xp");
                    }
                } else {

                    $config->set('forgeron-xp', 0);
                    $config->set('forgeron-lvl', $config->get('forgeron-lvl') + 1);
                    Server::getInstance()->broadcastMessage($player->getName() . "§b est maintenant niveau §e" . $config->get('assassin-lvl') . " §bau metier de forgeron.");
                    $config->save();
                }
            }
        }
    }

   

    public function getNetworkId(Entity $entity): int
    {
        return get_class($entity)::NETWORK_ID;
    }
    public function assassin(EntityDeathEvent $event){
        $entity = $event->getEntity();
        $last = $event->getEntity()->getLastDamageCause();
        if($last instanceof EntityDamageByEntityEvent) {
            $name = $event->getEntity()->getLastDamageCause()->getDamager();
            $config = new Config($this->getDataFolder()."players/".strtolower($name->getName()).".yml", Config::YAML);

            if ($event->getEntity() instanceof Entity) {

                if ($config->get('assassin-lvl') < 20) {

                    if ($config->get('assassin-xp') < 500 * $config->get('assassin-lvl')) {

                        switch ($this->getNetworkId($entity)) {
                            case 13:
                                $rand = mt_rand(10,20);
                                $config->set('assassin-xp', $config->get('assassin-xp') + $rand);
                                $config->save();
                                $name->sendPopup("§2+ " . $rand . " xp");
                                break;
                            case 11:
                                $rand = mt_rand(20,30);
                                $config->set('assassin-xp', $config->get('assassin-xp') + $rand);
                                $config->save();
                                $name->sendPopup("§2+ " . $rand . " xp");
                                break;
                            case 10:
                                $rand = mt_rand(10,20);
                                $config->set('assassin-xp', $config->get('assassin-xp') + $rand);
                                $config->save();
                                $name->sendPopup("§2+ " . $rand . " xp");
                                break;
                            case 12:
                                $rand = mt_rand(10,20);
                                $config->set('assassin-xp', $config->get('assassin-xp') + $rand);
                                $config->save();
                                $name->sendPopup("§2+ " . $rand . " xp");
                                break;
                            case 32:
                                $rand = mt_rand(15,25);
                                $config->set('assassin-xp', $config->get('assassin-xp') + $rand);
                                $config->save();
                                $name->sendPopup("§2+ " . $rand . " xp");
                                break;
                            case 33:
                                $rand = mt_rand(15,20);
                                $config->set('assassin-xp', $config->get('assassin-xp') + $rand);
                                $config->save();
                                $name->sendPopup("§2+ " . $rand . " xp");
                                break;
                            case 34:
                                $rand = mt_rand(10,15);
                                $config->set('assassin-xp', $config->get('assassin-xp') + $rand);
                                $config->save();
                                $name->sendPopup("§2+ " . $rand . " xp");
                                break;
                            case 35:
                                $rand = mt_rand(15,25);
                                $config->set('assassin-xp', $config->get('assassin-xp') + $rand);
                                $config->save();
                                $name->sendPopup("§2+ " . $rand . " xp");
                                break;

                        }

                    } else {

                        $config->set('assassin-xp', 0);
                        $config->set('assassin-lvl', $config->get('assassin-lvl') + 1);
                        Server::GetInstance()->broadcastMessage($name->getName() . "§b est maintenant niveau §e" . $config->get('assassin-lvl') . " §bau metier de assassin.");
                        $config->save();

                    }
                }
            }

            if($config->get('assassin-lvl') >= 20){

                if($config->get('assassin-xp') < 10000){

                    $config->set('assassin-xp',$config->get('assassin-xp')+0.0);
                    $config->save();

                } else {

                    $config->set('assassin-lvl',0);
                    $config->save();

                }

            }
        }
    }

    public function onmineur(BlockBreakEvent $event)
    {
        $config = new Config($this->getDataFolder()."players/".strtolower($event->getPlayer()->getName()).".yml", Config::YAML);
        $player = $event->getPlayer();
        $name = $player->getName();
        $block = $event->getBlock();

        if($config->get('mineur-lvl') < 20) {
            if ($config->get('mineur-xp') < 890 * $config->get('mineur-lvl')) {
                switch ($block->getId()) {
                    case 14:
                        $config->set('mineur-xp', $config->get('mineur-xp') + 15);
                        $config->save();
                        $player->sendPopup("§c+ §615xp");
                        //Solarite
                        break;
                    case 15:
                        $rand = mt_rand(3,5);
                        $config->set('mineur-xp', $config->get('mineur-xp') + $rand);
                        $config->save();
                        $player->sendPopup("§2 + " . $rand . " xp");
                        break;

                    case 56:
                        $rand = mt_rand(10,20);
                        $config->set('mineur-xp', $config->get('mineur-xp') + $rand);
                        $config->save();
                        $player->sendPopup("§2 + " . $rand . " xp");
                        break;

                    case 129:
                        $rand = mt_rand(100,1000);
                        $config->set('mineur-xp', $config->get('mineur-xp') + $rand);
                        $config->save();
                        $player->sendPopup("§2 + " . $rand . " xp");
                        break;

                    case 1:
                        $config->set('mineur-xp', $config->get('mineur-xp') + 0.5);
                        $config->save();
                        $player->sendPopup("§2+ §6" . 0.5 . "xp");
                        break;
                }

            } else {
                $config->set('mineur-xp', 0);
                $config->set('mineur-lvl', $config->get('mineur-lvl') + 1);
                $player->sendMessage("§c» §fBravo!!\n§eTu viens de passer §cniveau " . $config->get('mineur-lvl') . " §een métier de mineur");
                $pk = new LevelSoundEventPacket();
                $pk->sound = 62;
                $player->dataPacket($pk);
                $config->save();
            }

        }

        if($config->get('mineur-lvl') > 25){

            if($config->get('mineur-xp') < 10000 ){

                $config->set('mineur-xp',$config->get('mineur-xp')+0.0);
                $config->save();

            } else {

                $config->set('mineur-lvl',0);
                $config->save();

            }

        }
        if($config->get('agriculteur-lvl') < 20) {

            if ($config->get('agriculteur-xp') < 500 * $config->get('agriculteur-lvl')) {

                switch ($block->getID()) {

                    case 86:
                        $rand = mt_rand(5,10);
                        $config->set('agriculteur-xp', $config->get('agriculteur-xp') + $rand);
                        $config->save();
                        $player->sendPopup("§2 + " . $rand . " xp");
                        break;

                    case 103:
                        $rand = mt_rand(5,10);
                        $config->set('agriculteur-xp', $config->get('agriculteur-xp') + $rand);
                        $config->save();
                        $player->sendPopup("§2 + " . $rand . " xp");
                        break;

                    case 141:
                        $rand = mt_rand(6,12);
                        $config->set('agriculteur-xp', $config->get('agriculteur-xp') + $rand);
                        $config->save();
                        $player->sendPopup("§2 + " . $rand . " xp");
                        break;

                    case 142:
                        $rand = mt_rand(6,12);
                        $config->set('agriculteur-xp', $config->get('agriculteur-xp') + $rand);
                        $config->save();
                        $player->sendPopup("§2 + " . $rand . " xp");
                        break;

                    case 59:
                        $rand = mt_rand(6,12);
                        $config->set('agriculteur-xp', $config->get('agriculteur-xp') + $rand);
                        $config->save();
                        $player->sendPopup("§2 + " . $rand . " xp");
                        break;

                    case 244:
                        $rand = mt_rand(20,30);
                        $config->set('agriculteur-xp', $config->get('agriculteur-xp') + $rand);
                        $config->save();
                        $player->sendPopup("§2 + " . $rand . " xp");
                        break;

                }

            } else {

                $config->set('agriculteur-xp', 0);
                $config->set('agriculteur-lvl', $config->get('agriculteur-lvl') + 1);
                $player->sendMessage("§c» §fBravo!!\n§eTu viens de passer §cniveau " . $config->get('mineur-lvl') . " §een d'agriculteur de mineur");
                $pk = new LevelSoundEventPacket();
                $pk->sound = 62;
                $player->dataPacket($pk);
                $config->save();

            }

        }

        if($config->get('agriculteur-lvl') > 20){

            if($config->get('agriculteur-xp') < 10000 ){

                $config->set('agriculteur-xp',$config->get('agriculteur-xp')+0.0);
                $config->save();

            } else {

                $config->set('agriculteur-lvl',0);
                $config->save();

            }

        }
        if($config->get('-lvl') < 20) {

            if ($config->get('-xp') < 500 * $config->get('-lvl')) {

                switch ($block->getID()) {

                    case 17:
                        $rand = mt_rand(5,10);
                        $config->set('-xp', $config->get('-xp') + $rand);
                        $config->save();
                        $player->sendPopup("§2 + " . $rand . " xp");
                        break;
                }

            } else {

                $config->set('-xp', 0);
                $config->set('-lvl', $config->get('-lvl') + 1);
                Server::GetInstance()->broadcastMessage($name . "§b est maintenant niveau §e" . $config->get('-lvl') . " §bau metier de .");
                $config->save();

            }

        }

        if($config->get('-lvl') > 20){

            if($config->get('-xp') < 10000 ){

                $config->set('-xp',$config->get('-xp')+0.0);
                $config->save();

            } else {

                $config->set('-lvl',0);
                $config->save();

            }
        }
        if($config->get('athlete-lvl') < 20) {

            if ($config->get('athlete-xp') < 500 * $config->get('athlete-lvl')) {

                switch ($block->getID()) {

                    case 49:
                        $rand = mt_rand(5,10);
                        $config->set('athlete-xp', $config->get('athlete-xp') + $rand);
                        $config->save();
                        $player->sendPopup("§2 + " . $rand . " xp");
                        break;
                }

            } else {

                $config->set('athlete-xp', 0);
                $config->set('athlete-lvl', $config->get('athlete-lvl') + 1);
                Server::GetInstance()->broadcastMessage($name . "§b est maintenant niveau §e" . $config->get('athlete-lvl') . " §bau metier de athlete.");
                $config->save();

            }

        }

        if($config->get('athlete-lvl') > 20){

            if($config->get('athlete-xp') < 10000 ){

                $config->set('athlete-xp',$config->get('athlete-xp')+0.0);
                $config->save();

            } else {

                $config->set('athlete-lvl',0);
                $config->save();

            }
        }
    }

    public function mineurUI(Player $player)
    {
        $config = new Config($this->getDataFolder()."players/".strtolower($player->getName()).".yml", Config::YAML);
        $form = new SimpleForm(function (Player $player, $data){});
        $form->setTitle("§4Mineur");
        $form->setContent("Mineur information:");
        $form->addButton("Niveau(x):" . $config->get('mineur-lvl'));
        $form->addButton("XP: " . $config->get('mineur-xp') . "/" . 500 * $config->get('mineur-lvl'));
        $form->addButton(500 * $config->get('mineur-lvl') - $config->get('mineur-xp') . "xp restant pour le prochain niveau");
        $form->addButton(TF::RED . ">> Retour");
        $form->sendToPlayer($player);
    }

    public function assassinUI(Player $player)
    {
        $config = new Config($this->getDataFolder()."players/".strtolower($player->getName()).".yml", Config::YAML);
        $form = new SimpleForm(function (Player $player, $data){});
        $form->setTitle("§4assassin");
        $form->setContent("assassin information:");
        $form->addButton("Niveau(x):" . $config->get('assassin-lvl'));
        $form->addButton("XP: " . $config->get('assassin-xp') . "/" . 500 * $config->get('assassin-lvl'));
        $form->addButton(500 * $config->get('assassin-lvl') - $config->get('assassin-xp') . "xp restant pour le prochain niveau");
        $form->addButton(TF::RED . ">> Retour");
        $form->sendToPlayer($player);
    }
    public function agriculteurUI(Player $player)
    {
        $config = new Config($this->getDataFolder()."players/".strtolower($player->getName()).".yml", Config::YAML);
        $form = new SimpleForm(function (Player $player, $data){});
        $form->setTitle("§4agriculteur");
        $form->setContent("agriculteur information:");
        $form->addButton("Niveau(x):" . $config->get('agriculteur-lvl'));
        $form->addButton("XP: " . $config->get('agriculteur-xp') . "/" . 500 * $config->get('agriculteur-lvl'));
        $form->addButton(500 * $config->get('agriculteur-lvl') - $config->get('agriculteur-xp') . "xp restant pour le prochain niveau");
        $form->addButton(TF::RED . ">> Retour");
        $form->sendToPlayer($player);
    }

    public function forgeronUI(Player $player)
    {
        $config = new Config($this->getDataFolder()."players/".strtolower($player->getName()).".yml", Config::YAML);
        $form = new SimpleForm(function (Player $player, $data){});
        $form->setTitle("§4forgeron");
        $form->setContent("forgeron information:");
        $form->addButton("Niveau(x):" . $config->get('forgeron-lvl'));
        $form->addButton("XP: " . $config->get('forgeron-xp') . "/" . 500 * $config->get('forgeron-lvl'));
        $form->addButton(500 * $config->get('forgeron-lvl') - $config->get('forgeron-xp') . "xp restant pour le prochain niveau");
        $form->addButton(TF::RED . ">> Retour");
        $form->sendToPlayer($player);
    }

}