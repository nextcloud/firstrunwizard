<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FirstRunWizard\Listener;

use OCA\FirstRunWizard\AppInfo\Application;
use OCA\FirstRunWizard\Notification\AppHint;
use OCA\FirstRunWizard\Notification\BackgroundJob;
use OCP\AppFramework\Services\IAppConfig;
use OCP\BackgroundJob\IJobList;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\IConfig;
use OCP\User\Events\UserLoggedInEvent;

/**
 * @template-implements IEventListener<UserLoggedInEvent>
 */
class UserLoggedInListener implements IEventListener {

	public function __construct(
		private IConfig $config,
		private IAppConfig $appConfig,
		private IJobList $jobList,
		private AppHint $appHint,
	) {
	}

	public function handle(Event $event): void {
		if (!$event instanceof UserLoggedInEvent) {
			return;
		}

		if (!$this->appConfig->getAppValueBool('wizard_enabled', true)) {
			return;
		}

		$lastSeenVersion = $this->config->getUserValue($event->getUid(), Application::APP_ID, 'show', '0.0.0');
		// If the user really uses Nextcloud for the very first time we create notifications for them
		// (compatibility with older wizard versions where the value was 1)
		if (version_compare($lastSeenVersion, '1', '<=')) {
			$this->jobList->add(BackgroundJob::class, ['uid' => $event->getUid()]);
		}

		if ($this->config->getSystemValueBool('appstoreenabled', true)) {
			$this->appHint->sendAppHintNotifications();
		}
	}
}
