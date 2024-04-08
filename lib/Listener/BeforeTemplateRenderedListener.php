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
use OCA\FirstRunWizard\Constants;
use OCA\FirstRunWizard\Notification\AppHint;
use OCP\AppFramework\Http\Events\BeforeTemplateRenderedEvent;
use OCP\AppFramework\Services\IAppConfig;
use OCP\AppFramework\Services\IInitialState;
use OCP\BackgroundJob\IJobList;
use OCP\Defaults;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\IConfig;
use OCP\IUser;
use OCP\IUserSession;
use OCP\Util;

/**
 * @template-implements IEventListener<BeforeTemplateRenderedEvent>
 */
class BeforeTemplateRenderedListener implements IEventListener {

	public function __construct(
		private IConfig $config,
		private IAppConfig $appConfig,
		private IUserSession $userSession,
		private IJobList $jobList,
		private AppHint $appHint,
		private IInitialState $initialState,
		private Defaults $theming,
	) {
		$this->userSession = $userSession;
		$this->config = $config;
		$this->appHint = $appHint;
		$this->jobList = $jobList;
		$this->initialState = $initialState;
		$this->theming = $theming;
	}

	public function handle(Event $event): void {
		if (!$event instanceof BeforeTemplateRenderedEvent || !$event->isLoggedIn()) {
			return;
		}

		$user = $this->userSession->getUser();
		if (!$user instanceof IUser) {
			return;
		}

		if ($this->appConfig->getAppValueBool('wizard_enabled', true)) {
			$lastSeenVersion = $this->config->getUserValue($user->getUID(), Application::APP_ID, 'show', '0.0.0');

			// If current is newer then last seen we activate the wizard
			if (version_compare(Constants::CHANGELOG_VERSION, $lastSeenVersion, '>')) {
				Util::addScript(Application::APP_ID, Application::APP_ID . '-activate');
			}

			// If the user was already seen before (compatibility with older wizard versions where the value was 1)
			// then we only show the changelog
			if (version_compare($lastSeenVersion, '1', '>')) {
				$this->initialState->provideInitialState('changelogOnly', true);
			} else {
				// Otherwise if the user really uses Nextcloud for the very first time we create notifications for them
				$this->jobList->add('OCA\FirstRunWizard\Notification\BackgroundJob', ['uid' => $this->userSession->getUser()->getUID()]);
			}

			if ($this->config->getSystemValueBool('appstoreenabled', true)) {
				$this->appHint->sendAppHintNotifications();
			}
		}

		Util::addScript(Application::APP_ID, Application::APP_ID . '-about');

		$this->initialState->provideInitialState(
			'desktop',
			$this->config->getSystemValue('customclient_desktop', $this->theming->getSyncClientUrl())
		);

		$this->initialState->provideInitialState(
			'android',
			$this->config->getSystemValue('customclient_android', $this->theming->getAndroidClientUrl())
		);

		$this->initialState->provideInitialState(
			'ios',
			$this->config->getSystemValue('customclient_ios', $this->theming->getiOSClientUrl())
		);
	}
}
