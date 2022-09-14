<?php
/**
 * @copyright Copyright (c) 2019 Julius Härtl <jus@bitgrid.net>
 *
 * @author Julius Härtl <jus@bitgrid.net>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\FirstRunWizard\Notification;

use OCP\App\IAppManager;
use OCP\IConfig;
use OCP\IGroupManager;
use OCP\Notification\IManager as INotificationManager;

class AppHint {

	/** @var INotificationManager */
	protected $notificationManager;

	/** @var IGroupManager */
	protected $groupManager;

	/** @var IAppManager */
	protected $appManager;

	/** @var IConfig */
	protected $config;

	/** @var string */
	private $userId;

	public const APP_HINT_VERSION = '18';

	public function __construct(INotificationManager $notificationManager, IGroupManager $groupManager, IAppManager $appManager, IConfig $config, $userId) {
		$this->notificationManager = $notificationManager;
		$this->groupManager = $groupManager;
		$this->appManager = $appManager;
		$this->config = $config;
		$this->userId = $userId;
	}

	public function sendAppHintNotifications(): void {
		if ($this->userId !== null && $this->groupManager->isAdmin($this->userId) && $this->config->getUserValue($this->userId, 'firstrunwizard', 'apphint') !== self::APP_HINT_VERSION) {
			$this->sendNotification('recognize', $this->userId);
			$this->sendNotification('groupfolders', $this->userId);
			$this->sendNotification('forms', $this->userId);
			$this->sendNotification('deck', $this->userId);
			$this->sendNotification('tasks', $this->userId);
			$this->config->setUserValue($this->userId, 'firstrunwizard', 'apphint', self::APP_HINT_VERSION);
		}
	}

	protected function sendNotification(string $app, string $user): void {
		$notification = $this->generateNotification($app, $user);
		if (
			$this->config->getUserValue($this->userId, 'firstrunwizard', 'apphint') !== self::APP_HINT_VERSION
			&& $this->notificationManager->getCount($notification) === 0
			&& !$this->appManager->isEnabledForUser($app)
		) {
			$notification->setDateTime(new \DateTime());
			$this->notificationManager->notify($notification);
		}
		if ($this->notificationManager->getCount($notification) === 0) {
			return;
		}
	}

	public function dismissNotification(string $app) {
		$notification = $this->notificationManager->createNotification();
		$notification->setApp('firstrunwizard')
			->setSubject('apphint-'. $app)
			->setObject('app', $app);
		$this->notificationManager->markProcessed($notification);
	}

	protected function generateNotification(string $app, string $user) {
		$notification = $this->notificationManager->createNotification();
		$notification->setApp('firstrunwizard')
			->setSubject('apphint-'. $app)
			->setObject('app', $app)
			->setUser($user);
		return $notification;
	}
}
