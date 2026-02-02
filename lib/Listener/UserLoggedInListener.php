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
use OCP\Config\IUserConfig;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\IConfig;
use OCP\User\Events\UserLoggedInEvent;
use Override;

/**
 * @template-implements IEventListener<UserLoggedInEvent>
 */
class UserLoggedInListener implements IEventListener {

	public function __construct(
		private readonly IConfig $systemConfig,
		private readonly IAppConfig $appConfig,
		private readonly IUserConfig $userConfig,
		private readonly IJobList $jobList,
		private readonly AppHint $appHint,
	) {
	}

	#[Override]
	public function handle(Event $event): void {
		if (!$event instanceof UserLoggedInEvent) {
			return;
		}

		if (!$this->appConfig->getAppValueBool('wizard_enabled', true)) {
			return;
		}

		$lastSeenVersion = $this->userConfig->getValueString($event->getUid(), Application::APP_ID, 'show', '0.0.0');
		// If the user really uses Nextcloud for the very first time we create notifications for them
		// (compatibility with older wizard versions where the value was 1)
		if (version_compare($lastSeenVersion, '1', '<=')) {
			$this->jobList->add(BackgroundJob::class, ['uid' => $event->getUid()]);
		}

		if ($this->systemConfig->getSystemValueBool('appstoreenabled', true)) {
			$this->appHint->sendAppHintNotifications();
		}
	}
}
