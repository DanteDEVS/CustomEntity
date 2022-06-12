# CustomEntity
Having problems with **CONVERTING AN ENTITY FROM PM3 TO PM4**, If yes use CustomEntity with mostly everything in pm3, Have anything missing report it at issues!
# Test Plugin
// Comming soon!
# How to use?
1. Virion usage
```yml
# in .poggit.yml
# below path:, add libs and then do this, example
    libs:
      - src: DanteDevs/De/De
        version: ^1.0.0
```
2. Usage in the file
```php
// to get the plugin do the following:
use DanteDevs\entity\CustomEntity;
```
3. Registering Entity
```php
// this register is quite different to pm4, this register is very much pm3
CustomEntity::registerEntity(class::EGG, true); // example
```
4. CreateBaseNBT
```php
// first the usage
use DanteDevs\entity\NBTEntity;
// after that now createBaseNbt
// first create a new function 
public function createEntity(Player $player, Location $location){ // example
            $nbt = NBTEntity::createBaseNBT( // NBTEntity::createBaseNBT is it
            $player->getTargetBlock(1), // example
            $player->getDirectionVector(), // example
            $location->yaw - 75, // example
            $location->pitch // example
        );
        // rest of the code, this is just a example so i wont put full code!
```
# more info
I wont put more about it but this is enough right?
if you have any suggestions pls tell them in the the issues tab and also report issues there!
  
