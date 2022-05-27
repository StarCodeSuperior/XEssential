<?php

namespace Superior\EssentialX;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\Listener;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as C;
use pocketmine\math\vector3;
use pocketmine\utils\TextFormat;
use pocketmine\world\sound\EndermanTeleportSound;
use pocketmine\world\sound\PopSound;

class Main extends PluginBase implements Listener{

    public $onToggleFly = [];

    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool
    {
        $gmp = "superior.gm.others";
        switch($cmd->getName()){
            case "heal":
                if(isset($args[0])){

                    if($sender->hasPermission("superior.heal.others")){
                        //Permission for healing others found

                        //Getting player from subcommand of /heal
                        $p = $this->getServer()->getPlayerExact($args[0]);

                        if($p instanceof Player){
                            //$p found Online


                            //HEALING PLAYER
                            $p->setHealth(20);
                            $p->getHungerManager()->addFood(20);
                            $p->getEffects()->clear();

                            //HEALED NOW MESSAGE
                            $p->sendMessage(C::GOLD . "You've been healed by " . $sender->getName() . "!");
                            $sender->sendMessage(C::GOLD . "You successfully healed " . $p->getName());
                        }else{
                            //$p not found
                            $sender->sendMessage(C::RED . $args[0] . " Not Found");
                        }
                        
                    }else{
                        //permission for healing others not found
                        $sender->sendMessage(C::RED . "Insufficient Permission!");
                    }
                }else{
                    //Player healing self

                    if($sender instanceof Player){
                        //PLAYER IS VERIFIED THAT HE IS PLAYER IN-GAME
                        $sender->setHealth(20);
                        $sender->getHungerManager()->addFood(20);
                        $sender->getEffects()->clear();
                        $sender->sendMessage(C::GOLD . "You've successfully healed yourself");
                    }else{
                        //NON EXISTING PLAYER (CONSOLE, OR OTHER SOURCES)
                        $sender->sendMessage(C::RED . "usage: /heal {Player}");
                    }
                }
                break;

                case "feed":
                    if(isset($args[0])){

                        if($sender->hasPermission("superior.feed.others")){
                            //Permission for feeding others found
    
                            //Getting player from subcommand of /feed
                            $p = $this->getServer()->getPlayerExact($args[0]);
    
                            if($p instanceof Player){
                                //$p found Online
    
    
                                //FEEDING PLAYER
                                
                                $p->getHungerManager()->addFood(20);
                                
    
                                //FED NOW MESSAGE
                                $p->sendMessage(C::GOLD . "You've been fed by " . $sender->getName() . "!");
                                $sender->sendMessage(C::GOLD . "You successfully fed " . $p->getName());
                            }else{
                                //$p not found
                                $sender->sendMessage(C::RED . $args[0] . " Not Found");
                            }
                            
                        }else{
                            //permission for feeding others not found
                            $sender->sendMessage(C::RED . "Insufficient Permission!");
                        }
                    }else{
                        //Player feeding self
    
                        if($sender instanceof Player){
                            //PLAYER IS VERIFIED THAT HE IS PLAYER IN-GAME
                            $sender->getHungerManager()->addFood(20);
                            $sender->sendMessage(C::GOLD . "You've successfully fed yourself");
                        }else{
                            //NON EXISTING PLAYER (CONSOLE, OR OTHER SOURCES)
                            $sender->sendMessage(C::RED . "usage: /feed {Player}");
                        }
                    }
                    break;

                    //EXPLAINATION OVER::
            
                    case "gmc":

                        if(!isset($args[0])){
                            //array not found
                            if($sender instanceof Player){
                                //Player
                                if($sender->getGamemode() === GameMode::CREATIVE()){
                                    //creative

                                    $world = $sender->getWorld();
                                    $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new EndermanTeleportSound();

                                    $world->addSound($pos, $sound);
                                    $sender->sendMessage(TextFormat::RED . "You are Already in Creative!");
                                }else{
                                    $world = $sender->getWorld();
                                    $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new PopSound();

                                    $world->addSound($pos, $sound);
                                    $sender->setGamemode(GameMode::CREATIVE());
                                    $sender->sendMessage(TextFormat::GOLD . "Success!");
                                }
                            }else{
                                //NON Player
                                $sender->sendMessage(TextFormat::RED . "usage:  /gmc {Player}");
                            }
                        }else{
                            //array found
                            if($sender->hasPermission($gmp)){
                                //Permission 
                                $p = $this->getServer()->getPlayerExact($args[0]);
                                if($p instanceof Player){
                                    //Online
                                    if($p->getGamemode() === GameMode::CREATIVE()){
                                        //C
                                        if($sender instanceof Player){
                                            $world = $sender->getWorld();
                                        $x = $sender->getPosition()->getX();
                                        $y = $sender->getPosition()->getY();
                                        $z = $sender->getPosition()->getZ();
                                        $pos = new Vector3($x, $y, $z);
                                        $sound = new EndermanTeleportSound();

                                        $world->addSound($pos, $sound);
                                        $sender->sendMessage(TextFormat::YELLOW . $args[0] . TextFormat::RED .  " is Already in Creative!");
                                        }else{
                                            $sender->sendMessage(TextFormat::YELLOW . $args[0] . TextFormat::RED .  " is Already in Creative!");
                                        }
                                    }else{
                                        // no c

                                        $world = $p->getWorld();
                                        $x = $p->getPosition()->getX();
                                        $y = $p->getPosition()->getY();
                                        $z = $p->getPosition()->getZ();
                                        $pos = new Vector3($x, $y, $z);
                                        $sound = new PopSound();

                                        $world->addSound($pos, $sound);
                                        $p->setGamemode(GameMode::CREATIVE());
                                        $sender->sendMessage(TextFormat::GOLD . "Successfully set " . TextFormat::YELLOW . $args[0] . "'s" . TextFormat::GOLD . " Gamemode To creative");
                                        $p->sendMessage(TextFormat::MINECOIN_GOLD . "Your Gamemode was changed by " . TextFormat::RED . $sender->getName());

                                    }
                                }else{
                                    //Offline
                                    if($sender instanceof Player){
                                        $world = $sender->getWorld();
                                    $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new EndermanTeleportSound();

                                    $world->addSound($pos, $sound);
                                    $sender->sendMessage(TextFormat::RED . "Player Not Found Online.");
                                    }else{
                                        $sender->sendMessage(TextFormat::RED . "Player Not Found Online.");
                                    }
                                }
                            }else{
                                //permission error
                    
                                $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new EndermanTeleportSound();

                                    $world->addSound($pos, $sound);
                                    $sender->sendMessage(TextFormat::RED . "Insufficient Permission!");
                                
                            }

                        }
                    break;

                    case "gms":

                        if(!isset($args[0])){
                            //array not found
                            if($sender instanceof Player){
                                //Player
                                if($sender->getGamemode() === GameMode::SURVIVAL()){
                                    

                                    $world = $sender->getWorld();
                                    $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new EndermanTeleportSound();

                                    $world->addSound($pos, $sound);
                                    $sender->sendMessage(TextFormat::RED . "You are Already in Survival!");
                                }else{
                                    $world = $sender->getWorld();
                                    $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new PopSound();

                                    $world->addSound($pos, $sound);
                                    $sender->setGamemode(GameMode::SURVIVAL());
                                    $sender->sendMessage(TextFormat::GOLD . "Success!");
                                }
                            }else{
                                //NON Player
                                $sender->sendMessage(TextFormat::RED . "usage:  /gms {Player}");
                            }
                        }else{
                            //array found
                            if($sender->hasPermission($gmp)){
                                //Permission 
                                $p = $this->getServer()->getPlayerExact($args[0]);
                                if($p instanceof Player){
                                    //Online
                                    if($p->getGamemode() === GameMode::SURVIVAL()){
                                        //s
                                        if($sender instanceof Player){
                                            $world = $sender->getWorld();
                                        $x = $sender->getPosition()->getX();
                                        $y = $sender->getPosition()->getY();
                                        $z = $sender->getPosition()->getZ();
                                        $pos = new Vector3($x, $y, $z);
                                        $sound = new EndermanTeleportSound();

                                        $world->addSound($pos, $sound);
                                        $sender->sendMessage(TextFormat::YELLOW . $args[0] . TextFormat::RED .  " is Already in Survival!");
                                        }else{
                                            $sender->sendMessage(TextFormat::YELLOW . $args[0] . TextFormat::RED .  " is Already in Survival!");
                                        }
                                    }else{
                                        // no s

                                        $world = $p->getWorld();
                                        $x = $p->getPosition()->getX();
                                        $y = $p->getPosition()->getY();
                                        $z = $p->getPosition()->getZ();
                                        $pos = new Vector3($x, $y, $z);
                                        $sound = new PopSound();

                                        $world->addSound($pos, $sound);
                                        $p->setGamemode(GameMode::SURVIVAL());
                                        $sender->sendMessage(TextFormat::GOLD . "Successfully set " . TextFormat::YELLOW . $args[0] . "'s" . TextFormat::GOLD . " Gamemode To Survival");
                                        $p->sendMessage(TextFormat::MINECOIN_GOLD . "Your Gamemode was changed by " . TextFormat::RED . $sender->getName());

                                    }
                                }else{
                                    //Offline
                                    if($sender instanceof Player){
                                        $world = $sender->getWorld();
                                    $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new EndermanTeleportSound();

                                    $world->addSound($pos, $sound);
                                    $sender->sendMessage(TextFormat::RED . "Player Not Found Online.");
                                    }else{
                                        $sender->sendMessage(TextFormat::RED . "Player Not Found Online.");
                                    }
                                }
                            }else{
                                //permission error
                    
                                $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new EndermanTeleportSound();

                                    $world->addSound($pos, $sound);
                                    $sender->sendMessage(TextFormat::RED . "Insufficient Permission!");
                                
                            }

                        }
                    break;
                    case "gma":

                        if(!isset($args[0])){
                            //array not found
                            if($sender instanceof Player){
                                //Player
                                if($sender->getGamemode() === GameMode::ADVENTURE()){
                                    //adventure

                                    $world = $sender->getWorld();
                                    $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new EndermanTeleportSound();

                                    $world->addSound($pos, $sound);
                                    $sender->sendMessage(TextFormat::RED . "You are Already in Adventure!");
                                }else{
                                    $world = $sender->getWorld();
                                    $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new PopSound();

                                    $world->addSound($pos, $sound);
                                    $sender->setGamemode(GameMode::ADVENTURE());
                                    $sender->sendMessage(TextFormat::GOLD . "Success!");
                                }
                            }else{
                                //NON Player
                                $sender->sendMessage(TextFormat::RED . "usage:  /gma {Player}");
                            }
                        }else{
                            //array found
                            if($sender->hasPermission($gmp)){
                                //Permission 
                                $p = $this->getServer()->getPlayerExact($args[0]);
                                if($p instanceof Player){
                                    //Online
                                    if($p->getGamemode() === GameMode::ADVENTURE()){
                                        //A
                                        if($sender instanceof Player){
                                            $world = $sender->getWorld();
                                        $x = $sender->getPosition()->getX();
                                        $y = $sender->getPosition()->getY();
                                        $z = $sender->getPosition()->getZ();
                                        $pos = new Vector3($x, $y, $z);
                                        $sound = new EndermanTeleportSound();

                                        $world->addSound($pos, $sound);
                                        $sender->sendMessage(TextFormat::YELLOW . $args[0] . TextFormat::RED .  " is Already in Adventure!");
                                        }else{
                                            $sender->sendMessage(TextFormat::YELLOW . $args[0] . TextFormat::RED .  " is Already in Adventure!");
                                        }
                                    }else{
                                        // no A

                                        $world = $p->getWorld();
                                        $x = $p->getPosition()->getX();
                                        $y = $p->getPosition()->getY();
                                        $z = $p->getPosition()->getZ();
                                        $pos = new Vector3($x, $y, $z);
                                        $sound = new PopSound();

                                        $world->addSound($pos, $sound);
                                        $p->setGamemode(GameMode::ADVENTURE());
                                        $sender->sendMessage(TextFormat::GOLD . "Successfully set " . TextFormat::YELLOW . $args[0] . "'s" . TextFormat::GOLD . " Gamemode To Adventure");
                                        $p->sendMessage(TextFormat::MINECOIN_GOLD . "Your Gamemode was changed by " . TextFormat::RED . $sender->getName());

                                    }
                                }else{
                                    //Offline
                                    if($sender instanceof Player){
                                        $world = $sender->getWorld();
                                    $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new EndermanTeleportSound();

                                    $world->addSound($pos, $sound);
                                    $sender->sendMessage(TextFormat::RED . "Player Not Found Online.");
                                    }else{
                                        $sender->sendMessage(TextFormat::RED . "Player Not Found Online.");
                                    }
                                }
                            }else{
                                //permission error
                    
                                $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new EndermanTeleportSound();

                                    $world->addSound($pos, $sound);
                                    $sender->sendMessage(TextFormat::RED . "Insufficient Permission!");
                                
                            }

                        }
                    break;

                    case "gmsp":

                        if(!isset($args[0])){
                            //array not found
                            if($sender instanceof Player){
                                //Player
                                if($sender->getGamemode() === GameMode::SPECTATOR()){
                                    //spectator

                                    $world = $sender->getWorld();
                                    $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new EndermanTeleportSound();

                                    $world->addSound($pos, $sound);
                                    $sender->sendMessage(TextFormat::RED . "You are Already in Spectator!");
                                }else{
                                    $world = $sender->getWorld();
                                    $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new PopSound();

                                    $world->addSound($pos, $sound);
                                    $sender->setGamemode(GameMode::SPECTATOR());
                                    $sender->sendMessage(TextFormat::GOLD . "Success!");
                                }
                            }else{
                                //NON Player
                                $sender->sendMessage(TextFormat::RED . "usage:  /gmsp {Player}");
                            }
                        }else{
                            //array found
                            if($sender->hasPermission($gmp)){
                                //Permission 
                                $p = $this->getServer()->getPlayerExact($args[0]);
                                if($p instanceof Player){
                                    //Online
                                    if($p->getGamemode() === GameMode::SPECTATOR()){
                                        //C
                                        if($sender instanceof Player){
                                            $world = $sender->getWorld();
                                        $x = $sender->getPosition()->getX();
                                        $y = $sender->getPosition()->getY();
                                        $z = $sender->getPosition()->getZ();
                                        $pos = new Vector3($x, $y, $z);
                                        $sound = new EndermanTeleportSound();

                                        $world->addSound($pos, $sound);
                                        $sender->sendMessage(TextFormat::YELLOW . $args[0] . TextFormat::RED .  " is Already in Spectator!");
                                        }else{
                                            $sender->sendMessage(TextFormat::YELLOW . $args[0] . TextFormat::RED .  " is Already in Spectator!");
                                        }
                                    }else{
                                        // no sp

                                        $world = $p->getWorld();
                                        $x = $p->getPosition()->getX();
                                        $y = $p->getPosition()->getY();
                                        $z = $p->getPosition()->getZ();
                                        $pos = new Vector3($x, $y, $z);
                                        $sound = new PopSound();

                                        $world->addSound($pos, $sound);
                                        $p->setGamemode(GameMode::SPECTATOR());
                                        $sender->sendMessage(TextFormat::GOLD . "Successfully set " . TextFormat::YELLOW . $args[0] . "'s" . TextFormat::GOLD . " Gamemode To Spectator");
                                        $p->sendMessage(TextFormat::MINECOIN_GOLD . "Your Gamemode was changed by " . TextFormat::RED . $sender->getName());

                                    }
                                }else{
                                    //Offline
                                    if($sender instanceof Player){
                                        $world = $sender->getWorld();
                                    $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new EndermanTeleportSound();

                                    $world->addSound($pos, $sound);
                                    $sender->sendMessage(TextFormat::RED . "Player Not Found Online.");
                                    }else{
                                        $sender->sendMessage(TextFormat::RED . "Player Not Found Online.");
                                    }
                                }
                            }else{
                                //permission error
                    
                                $x = $sender->getPosition()->getX();
                                    $y = $sender->getPosition()->getY();
                                    $z = $sender->getPosition()->getZ();
                                    $pos = new Vector3($x, $y, $z);
                                    $sound = new EndermanTeleportSound();

                                    $world->addSound($pos, $sound);
                                    $sender->sendMessage(TextFormat::RED . "Insufficient Permission!");
                                
                            }

                        }
                    break;

            case "fly":
                //FLy
                if(isset($args[0])){
                    //array found
                    if($sender->hasPermission("superior.fly.others")){
                        //has permission
                        $p = $this->getServer()->getPlayerExact($args[0]);

                        if($p instanceof Player){
                            //Player Found
                            $this->FlyMode($p);
                            $p->sendMessage(C::RED . "Your Fly Was Toggled By " . $sender->getName());
                            $sender->sendMessage(C::GOLD . "Success!");
                        }else{
                            //Player Not Found
                            $sender->sendMessage(C::RED . "Invalid Player");
                        }
                    }else{
                        //no permission
                        $sender->sendMessage(C::RED . "Insufficient Permission");
                    }
                }else{
                    //self
                    if($sender instanceof Player){
                        //Player
                        $this->FlyMode($sender);
                        $sender->sendMessage(C::GOLD . "Toggled your Flight");
                    }else{
                        //Not A Player
                        $sender->sendMessage(C::RED . "usage: /fly {Player}");
                    }
                }
                
            break;

            case "spawn":
         
                
                //TODO spawn
                
                if(isset($args[0])){
                    //array
                    if($sender->hasPermission("superior.spawn.others")){
                        //permission found
                        $p =  $this->getServer()->getPlayerExact($args[0]);

                        if($p instanceof Player){
                            //player found
                            
                            
                        

                        }else{
                            //player not online
                        }
                    }else{
                        //permission not found
                    }
                }else{
                    //non array
                }
            break;
        }
        return true;
    }

    public function FlyMode(Player $player){
        if($player->getGamemode(GameMode::SURVIVAL())){
            //FLy NEEDED
            if(isset($this->onToggleFly[$player->getName()])){
                //DISABLE /FLY
                unset($this->onToggleFly[$player->getName()]);

                $player->setFlying(false);
                $player->setAllowFlight(false);
                
            }else{
                //ENABLE /FLY
                $this->onToggleFly[$player->getName()] = $player->getName();

                $player->setAllowFlight(true);
            }
        }else{
            //NON SURVIVAL
            if($player->getGamemode(GameMode::ADVENTURE())){
                //FLY NEEDED
                if(isset($this->onToggleFly[$player->getName()])){
                    //DISABLE /FLY
                    unset($this->onToggleFly[$player->getName()]);
    
                    $player->setFlying(false);
                    $player->setAllowFlight(false);
                    
                }else{
                    //ENABLE /FLY
                    $this->onToggleFly[$player->getName()] = $player->getName();
    
                    $player->setAllowFlight(true);
                }
            }else{
            }
            

            
        }
        return $player;
    }

}
