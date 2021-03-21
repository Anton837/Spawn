<?php

namespace spawn;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\math\Vector3;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;


class Main extends PluginBase implements Listener{
  public $n,$m,$p;
  
  public function onEnable(){
    //Доступ к файлу cord.json
    $this->cord = new Config($this->getDataFolder() ."cord.json", Config::JSON);
    $this->getLogger()->info("§2Плагин запущен!");
    $this->getServer()->getPluginManager()->registerEvents($this,$this);
  }
  public function onDisable(){
    $this->getLogger()->info("§cПлагин выключен!");
  }
  public function getSpawnCord($cord) {
    return $this->cord->get($cord);
  }
  public function setSpawnCord($x=0,$y=67,$z=0) {
    $this->cord->set("x",$x);
    $this->cord->set("y",$y);
    $this->cord->set("z",$z);
    $this->cord->save();
    return true;
  }
  
  //Команды
  public function onCommand(CommandSender $sender, Command $command, $label, array $args):bool{
    if($command->getName() == "setspawn") {
      $pos = $sender->getPlayer();
      $this->n = ((float) $pos->getX());
      $this->m = ((float) $pos->getY());
      $this->p = ((float) $pos->getZ());
      $this->setSpawnCord($this->n,$this->m,$this->p);
      $sender->sendMessage("§2Точка спавна успешно создана.");
      return true;
    }
    //Команда spawn
    if($command->getName() == "spawn") {
      $x = $this->getSpawnCord("x");
      $y = $this->getSpawnCord("y");
      $z = $this->getSpawnCord("z");
      if ($y <= 0) {
        $sender->sendMessage("§cНа таких координатах нельзя устанавливать точку спавна!");
      } else {
        $sender->teleport(new Vector3(
          (float) $x,
          (float) $y,
          (float) $z));
        $sender->sendMessage("§2Телепорт на Spawn");
        return true;
      }
    }
  return true;
  }
}

?>
