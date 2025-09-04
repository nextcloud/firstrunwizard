<?php

/**
 * SPDX-FileCopyrightText: 2019 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FirstRunWizard\Notification;

use OCP\App\IAppManager;
use OCP\IConfig;
use OCP\IGroupManager;
use OCP\Notification\IManager as INotificationManager;

class AppHint {
	public const APP_HINT_VERSION = '19';

	public function __construct(
		private INotificationManager $notificationManager,
		private IGroupManager $groupManager,
		private IAppManager $appManager,
		private IConfig $config,
		private ?string $userId,
	) {
	}

	public function sendAppHintNotifications(): void {
		if ($this->userId !== null
			&& $this->groupManager->isAdmin($this->userId)
			&& $this->config->getUserValue($this->userId, 'firstrunwizard', 'apphint') !== self::APP_HINT_VERSION
		) {
			$this->sendNotification('recognize', $this->userId);
			$this->sendNotification('groupfolders', $this->userId);
			$this->sendNotification('forms', $this->userId);
			$this->sendNotification('deck', $this->userId);
			$this->sendNotification('tasks', $this->userId);
			$this->sendNotification('whiteboard', $this->userId);
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
			->setSubject('apphint-' . $app)
			->setObject('app', $app);
		$this->notificationManager->markProcessed($notification);
	}

	protected function generateNotification(string $app, string $user) {
		$notification = $this->notificationManager->createNotification();
		$notification->setApp('firstrunwizard')
			->setSubject('apphint-' . $app)
			->setObject('app', $app)
			->setUser($user);
		return $notification;
	}
}
