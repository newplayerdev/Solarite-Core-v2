<?php


namespace NewPlayerMC\items\outils;


use pocketmine\block\Block;
use pocketmine\block\BlockToolType;
use pocketmine\entity\Entity;

class HacheSolarite extends \pocketmine\item\Axe
{

    public function __construct(int $meta = 0)
    {
        parent ::__construct(286, $meta, "Hache en Solarite", 5);
    }

    public function getBlockToolType(): int
    {
        return BlockToolType::TYPE_AXE;
    }

    public function getBlockToolHarvestLevel(): int
    {
        return 5;
    }

    public function getMaxDurability(): int
    {
        return 1951;
    }

    public function onDestroyBlock(Block $block): bool
    {
        if ($block -> getHardness() > 0) {
            return $this -> applyDamage(1);
        }
        return false;
    }

    public function getAttackPoints(): int
    {
        return self ::getBaseDamageFromTier($this -> tier) - 1;
    }

    public function onAttackEntity(Entity $victim): bool
    {
        return $this -> applyDamage(2);
    }

    public function getMiningEfficiency(Block $block): float
    {
        return parent::getMiningEfficiency($block) * 1.5; // TODO: Change the autogenerated stub
    }

    protected function getBaseMiningEfficiency(): float
    {
        return 11; // TODO: Change the autogenerated stub
    }

}