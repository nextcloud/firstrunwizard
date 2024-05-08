<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2016 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FirstRunWizard\Notification;

use OCP\AppFramework\Utility\ITimeFactory;
use OCP\BackgroundJob\QueuedJob;
use OCP\Notification\IManager as INotificationManager;

class BackgroundJob extends QueuedJob {
	public function __construct(
		ITimeFactory $time,
		protected INotificationManager $notificationManager,
	) {
		parent::__construct($time);
	}

	/**
	 * @param array $argument
	 * @return void
	 */
	protected function run($argument) {
		$notification = $this->notificationManager->createNotification();
		$notification->setApp('firstrunwizard')
			->setSubject('profile')
			->setObject('user', $argument['uid'])
			->setUser($argument['uid']);

		if ($this->notificationManager->getCount($notification) === 0) {
			$notification->setDateTime($this->time->getDateTime());
			$this->notificationManager->notify($notification);
		}
	}
}
