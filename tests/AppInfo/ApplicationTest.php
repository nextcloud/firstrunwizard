<?php
/**
 * @copyright Copyright (c) 2016, Joas Schilling <coding@schilljs.com>
 *
 * @author Joas Schilling <coding@schilljs.com>
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

namespace OCA\FirstRunWizard\Tests\AppInfo;


use OCA\FirstRunWizard\AppInfo\Application;
use OCA\FirstRunWizard\Controller\WizardController;
use OCA\FirstRunWizard\Notification\BackgroundJob;
use OCA\FirstRunWizard\Notification\Notifier;
use OCP\AppFramework\App;
use OCP\AppFramework\Controller;
use OCP\BackgroundJob\IJob;
use OCP\Notification\IManager;
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

	public function dataRegister() {
		return [
			[false, true],
			[true, false],
		];
	}

	/**
	 * @dataProvider dataRegister
	 * @param bool $isCLI
	 * @param bool $register
	 */
	public function testRegister($isCLI, $register) {
		/** @var Application|\PHPUnit_Framework_MockObject_MockObject $app */
		$app = $this->getMockBuilder(Application::class)
			->disableOriginalConstructor()
			->setMethods([
				'registerScripts',
				'registerNotificationNotifier',
			])
			->getMock();

		if ($register) {
			$app->expects($this->once())
				->method('registerScripts');
			$app->expects($this->once())
				->method('registerNotificationNotifier');
		} else {
			$app->expects($this->never())
				->method('registerScripts');
			$app->expects($this->never())
				->method('registerNotificationNotifier');
		}

		$this->invokePrivate($app, 'isCLI', [$isCLI]);
		$app->register();
	}

	public function testRegisterNotifier() {
		$app = new Application();

		$manager = $this->createMock(IManager::class);
		$manager->expects($this->once())
			->method('registerNotifierService')
			->with(Notifier::class);

		$this->overwriteService(IManager::class, $manager);
		$this->invokePrivate($app, 'registerNotificationNotifier');
	}
}
