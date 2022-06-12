<?php
namespace DanteDevs\entity;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\math\Vector3;
use pocketmine\entity\Location;
use pocketmine\world\World;

abstract class CustomEntity extends Location {

	public const MOTION_THRESHOLD = 0.00001;
	protected const STEP_CLIP_MULTIPLIER = 0.4;

	public const NETWORK_ID = -1;

	public const DATA_TYPE_BYTE = 0;
	public const DATA_TYPE_SHORT = 1;
	public const DATA_TYPE_INT = 2;
	public const DATA_TYPE_FLOAT = 3;
	public const DATA_TYPE_STRING = 4;
	public const DATA_TYPE_COMPOUND_TAG = 5;
	public const DATA_TYPE_POS = 6;
	public const DATA_TYPE_LONG = 7;
	public const DATA_TYPE_VECTOR3F = 8;

	/*
	 * Readers beware: this isn't a nice list. Some of the properties have different types for different entities, and
	 * are used for entirely different things.
	 */
	public const DATA_FLAGS = 0;
	public const DATA_HEALTH = 1; //int (minecart/boat)
	public const DATA_VARIANT = 2; //int
	public const DATA_COLOR = 3, DATA_COLOUR = 3; //byte
	public const DATA_NAMETAG = 4; //string
	public const DATA_OWNER_EID = 5; //long
	public const DATA_TARGET_EID = 6; //long
	public const DATA_AIR = 7; //short
	public const DATA_POTION_COLOR = 8; //int (ARGB!)
	public const DATA_POTION_AMBIENT = 9; //byte
	/* 10 (byte) */
	public const DATA_HURT_TIME = 11; //int (minecart/boat)
	public const DATA_HURT_DIRECTION = 12; //int (minecart/boat)
	public const DATA_PADDLE_TIME_LEFT = 13; //float
	public const DATA_PADDLE_TIME_RIGHT = 14; //float
	public const DATA_EXPERIENCE_VALUE = 15; //int (xp orb)
	public const DATA_MINECART_DISPLAY_BLOCK = 16; //int (id | (data << 16))
	public const DATA_HORSE_FLAGS = 16; //int
	/* 16 (byte) used by wither skull */
	public const DATA_MINECART_DISPLAY_OFFSET = 17; //int
	public const DATA_SHOOTER_ID = 17; //long (used by arrows)
	public const DATA_MINECART_HAS_DISPLAY = 18; //byte (must be 1 for minecart to show block inside)
	public const DATA_HORSE_TYPE = 19; //byte
	/* 20 (unknown)
	 * 21 (unknown) */
	public const DATA_CHARGE_AMOUNT = 22; //int8, used for ghasts and also crossbow charging
	public const DATA_ENDERMAN_HELD_ITEM_ID = 23; //short
	public const DATA_ENTITY_AGE = 24; //short
	/* 25 (int) used by horse, (byte) used by witch */
	public const DATA_PLAYER_FLAGS = 26; //byte
	public const DATA_PLAYER_INDEX = 27; //int, used for marker colours and agent nametag colours
	public const DATA_PLAYER_BED_POSITION = 28; //blockpos
	public const DATA_FIREBALL_POWER_X = 29; //float
	public const DATA_FIREBALL_POWER_Y = 30;
	public const DATA_FIREBALL_POWER_Z = 31;
	/* 32 (unknown)
	 * 33 (float) fishing bobber
	 * 34 (float) fishing bobber
	 * 35 (float) fishing bobber */
	public const DATA_POTION_AUX_VALUE = 36; //short
	public const DATA_LEAD_HOLDER_EID = 37; //long
	public const DATA_SCALE = 38; //float
	public const DATA_HAS_NPC_COMPONENT = 39; //byte (???)
	public const DATA_NPC_SKIN_INDEX = 40; //string
	public const DATA_NPC_ACTIONS = 41; //string (maybe JSON blob?)
	public const DATA_MAX_AIR = 42; //short
	public const DATA_MARK_VARIANT = 43; //int
	public const DATA_CONTAINER_TYPE = 44; //byte (ContainerComponent)
	public const DATA_CONTAINER_BASE_SIZE = 45; //int (ContainerComponent)
	public const DATA_CONTAINER_EXTRA_SLOTS_PER_STRENGTH = 46; //int (used for llamas, inventory size is baseSize + thisProp * strength)
	public const DATA_BLOCK_TARGET = 47; //block coords (ender crystal)
	public const DATA_WITHER_INVULNERABLE_TICKS = 48; //int
	public const DATA_WITHER_TARGET_1 = 49; //long
	public const DATA_WITHER_TARGET_2 = 50; //long
	public const DATA_WITHER_TARGET_3 = 51; //long
	/* 52 (short) */
	public const DATA_BOUNDING_BOX_WIDTH = 53; //float
	public const DATA_BOUNDING_BOX_HEIGHT = 54; //float
	public const DATA_FUSE_LENGTH = 55; //int
	public const DATA_RIDER_SEAT_POSITION = 56; //vector3f
	public const DATA_RIDER_ROTATION_LOCKED = 57; //byte
	public const DATA_RIDER_MAX_ROTATION = 58; //float
	public const DATA_RIDER_MIN_ROTATION = 59; //float
	public const DATA_AREA_EFFECT_CLOUD_RADIUS = 61; //float
	public const DATA_AREA_EFFECT_CLOUD_WAITING = 62; //int
	public const DATA_AREA_EFFECT_CLOUD_PARTICLE_ID = 63; //int
	/* 64 (int) shulker-related */
	public const DATA_SHULKER_ATTACH_FACE = 65; //byte
	/* 66 (short) shulker-related */
	public const DATA_SHULKER_ATTACH_POS = 67; //block coords
	public const DATA_TRADING_PLAYER_EID = 68; //long

	/* 70 (byte) command-block */
	public const DATA_COMMAND_BLOCK_COMMAND = 71; //string
	public const DATA_COMMAND_BLOCK_LAST_OUTPUT = 72; //string
	public const DATA_COMMAND_BLOCK_TRACK_OUTPUT = 73; //byte
	public const DATA_CONTROLLING_RIDER_SEAT_NUMBER = 74; //byte
	public const DATA_STRENGTH = 75; //int
	public const DATA_MAX_STRENGTH = 76; //int
	/* 77 (int) */
	public const DATA_LIMITED_LIFE = 78;
	public const DATA_ARMOR_STAND_POSE_INDEX = 79; //int
	public const DATA_ENDER_CRYSTAL_TIME_OFFSET = 80; //int
	public const DATA_ALWAYS_SHOW_NAMETAG = 81; //byte: -1 = default, 0 = only when looked at, 1 = always
	public const DATA_COLOR_2 = 82; //byte
	/* 83 (unknown) */
	public const DATA_SCORE_TAG = 84; //string
	public const DATA_BALLOON_ATTACHED_ENTITY = 85; //int64, entity unique ID of owner
	public const DATA_PUFFERFISH_SIZE = 86; //byte
	public const DATA_BOAT_BUBBLE_TIME = 87; //int (time in bubble column)
	public const DATA_PLAYER_AGENT_EID = 88; //long
	/* 89 (float) related to panda sitting
	 * 90 (float) related to panda sitting */
	public const DATA_EAT_COUNTER = 91; //int (used by pandas)
	public const DATA_FLAGS2 = 92; //long (extended data flags)
	/* 93 (float) related to panda lying down
	 * 94 (float) related to panda lying down */
	public const DATA_AREA_EFFECT_CLOUD_DURATION = 95; //int
	public const DATA_AREA_EFFECT_CLOUD_SPAWN_TIME = 96; //int
	public const DATA_AREA_EFFECT_CLOUD_RADIUS_PER_TICK = 97; //float, usually negative
	public const DATA_AREA_EFFECT_CLOUD_RADIUS_CHANGE_ON_PICKUP = 98; //float
	public const DATA_AREA_EFFECT_CLOUD_PICKUP_COUNT = 99; //int
	public const DATA_INTERACTIVE_TAG = 100; //string (button text)
	public const DATA_TRADE_TIER = 101; //int
	public const DATA_MAX_TRADE_TIER = 102; //int
	public const DATA_TRADE_XP = 103; //int
	public const DATA_SKIN_ID = 104; //int ???
	/* 105 (int) related to wither */
	public const DATA_COMMAND_BLOCK_TICK_DELAY = 106; //int
	public const DATA_COMMAND_BLOCK_EXECUTE_ON_FIRST_TICK = 107; //byte
	public const DATA_AMBIENT_SOUND_INTERVAL_MIN = 108; //float
	public const DATA_AMBIENT_SOUND_INTERVAL_RANGE = 109; //float
	public const DATA_AMBIENT_SOUND_EVENT = 110; //string

	public const DATA_FLAG_ONFIRE = 0;
	public const DATA_FLAG_SNEAKING = 1;
	public const DATA_FLAG_RIDING = 2;
	public const DATA_FLAG_SPRINTING = 3;
	public const DATA_FLAG_ACTION = 4;
	public const DATA_FLAG_INVISIBLE = 5;
	public const DATA_FLAG_TEMPTED = 6;
	public const DATA_FLAG_INLOVE = 7;
	public const DATA_FLAG_SADDLED = 8;
	public const DATA_FLAG_POWERED = 9;
	public const DATA_FLAG_IGNITED = 10;
	public const DATA_FLAG_BABY = 11;
	public const DATA_FLAG_CONVERTING = 12;
	public const DATA_FLAG_CRITICAL = 13;
	public const DATA_FLAG_CAN_SHOW_NAMETAG = 14;
	public const DATA_FLAG_ALWAYS_SHOW_NAMETAG = 15;
	public const DATA_FLAG_IMMOBILE = 16, DATA_FLAG_NO_AI = 16;
	public const DATA_FLAG_SILENT = 17;
	public const DATA_FLAG_WALLCLIMBING = 18;
	public const DATA_FLAG_CAN_CLIMB = 19;
	public const DATA_FLAG_SWIMMER = 20;
	public const DATA_FLAG_CAN_FLY = 21;
	public const DATA_FLAG_WALKER = 22;
	public const DATA_FLAG_RESTING = 23;
	public const DATA_FLAG_SITTING = 24;
	public const DATA_FLAG_ANGRY = 25;
	public const DATA_FLAG_INTERESTED = 26;
	public const DATA_FLAG_CHARGED = 27;
	public const DATA_FLAG_TAMED = 28;
	public const DATA_FLAG_ORPHANED = 29;
	public const DATA_FLAG_LEASHED = 30;
	public const DATA_FLAG_SHEARED = 31;
	public const DATA_FLAG_GLIDING = 32;
	public const DATA_FLAG_ELDER = 33;
	public const DATA_FLAG_MOVING = 34;
	public const DATA_FLAG_BREATHING = 35;
	public const DATA_FLAG_CHESTED = 36;
	public const DATA_FLAG_STACKABLE = 37;
	public const DATA_FLAG_SHOWBASE = 38;
	public const DATA_FLAG_REARING = 39;
	public const DATA_FLAG_VIBRATING = 40;
	public const DATA_FLAG_IDLING = 41;
	public const DATA_FLAG_EVOKER_SPELL = 42;
	public const DATA_FLAG_CHARGE_ATTACK = 43;
	public const DATA_FLAG_WASD_CONTROLLED = 44;
	public const DATA_FLAG_CAN_POWER_JUMP = 45;
	public const DATA_FLAG_LINGER = 46;
	public const DATA_FLAG_HAS_COLLISION = 47;
	public const DATA_FLAG_AFFECTED_BY_GRAVITY = 48;
	public const DATA_FLAG_FIRE_IMMUNE = 49;
	public const DATA_FLAG_DANCING = 50;
	public const DATA_FLAG_ENCHANTED = 51;
	public const DATA_FLAG_SHOW_TRIDENT_ROPE = 52; // tridents show an animated rope when enchanted with loyalty after they are thrown and return to their owner. To be combined with DATA_OWNER_EID
	public const DATA_FLAG_CONTAINER_PRIVATE = 53; //inventory is private, doesn't drop contents when killed if true
	public const DATA_FLAG_TRANSFORMING = 54;
	public const DATA_FLAG_SPIN_ATTACK = 55;
	public const DATA_FLAG_SWIMMING = 56;
	public const DATA_FLAG_BRIBED = 57; //dolphins have this set when they go to find treasure for the player
	public const DATA_FLAG_PREGNANT = 58;
	public const DATA_FLAG_LAYING_EGG = 59;
	public const DATA_FLAG_RIDER_CAN_PICK = 60; //???
	public const DATA_FLAG_TRANSITION_SITTING = 61;
	public const DATA_FLAG_EATING = 62;
	public const DATA_FLAG_LAYING_DOWN = 63;
	public const DATA_FLAG_SNEEZING = 64;
	public const DATA_FLAG_TRUSTING = 65;
	public const DATA_FLAG_ROLLING = 66;
	public const DATA_FLAG_SCARED = 67;
	public const DATA_FLAG_IN_SCAFFOLDING = 68;
	public const DATA_FLAG_OVER_SCAFFOLDING = 69;
	public const DATA_FLAG_FALL_THROUGH_SCAFFOLDING = 70;
	public const DATA_FLAG_BLOCKING = 71; //shield
	public const DATA_FLAG_TRANSITION_BLOCKING = 72;
	public const DATA_FLAG_BLOCKED_USING_SHIELD = 73;
	public const DATA_FLAG_BLOCKED_USING_DAMAGED_SHIELD = 74;
	public const DATA_FLAG_SLEEPING = 75;
	public const DATA_FLAG_WANTS_TO_WAKE = 76;
	public const DATA_FLAG_TRADE_INTEREST = 77;
	public const DATA_FLAG_DOOR_BREAKER = 78; //...
	public const DATA_FLAG_BREAKING_OBSTRUCTION = 79;
	public const DATA_FLAG_DOOR_OPENER = 80; //...
	public const DATA_FLAG_ILLAGER_CAPTAIN = 81;
	public const DATA_FLAG_STUNNED = 82;
	public const DATA_FLAG_ROARING = 83;
	public const DATA_FLAG_DELAYED_ATTACKING = 84;
	public const DATA_FLAG_AVOIDING_MOBS = 85;
	public const DATA_FLAG_AVOIDING_BLOCK = 86;
	public const DATA_FLAG_FACING_TARGET_TO_RANGE_ATTACK = 87;
	public const DATA_FLAG_HIDDEN_WHEN_INVISIBLE = 88; //??????????????????
	public const DATA_FLAG_IS_IN_UI = 89;
	public const DATA_FLAG_STALKING = 90;
	public const DATA_FLAG_EMOTING = 91;
	public const DATA_FLAG_CELEBRATING = 92;
	public const DATA_FLAG_ADMIRING = 93;
	public const DATA_FLAG_CELEBRATING_SPECIAL = 94;

	public const DATA_PLAYER_FLAG_SLEEP = 1;
	public const DATA_PLAYER_FLAG_DEAD = 2; //TODO: CHECK

	/** @var int */
	public static $entityCount = 1;
	/**
	 * @var string[]
	 * @phpstan-var array<int|string, class-string<Entity>>
	 */
	private static $knownEntities = [];
	/**
	 * @var string[]
	 * @phpstan-var array<class-string<Entity>, string>
	 */
	private static $saveNames = [];
  
	/**
	 * Creates an entity with the specified type, level and NBT, with optional additional arguments to pass to the
	 * entity's constructor
	 *
	 * @param int|string  $type
	 * @param mixed       ...$args
	 */
	public static function createEntity($type, Level $level, CompoundTag $nbt, ...$args) : ?Entity{
		if(isset(self::$knownEntities[$type])){
			$class = self::$knownEntities[$type];
			/** @see Entity::__construct() */
			return new $class($level, $nbt, ...$args);
		}

		return null;
	}

	/**
	 * Registers an entity type into the index.
	 *
	 * @param string   $className Class that extends Entity
	 * @param bool     $force Force registration even if the entity does not have a valid network ID
	 * @param string[] $saveNames An array of save names which this entity might be saved under. Defaults to the short name of the class itself if empty.
	 * @phpstan-param class-string<Entity> $className
	 *
	 * NOTE: The first save name in the $saveNames array will be used when saving the entity to disk. The reflection
	 * name of the class will be appended to the end and only used if no other save names are specified.
	 */
	public static function registerEntity(string $className, bool $force = false, array $saveNames = []) : bool{
		$class = new \ReflectionClass($className);
		if(is_a($className, Entity::class, true) and !$class->isAbstract()){
			if($className::NETWORK_ID !== -1){
				self::$knownEntities[$className::NETWORK_ID] = $className;
			}elseif(!$force){
				return false;
			}

			$shortName = $class->getShortName();
			if(!in_array($shortName, $saveNames, true)){
				$saveNames[] = $shortName;
			}

			foreach($saveNames as $name){
				self::$knownEntities[$name] = $className;
			}

			self::$saveNames[$className] = reset($saveNames);

			return true;
		}

		return false;
	}
}
