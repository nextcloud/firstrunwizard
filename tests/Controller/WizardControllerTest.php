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

namespace OCA\FirstRunWizard\Tests\Controller;


use OCA\FirstRunWizard\Controller\WizardController;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\IConfig;
use OCP\IRequest;
use Test\TestCase;

/**
 * Class WizardControllerTest
 *
 * @package OCA\FirstRunWizard\Tests\Controller
 * @group DB
 */
class WizardControllerTest extends TestCase {
	/** @var IConfig|\PHPUnit_Framework_MockObject_MockObject */
	protected $config;

	protected function setUp() {
		parent::setUp();
		$this->config = $this->createMock(IConfig::class);
	}

	/**
	 * @param string $user
	 * @return WizardController
	 */
	protected function getController($user = 'test') {
		return new WizardController(
			'firstrunwizard',
			$this->createMock(IRequest::class),
			$this->config,
			$user
		);
	}

	public function dataDisable() {
		return [
			['test1'],
			['test2'],
		];
	}

	/**
	 * @dataProvider dataDisable
	 * @param string $user
	 */
	public function testDisable($user) {
		$controller = $this->getController($user);

		$this->config->expects($this->once())
			->method('setUserValue')
			->with($user, 'firstrunwizard', 'show', 0);

		$response = $controller->disable();

		$this->assertInstanceOf(DataResponse::class, $response);
		$this->assertSame(Http::STATUS_OK, $response->getStatus());
	}

	public function dataShow() {
		return [
			['desktop1', 'android1', 'ios1'],
			['desktop2', 'android2', 'ios2'],
		];
	}

	/**
	 * @dataProvider dataShow
	 * @param string $desktopUrl
	 * @param string $androidUrl
	 * @param string $iosUrl
	 */
	public function testShow($desktopUrl, $androidUrl, $iosUrl) {
		$controller = $this->getController();

		$this->config->expects($this->exactly(3))
			->method('getSystemValue')
			->willReturnMap([
				['customclient_desktop', 'https://nextcloud.com/install/#install-clients', $desktopUrl],
				['customclient_android', 'https://play.google.com/store/apps/details?id=com.nextcloud.client', $androidUrl],
				['customclient_ios', 'https://geo.itunes.apple.com/us/app/nextcloud/id1125420102?mt=8', $iosUrl],
			]);

		$response = $controller->show();

		$this->assertInstanceOf(Http\TemplateResponse::class, $response);
		$this->assertSame(Http::STATUS_OK, $response->getStatus());
		$this->assertSame([
			'desktop' => $desktopUrl,
			'android' => $androidUrl,
			'ios' => $iosUrl,
		], $response->getParams());
	}
}
