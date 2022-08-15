<?php


namespace NewPlayerMC\items\outils;


use pocketmine\block\Block;
use pocketmine\block\BlockToolType;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use NewPlayerMC\items\TieredTool;
use pocketmine\math\Vector3;
use pocketmine\Player;

class EpeeSolarite extends \pocketmine\item\TieredTool
{

    public function __construct(int $meta = 0)
    {
        parent ::__construct(283, $meta, "Epée en Solarite", 5);
    }

    public function getBlockToolType(): int
    {
        return BlockToolType::TYPE_SWORD;
    }

    public function getAttackPoints(): int
    {
        return 8.5;
    }

    public function getBlockToolHarvestLevel(): int
    {
        return 1;
    }

    public function getMiningEfficiency(Block $block): float
    {
        return parent ::getMiningEfficiency($block) * 1.5;
    }

    protected function getBaseMiningEfficiency(): float
    {
        return 9;
    }

    public function onDestroyBlock(Block $block): bool
    {
        if ($block -> getHardness() > 0) {
            return $this -> applyDamage(2);
        }
        return false;
    }

    public function onAttackEntity(Entity $victim): bool
    {
        return $this -> applyDamage(1);
    }

    public function getMaxDurability(): int
    {
        return 2343;
    }

    public function isUnbreakable(): bool
    {
        return false; // TODO: Change the autogenerated stub
    }

}