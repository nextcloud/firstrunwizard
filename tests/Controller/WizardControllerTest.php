<?php

/**
 * SPDX-FileCopyrightText: 2016 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FirstRunWizard\Tests\Controller;

use OCA\FirstRunWizard\Controller\WizardController;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\IConfig;
use OCP\IRequest;
use PHPUnit\Framework\MockObject\MockObject;
use Test\TestCase;

/**
 * Class WizardControllerTest
 *
 * @package OCA\FirstRunWizard\Tests\Controller
 */
#[\PHPUnit\Framework\Attributes\Group('DB')]
class WizardControllerTest extends TestCase {

	protected IConfig&MockObject $config;

	protected function setUp(): void {
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
			$user,
			$this->config,
		);
	}

	public static function dataDisable() {
		return [
			['test1'],
			['test2'],
		];
	}

	#[\PHPUnit\Framework\Attributes\DataProvider('dataDisable')]
	public function testDisable(string $user) {
		$controller = $this->getController($user);

		$this->config->expects($this->once())
			->method('setUserValue')
			->with($user, 'firstrunwizard', 'show');

		$response = $controller->disable();

		$this->assertInstanceOf(DataResponse::class, $response);
		$this->assertSame(Http::STATUS_OK, $response->getStatus());
	}
}
