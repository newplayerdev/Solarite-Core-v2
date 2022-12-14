<?php


namespace NewPlayerMC\items\outils;


use pocketmine\block\Block;
use pocketmine\block\BlockToolType;
use pocketmine\entity\Entity;
use pocketmine\item\Item;

class NetheritePickaxe extends \pocketmine\item\Pickaxe
{
    public function __construct(int $meta = 0)
    {
        parent ::__construct(745, $meta, "Netherite Pickaxe", 5);
    }

    public function getBlockToolType(): int
    {
        return BlockToolType::TYPE_PICKAXE;
    }

    public function getBlockToolHarvestLevel(): int
    {
        return 5;
    }

    public function getMiningEfficiency(Block $block): float
    {
        return parent::getMiningEfficiency($block) * 2; // TODO: Change the autogenerated stub
    }

    protected function getBaseMiningEfficiency(): float
    {
        return 12; // TODO: Change the autogenerated stub
    }

    public function getMaxDurability(): int
    {
        return 2439;
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
        return self ::getBaseDamageFromTier($this -> tier) - 2;
    }

    public function onAttackEntity(Entity $victim): bool
    {
        return $this -> applyDamage(2);
    }




}