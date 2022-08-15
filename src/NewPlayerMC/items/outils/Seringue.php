<?php


namespace NewPlayerMC\items\outils;


use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\Player;

class Seringue implements \pocketmine\event\Listener
{
    public function onEntityDamage(EntityDamageEvent $event)
    {

        if ($event instanceof EntityDamageByEntityEvent) {

            $player = $event->getEntity();
            $damager = $event->getDamager();
            $seringue = Item::get(445, 0, 1);

            if($damager instanceof Player){

                $item = $damager->getInventory()->getItemInHand();

                if($item->getId() === 445) {

                    $this->getDamage($event,$player,6);
                    $effects = [
                        new EffectInstance(Effect::getEffect(Effect::POISON), 20*40, 2, false),
                        new EffectInstance(Effect::getEffect(Effect::NAUSEA), 20*45, 3, false)
                    ];
                    foreach ($effects as $effect) {
                        $player->addEffect($effect);
                    }
                    $this->getDamage($event, $player, 6);
                    $damager->getInventory()->remove($seringue);
                }

            }

        }

    }

    public function getDamage($event , $player, int $basedamage)
    {
        $event->setModifier($basedamage,6);

        if($event->canBeReducedByArmor()){

            $event->setModifier(-$event->getFinalDamage() * $player->getArmorPoints() * 0.04, EntityDamageEvent::MODIFIER_ARMOR);

        }

        $cause = $event->getCause();

        if($player->hasEffect(Effect::DAMAGE_RESISTANCE) and $cause !== EntityDamageEvent::CAUSE_VOID and $cause !== EntityDamageEvent::CAUSE_SUICIDE){

            $event->setModifier(-$event->getFinalDamage() * min(1, 0.2 * $player->getEffect(Effect::DAMAGE_RESISTANCE)->getEffectLevel()), EntityDamageEvent::MODIFIER_RESISTANCE);

        }

        $totalEpf = 0;

        foreach($player->getArmorInventory()->getContents() as $item){

            if($item instanceof Armor){

                $totalEpf += $item->getEnchantmentProtectionFactor($event);

            }

        }

        $event->setModifier(-$event->getFinalDamage() * min(ceil(min($totalEpf, 25) * (mt_rand(50, 100) / 100)), 20) * 0.04, EntityDamageEvent::MODIFIER_ARMOR_ENCHANTMENTS);
        $event->setModifier(-min($player->getAbsorption(), $event->getFinalDamage()), EntityDamageEvent::MODIFIER_ABSORPTION);
    }

}