<?php
/**
 * @copyright Copyright (c) 2016 Joas Schilling <coding@schilljs.com>
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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\FirstRunWizard\Notification;

use OC\BackgroundJob\QueuedJob;
use OCP\Notification\IManager as INotificationManager;

class BackgroundJob extends QueuedJob  {

	/** @var INotificationManager */
	protected $notificationManager;

	/**
	 * BackgroundJob constructor.
	 *
	 * @param INotificationManager $notificationManager
	 */
	public function __construct(INotificationManager $notificationManager) {
		$this->notificationManager = $notificationManager;
	}

	/**
	 * @param array $argument
	 */
	protected function run($argument) {
		$notification = $this->notificationManager->createNotification();
		$notification->setApp('firstrunwizard')
			->setSubject('profile')
			->setObject('user', $argument['uid'])
			->setUser($argument['uid']);

		if ($this->notificationManager->getCount($notification) === 0) {
			$notification->setDateTime(new \DateTime());
			$this->notificationManager->notify($notification);
		}
	}
}
