<?php


namespace NewPlayerMC\items;


use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\item\Food;
use pocketmine\item\Item;
use pocketmine\Player;

class Spacecake extends Food
{

    private $player;

    public function __construct()
    {
        $this->player = Player::class;
        parent::__construct(463, 0, "Cooked Salmon");
    }

    public function getFoodRestore(): int
    {
        return 1;
    }

    public function getSaturationRestore(): float
    {
       return 1;
    }

    public function requiresHunger(): bool
    {
        return false;
    }

    public function getMaxStackSize(): int
    {
        return 2;
    }

    public function getAdditionalEffects(): array
    {
        return [
            new EffectInstance(Effect::getEffect(Effect::LEVITATION), 20*25, -2),
            new EffectInstance(Effect::getEffect(Effect::JUMP_BOOST), 20*25, 0)
        ];
    }

}