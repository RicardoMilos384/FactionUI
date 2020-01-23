<?php

declare(strict_types=1);

namespace fu;

use jojoe77777\FormAPI\FormAPI;
use onebone\economyapi\EconomyAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class FcCmd extends Command implements PluginIdentifiableCommand{
	
	public function getPlugin() : Plugin{
}
	
	private $main;
	
	public function __construct(Main $main){
		$this->main = $main;
		parent::__construct("factionui", "FactionUI", "/factionui", ["fui", "fcui", "fu"]);
	}

    public function execute(CommandSender $sender, string $label, array $args){
		if(!$sender instanceof Player){
			$sender->sendMessage("§cUse command in game!");
			return false;
		}
		if(!isset($args[0]) || $args[0] !== "admin"){
			if($sender->hasPermission("factionui.cmd.use")){
				$this->normalForm($sender);
				return true;
			}else{
				$sender->sendMessage("§eYou don't have permission");
				return false;
			}
		}
		if($args[0] === "admin"){
			if($sender->hasPermission("factionui.use.admin")){
				$this->adminForm($sender);
			}else{
				$sender->sendMessage("§cYou don't have permission!");
				return false;
			}
		}
		return false;
	}
				
    public function normalForm(Player $sender){
	    $api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function(Player $sender, ?int $data){
			if(!isset($data)) return;
			switch($data){
						case 0:
						   break;
                        case 1:
                            $this->create($sender);
                            break;
                        case 2:
                            $this->main->getServer()->getCommandMap()->dispatch($sender, "f del");
                            break;
                        case 3:
                            $this->invite($sender);
                            break;
                        case 4:
                            $this->kick($sender);
                            break;
                        case 5:
                            $this->donate($sender);
                            break;
                        case 6:
                            $this->wd($sender);
                           break;
                        case 7:
                            $this->sethome($sender);
                            break;
                        case 8:
                            $this->main->getServer()->getCommandMap()->dispatch($sender, "f home");
                            break;
                        case 9:
                            $this->main->getServer()->getCommandMap()->dispatch($sender, "f top str");
                            break;
                         case 10:
                            $this->main->getServer()->getCommandMap()->dispatch($sender, "f top money");
                            break;
                         case 11:
                            break;
                          case 12:
                          $this->prm($sender);
                            break;
                           case 13:
                          $this->dmt($sender);
                            break;
                    }
            });
     
            $form->setTitle($this->setName() . "FactionsUI•");
					$form->addButton($this->setName() . "Choose Actions•");
					$form->addButton($this->setName() . "Create•");
					$form->addButton($this->setName() . "Delete•");
					$form->addButton($this->setName() . "Invite Player•");
					$form->addButton($this->setName() . "Kick Player•");
					$form->addButton($this->setName() . "Donate•");
					$form->addButton($this->setName() . "Withdraw•");
					$form->addButton($this->setName() . "Sethome•");
					$form->addButton($this->setName() . "Home•");
					$form->addButton($this->setName() . "Top Power•");
					$form->addButton($this->setName() . "Top Balance•");
					$form->addButton($this->setName() . "Promote•");
					$form->addButton($this->setName() . "Demote•");
                    $form->addButton($this->setName() . "Cancel•"); 
				    $form->sendToPlayer($sender);
        }
    public function create(Player $sender){
        	$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		    $f = $api->createCustomForm(function(Player $sender, ?array $data){
			if(!isset($data)) return;
			$this->main->getServer()->getCommandMap()->dispatch($sender, "f create $data[0]");
	    });
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addInput("Faction Name", "Hardcore");
		$f->sendToPlayer($sender);
	     }
	
	public function invite(Player $sender){
        	$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		    $f = $api->createCustomForm(function(Player $sender, ?array $data){
			if(!isset($data)) return;
			$this->main->getServer()->getCommandMap()->dispatch($sender, "f invite $data[0]");
	    });
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addInput("Player Name", "Bumbumkill");
		$f->sendToPlayer($sender);
	     }
	
	public function kick(Player $sender){
        	$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		    $f = $api->createCustomForm(function(Player $sender, ?array $data){
			if(!isset($data)) return;
			$this->main->getServer()->getCommandMap()->dispatch($sender, "f kick $data[0]");
	    });
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addInput("Player Name", "Bumbumkill");
		$f->sendToPlayer($sender);
	     }
	
	public function donate(Player $sender){
			$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		$f = $api->createSimpleForm(function(Player $sender, ?int $data){
			if(!isset($data)) return;
			switch($data){
                        case 0:
                            $this->slider($sender);
                            break;
                         case 1:
                            $this->input($sender);
                            break;
			}
	    });
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addButton($this->setName() . "Use Slider");
		$f->addButton($this->setName() . "Use Input");
		$f->sendToPlayer($sender);
     }
     
     public function slider(Player $sender){
        	$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		    $f = $api->createCustomForm(function(Player $sender, ?array $data){
			if(!isset($data)) return;
			$this->main->getServer()->getCommandMap()->dispatch($sender, "f donate $data[0]");
	    });
	    $economy = EconomyAPI::getInstance();
          $mn = $economy->myMoney($sender);
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addSlider("Amount", 1000, $mn);
		$f->sendToPlayer($sender);
	     }
	
	public function input(Player $sender){
        	$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		    $f = $api->createCustomForm(function(Player $sender, ?array $data){
			if(!isset($data)) return;
			$this->main->getServer()->getCommandMap()->dispatch($sender, "f donate $data[0]");
	    });
	    $mn = $this->eco->myMoney($sender);
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addInput("Amount", "1000");
		$f->sendToPlayer($sender);
	     }
	
	
	public function wd(Player $sender){
        	$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		    $f = $api->createCustomForm(function(Player $sender, ?array $data){
			if(!isset($data)) return;
			$this->main->getServer()->getCommandMap()->dispatch($sender, "f withdraw $data[0]");
	    });
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addInput("Amount", "1000");
		$f->sendToPlayer($sender);
	     }
	
	public function sethome(Player $sender){
        	$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		    $f = $api->createCustomForm(function(Player $sender, ?array $data){
			if(!isset($data)) return;
			$this->main->getServer()->getCommandMap()->dispatch($sender, "f sethome $data[0]");
	    });
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addInput("Home Name");
		$f->sendToPlayer($sender);
   }
   
   public function prm(Player $sender){
       	$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		    $f = $api->createCustomForm(function(Player $sender, ?array $data){
			if(!isset($data)) return;
			$this->main->getServer()->getCommandMap()->dispatch($sender, "f promote $data[0]");
	    });
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addInput("Player Name", "Bumbumkill");
		$f->sendToPlayer($sender);
   }
   
   public function dmt(Player $sender){
       	$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		    $f = $api->createCustomForm(function(Player $sender, ?array $data){
			if(!isset($data)) return;
			$this->main->getServer()->getCommandMap()->dispatch($sender, "f demote $data[0]");
	    });
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addInput("Player Name", "Bumbumkill");
		$f->sendToPlayer($sender);
   }
   
   public function adminForm(Player $sender){
				$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		        $form = $api->createSimpleForm(function(Player $sender, ?int $data){
			if(!isset($data)) return;
			switch($data){
						case 0:
						   break;
                        case 1:
                            $this->rmst($sender);
                            break;
                          case 2:
                             $this->amst($sender);
                             break;
                           case 3:
                            $this->rmbl($sender);
                            break;
                            case 4:
                            $this->adbl($sender);
                            break;
                            case 5:
                            $this->fcdl($sender);
                            break;
                            }
            });
     
                    $form->setTitle($this->setName() . "FactionsUI•");
					$form->addButton($this->setName() . "Choose Actions•");
					$form->addButton($this->setName() . "Remove Power•");
					$form->addButton($this->setName() . "Add Power•");
					$form->addButton($this->setName() . "Remove Balance•");
					$form->addButton($this->setName() . "Force Unclaim•");
					$form->addButton($this->setName() . "Force Delete•");
                    $form->addButton($this->setName() . "Cancel•"); 
				    $form->sendToPlayer($sender);
        }
        
        public function rmst(Player $sender){
       	$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		    $f = $api->createCustomForm(function(Player $sender, ?array $data){
			if(!isset($data)) return;
			$this->main->getServer()->getCommandMap()->dispatch($sender, "f rmpower $data[0] $data[1]");
	    });
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addInput("Faction Name", "Hardcore");
		$f->addInput("Amount");
		$f->sendToPlayer($sender);
   }
   
   public function amst(Player $sender){
       	$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		    $f = $api->createCustomForm(function(Player $sender, ?array $data){
			if(!isset($data)) return;
			$this->main->getServer()->getCommandMap()->dispatch($sender, "f addstrto $data[0] $data[1]");
	    });
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addInput("Faction Name", "Hardcore");
		$f->addInput("Amount");
		$f->sendToPlayer($sender);
   }
   
   public function rmbl(Player $sender){
       	$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		    $f = $api->createCustomForm(function(Player $sender, ?array $data){
			if(!isset($data)) return;
			$this->main->getServer()->getCommandMap()->dispatch($sender, "f rmbalto $data[0] $data[1]");
	    });
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addInput("Faction Name", "Hardcore");
		$f->addInput("Amount");
		$f->sendToPlayer($sender);
   }
   
   public function adbl(Player $sender){
       	$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		    $f = $api->createCustomForm(function(Player $sender, ?array $data){
			if(!isset($data)) return;
			$this->main->getServer()->getCommandMap()->dispatch($sender, "f forceunclaim $data[0]");
	    });
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addInput("Faction Name", "Hardcore");
		$f->sendToPlayer($sender);
   }
   
   public function fcdl(Player $sender){
       	$api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
		    $f = $api->createCustomForm(function(Player $sender, ?array $data){
			if(!isset($data)) return;
			$this->main->getServer()->getCommandMap()->dispatch($sender, "f forcedelete $data[0]");
	    });
		$f->setTitle($this->setName() . "FactionsUI");
		$f->addInput("Faction Name", "Hardcore");
		$f->sendToPlayer($sender);
   }
   
   private function setName(): string
	{
		$title = "§" . $this->getRandomColor();
		return $title;
	}

	/**
	 * @return mixed
	 */
	private function getRandomColor()
	{
		$colors = ["a§l•", "b§l•", "c§l•", "d§l•", "e§l•"];
		return $colors[array_rand($colors)];
	}
}
