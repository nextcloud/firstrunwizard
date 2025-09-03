<?php

/**
 * SPDX-FileCopyrightText: 2016 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FirstRunWizard\AppInfo;

use OCA\FirstRunWizard\Listener\AppEnabledListener;
use OCA\FirstRunWizard\Listener\BeforeTemplateRenderedListener;
use OCA\FirstRunWizard\Listener\UserLoggedInListener;
use OCA\FirstRunWizard\Notification\Notifier;
use OCP\App\Events\AppEnableEvent;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Http\Events\BeforeTemplateRenderedEvent;
use OCP\User\Events\UserLoggedInEvent;

class Application extends App implements IBootstrap {
	public const APP_ID = 'firstrunwizard';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}

	public function register(IRegistrationContext $context): void {
		$context->registerNotifierService(Notifier::class);

		$context->registerEventListener(AppEnableEvent::class, AppEnabledListener::class);
		$context->registerEventListener(UserLoggedInEvent::class, UserLoggedInListener::class);
		$context->registerEventListener(BeforeTemplateRenderedEvent::class, BeforeTemplateRenderedListener::class);
	}

	public function boot(IBootContext $context): void {
		// Everything is already done in register()
	}
}
