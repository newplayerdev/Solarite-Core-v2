<?php


namespace NewPlayerMC\commands;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class Feed extends Command
{
    public $cooldownFeed = [];

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);

    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {

            if ($player instanceof Player) {
                if (!$this->hasPermissions($player)) {
                    $player->sendMessage(TextFormat::RED . "Tu n'as pas la permission d'utiliser cette commande");
                    return false;
                }

                if (!isset($this->inCooldown[$player->getName()])) {
                    $this->cooldownFeed[$player->getName()] = time() + 20;
                    $player->addFood(50);
                    $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SATURATION), 20*90, 2, false));
                } else {
                    if (time() < $this->cooldownFeed[$player->getName()]) {
                        $remaining = $this->cooldownFeed[$player->getName()] - time();
                        $player->sendMessage("§cCooldown: " . $remaining . " secondes.");

                    } else {
                        unset($this->cooldownFeed[$player->getName()]);
                    }

                }
            }
            return true;
    }

    public function hasPermissions(Player $sender):bool {
        return $sender->hasPermission("feed.use");
    }

}