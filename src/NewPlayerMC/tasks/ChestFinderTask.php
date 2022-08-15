<?php


namespace NewPlayerMC\tasks;


use NewPlayerMC\Solarite\Main;
use pocketmine\block\Block;
use pocketmine\level\format\Chunk;
use pocketmine\Player;

class ChestFinderTask extends \pocketmine\scheduler\Task
{
    public $player;

    public function __construct(Player $player) {
        $this->player = $player;

    }
    public function onRun(int $currentTick)
    {
        $chunk=$this->getChunkFromPlayer($this->player);
        $numberOfChest=$this->getNumberOfChestInChunk($chunk);
        $this->player->sendTip("Il y a $numberOfChest coffre(s) dans ton chunck");
    }

    private function getNumberOfChestInChunk(Chunk $chunk):int{
        $numberOfChest=0;
        for ($y = 0; $y < 256; $y++) {
            for ($x = 0; $x < 32; $x++) {
                for ($z = 0; $z < 32; $z++) {
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