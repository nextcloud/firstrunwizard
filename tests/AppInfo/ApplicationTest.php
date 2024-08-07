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
 * @group DB
 */
class ApplicationTest extends TestCase {
	/** @var \OCA\FirstRunWizard\AppInfo\Application */
	protected $app;

	/** @var \OCP\AppFramework\IAppContainer */
	protected $container;

	public function testContainerAppName() {
		$app = new Application();
		$this->assertEquals('firstrunwizard', $app->getContainer()->getAppName());
	}

	public function dataContainerQuery() {
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

	/**
	 * @dataProvider dataContainerQuery
	 * @param string $service
	 * @param string $expected
	 */
	public function testContainerQuery($service, $expected) {
		$app = new Application();
		$this->assertInstanceOf($expected, $app->getContainer()->query($service));
	}
}
