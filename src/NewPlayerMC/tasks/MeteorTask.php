<?php


namespace NewPlayerMC\tasks;


use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\Server;

class MeteorTask extends \pocketmine\scheduler\Task
{
    /**
     * @var Player
     */
    public $player;

    public function __construct(Player $player) {
        $this->player = $player;
    }

    public function onRun(int $currentTick)
    {
        $player = $this->player;
        $pos = new Vector3(0, 50, 0);
        $pos->y += $player->getEyeHeight();
        $nbt = Entity::createBaseNBT($pos);
        $entity = Entity::createEntity(Entity::FIREBALL, $player->getLevel(), $nbt, $player);
        $entity->spawnToAll();

        $direction = new Vector3(0, 40, 0);
        $entity->setRotation($player->yaw, $player->pitch);
        $entity->setMotion($direction->multiply(1.5));
        Server::getInstance()->broadcastTitle("§4météorite");
    }
}