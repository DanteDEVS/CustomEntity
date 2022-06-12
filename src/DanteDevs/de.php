<?php

namespace DanteDevs;

use pocketmine\plugin\Plugin;

class de extends PluginBase;

 public function onEnable(): void 
 {
   $this->getLogger()->info("enabled!");
 }
}
