<?php

declare(strict_types=1);

namespace NhanAZ\AntiFallDamage;

use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\permission\DefaultPermissions;
use pocketmine\event\entity\EntityDamageEvent;

class Main extends PluginBase implements Listener {

	protected function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig();
	}

	private function cancelCauseFallDamage(EntityDamageEvent $event): void {
		if ($event->getCause() !== EntityDamageEvent::CAUSE_FALL) {
			return;
		}
		$entity = $event->getEntity();
		if (!$entity instanceof Player) {
			return;
		}
		if ($this->getConfig()->get("permissions", false) === true &&
			!$entity->hasPermission("antifalldamage.use") &&
			!$entity->hasPermission(DefaultPermissions::ROOT_OPERATOR)) {
			return;
		}
		$event->cancel();
	}

	public function onEntityDamage(EntityDamageEvent $event): void {
		$entity = $event->getEntity();
		$worldName = $entity->getWorld()->getDisplayName();
		$worlds = $this->getConfig()->get("Worlds", []);
		if (!is_array($worlds)) {
			$worlds = [];
		}
		$mode = $this->getConfig()->get("Mode", "all");
		switch ($mode) {
			case "all":
				$this->cancelCauseFallDamage($event);
				break;
			case "whitelist":
				if (in_array($worldName, $worlds, true)) {
					$this->cancelCauseFallDamage($event);
				}
				break;
			case "blacklist":
				if (!in_array($worldName, $worlds, true)) {
					$this->cancelCauseFallDamage($event);
				}
				break;
			default:
				$this->cancelCauseFallDamage($event);
				break;
		}
	}
}
