<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2020 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FirstRunWizard\Listener;

use OCA\FirstRunWizard\AppInfo\Application;
use OCA\FirstRunWizard\Constants;
use OCA\FirstRunWizard\Notification\AppHint;
use OCP\AppFramework\Http\Events\BeforeTemplateRenderedEvent;
use OCP\AppFramework\Services\IAppConfig;
use OCP\AppFramework\Services\IInitialState;
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
		private AppHint $appHint,
		private IInitialState $initialState,
		private Defaults $theming,
	) {
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
			}
		}

		Util::addStyle(Application::APP_ID, Application::APP_ID . '-style');
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
