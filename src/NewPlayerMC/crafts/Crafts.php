<?php


namespace NewPlayerMC\crafts;


use pocketmine\inventory\ShapedRecipe;
use pocketmine\item\Item;
use pocketmine\Server;

class Crafts
{
    public function init()
    {
        $obsibreaker = Item::get(2);
        $obsibreak = new ShapedRecipe([
            "ABA",
            "ACA",
            "ACA"
        ], [
            "A"=>Item::get(0),
            "B"=>Item::get(49),
            "C"=>Item::get(103)
        ], [
           $obsibreaker
        ]);

        $batonobsi = Item::get(103);
        $batonobsicraft = new ShapedRecipe([
            "AAA",
            "ABA",
            "AAA"
        ], [
            "A"=>Item::get(49),
            "B"=>Item::get(280)
        ], [
            $batonobsi
        ]);
        $casqueiterium = Item::get(748, 0, 1);
        $casqueiteriumcraft = new ShapedRecipe([
            "AAA",
            "ABA",
            "BBB"
        ], [
            "A"=>Item::get(742),
            "B"=>Item::get(0)
        ], [
          $casqueiterium
        ]);

        Server::getInstance()->getCraftingManager()->registerShapedRecipe($obsibreak);
        Server::getInstance()->getCraftingManager()->registerShapedRecipe($batonobsicraft);
        Server::getInstance()->getCraftingManager()->registerShapedRecipe($casqueiteriumcraft);
    }

}