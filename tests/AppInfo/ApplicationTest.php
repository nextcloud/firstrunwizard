<?php

/**
 * SPDX-FileCopyrightText: 2016 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FirstRunWizard\Tests\AppInfo;

use OCA\FirstRunWizard\AppInfo\Application;
use OCA\FirstRunWizard\Controller\WizardController;
use OCA\FirstRunWizard\Notification\BackgroundJob;
use OCA\FirstRunWizard\Notification\Notifier;
use OCP\AppFramework\App;
use OCP\AppFramework\Controller;
use OCP\BackgroundJob\IJob;
use OCP\Notification\INotifier;
use Test\TestCase;

/**
 * Class ApplicationTest
 *
 * @package OCA\FirstRunWizard\Tests\AppInfo
 */
#[\PHPUnit\Framework\Attributes\Group('DB')]
class ApplicationTest extends TestCase {
	protected ?Application $app = null;

	public function testContainerAppName(): void {
		$app = new Application();
		$this->assertEquals('firstrunwizard', $app->getContainer()->getAppName());
	}

	public static function dataContainerQuery(): array {
		return [
			[Application::class, Application::class],
			[Application::class, App::class],

			[WizardController::class, WizardController::class],
			[WizardController::class, Controller::class],

			[Notifier::class, Notifier::class],
			[Notifier::class, INotifier::class],

			[BackgroundJob::class, BackgroundJob::class],
			[BackgroundJob::class, IJob::class],
		];
	}

	#[\PHPUnit\Framework\Attributes\DataProvider('dataContainerQuery')]
	public function testContainerQuery(string $service, string $expected): void {
		$app = new Application();
		$this->assertInstanceOf($expected, $app->getContainer()->query($service));
	}
}
