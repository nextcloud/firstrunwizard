<?php

declare(strict_types=1);

/**
 * @copyright Copyright (c) 2020 Morris Jobke <hey@morrisjobke.de>
 *
 * @author Morris Jobke <hey@morrisjobke.de>
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
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\FirstRunWizard\Listener;

use OCA\FirstRunWizard\AppInfo\Application;
use OCA\FirstRunWizard\Notification\AppHint;
use OCP\AppFramework\Http\Events\BeforeTemplateRenderedEvent;
use OCP\BackgroundJob\IJobList;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\IConfig;
use OCP\IUser;
use OCP\IUserSession;
use OCP\Util;

class BeforeTemplateRenderedListener implements IEventListener {
	/**
	 * @var IUserSession
	 */
	private $userSession;
	/**
	 * @var IConfig
	 */
	private $config;
	/**
	 * @var AppHint
	 */
	private $appHint;
	/**
	 * @var IJobList
	 */
	private $jobList;

	public function __construct(
		IConfig $config,
		IUserSession $userSession,
		IJobList $jobList,
		AppHint $appHint
	) {
		$this->userSession = $userSession;
		$this->config = $config;
		$this->appHint = $appHint;
		$this->jobList = $jobList;
	}

	public function handle(Event $event): void {
		if (!$event instanceof BeforeTemplateRenderedEvent || !$event->isLoggedIn()) {
			return;
		}

		$user = $this->userSession->getUser();
		if (!$user instanceof IUser) {
			return;
		}

		if ($this->config->getUserValue($user->getUID(), Application::APP_ID, 'show', '1') !== '0') {
			Util::addScript(Application::APP_ID, 'activate');

			$this->jobList->add('OCA\FirstRunWizard\Notification\BackgroundJob', ['uid' => $this->userSession->getUser()->getUID()]);
		}

		if ($this->config->getSystemValueBool('appstoreenabled', true)) {
			$this->appHint->sendAppHintNotifications();
		}

		Util::addScript(Application::APP_ID, 'about');
	}
}
