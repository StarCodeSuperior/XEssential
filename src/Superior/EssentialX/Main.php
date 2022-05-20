<?php

namespace Superior\EssentialX;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\Listener;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener{

    public function onEnable() : void {

        $this->getServer()->getPluginManager()->registerEvents($this, $this);

    }

    public function onDisable() : void {

    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{

        switch($cmd->getName()){

            
            case "heal":

                if($sender instanceof Player){
                    $sender->setHealth(20);
                    $sender->getHungerManager()->setFood(20);
                    $sender->getEffects()->clear();
                    $sender->sendMessage(TextFormat::GOLD . "You've Been Healed!");
                }else{
                    $sender->sendMessage(TextFormat::RED."Run This Command In-Game");
                }
            break;

            case "feed":
                if($sender instanceof Player){
                    $sender->getHungerManager()->setFood(40);
                    $sender->sendMessage(TextFormat::GOLD . "You've Been Feeded!");
                }
            break;

            case "gma":
                if($sender instanceof Player){
                    if($sender->getGamemode() === GameMode::ADVENTURE()){
                        $sender->sendMessage(TextFormat::RED . "You Are Already In Adventure Gamemode");
                    }else{
                        $sender->setGamemode(GameMode::ADVENTURE());
                        $sender->sendMessage(TextFormat::GOLD . "Successfully Updated Your Gamemode To Adventure!");
                    }
                }else{
                    $sender->sendMessage(TextFormat::RED."Run This Command In-Game");
                }
            break;

            case "gms":
                if($sender instanceof Player){
                    if($sender->getGamemode() === GameMode::SURVIVAL()){
                        $sender->sendMessage(TextFormat::RED . "You Are Already In Survival Gamemode");
                    }else{
                        $sender->setGamemode(GameMode::SURVIVAL());
                        $sender->sendMessage(TextFormat::GOLD . "Successfully Updated Your Gamemode To Survival!");
                    }
                }else{
                    $sender->sendMessage(TextFormat::RED."Run This Command In-Game");
                }
            break;

            case "gmc":
                if($sender instanceof Player){
                    if($sender->getGamemode() === GameMode::CREATIVE()){
                        $sender->sendMessage(TextFormat::RED . "You Are Already In Creative Gamemode");
                    }else{
                        $sender->setGamemode(GameMode::CREATIVE());
                        $sender->sendMessage(TextFormat::GOLD . "Successfully Updated Your Gamemode To Creative!");         
                    }
                }else{
                    $sender->sendMessage(TextFormat::RED."Run This Command In-Game");
                }
            break;

            case "gmsp":
                if($sender instanceof Player){
                    if($sender->getGamemode() === GameMode::SPECTATOR()){
                        $sender->sendMessage(TextFormat::RED . "You Are Already A Spectator");
                    }else{
                        $sender->setGamemode(GameMode::SPECTATOR());
                        $sender->sendMessage(TextFormat::GOLD . "Successfully Updated Your Gamemode To Spectator!");
                    }
                }else{
                    $sender->sendMessage(TextFormat::RED."Run This Command In-Game");
                }
            break;

            case "fly":

                if($sender instanceof Player){
                    //todo fly toggle
                }else{
                    $sender->sendMessage(TextFormat::RED."Run This Command In-Game");
                }
            break;

            case "top":
                if($sender instanceof Player){



                }else{
                    //console
                }
        }
        return true;
    }

    //FLY COMMAND TEST

    public function canFly(Player $player){

        //CAn Fly
        return $player->getAllowFlight();

    }

    //SetFlying
  
}