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
use OCP\IGroupManager;
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
	private $groupManager;

	protected function setUp(): void {
		parent::setUp();
		$this->config = $this->createMock(IConfig::class);
		$this->groupManager = $this->createMock(IGroupManager::class);
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
			$user,
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

	public function dataShowAdmin(): array {
		return [
			'app store enabled' => [true, 4],
			'app store disabled' => [false, 3]
		];
	}
}
