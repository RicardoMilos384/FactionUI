<?php

declare(strict_types=1);

namespace fu;

use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use fu\FcCmd;

class Main extends PluginBase implements Listener {

	public function onEnable(){
		@eval(base64_decode("JHRoaXMtPmdldExvZ2dlcigpLT5ub3RpY2UoInBsdWdpbiBjcmVhdGUgYnkgYnVtYnVta2lsbCIpOw=="));
		$this->getServer()->getCommandMap()->register("fui", new FcCmd($this));
	}
}
