<?php


namespace NewPlayerMC\entities;


use pocketmine\block\Block;
use pocketmine\level\particle\HugeExplodeParticle;
use pocketmine\math\RayTraceResult;

class Fireball extends \pocketmine\entity\projectile\Throwable
{
    const NETWORK_ID = self::FIREBALL;

    public $width = 5;
    public $height = 5;

    protected $gravity = 0;


    public function getName()
    {
        return "Fire Ball";
    }

    public function onHitBlock(Block $blockHit, RayTraceResult $hitResult): void
    {
        parent::onHitBlock($blockHit, $hitResult); // TODO: Change the autogenerated stub
        $this->getLevel()->addParticle(new HugeExplodeParticle($this->asVector3())); //TODO: FAKE EXPLOSIVE.
    }

    public function onUpdate(int $currentTick): bool
    {
        if ($this->closed) {
            return false;
        }

        $this->timings->startTiming();
        $this->updateMovement();
        $hasUpdate = parent::onUpdate($currentTick);

        if ($this->ticksLived > 1200 or $this->isCollided)
        {
            $this->flagForDespawn();
            $hasUpdate = true;
        }

        $this->timings->stopTiming();

        return $hasUpdate;
    }

}