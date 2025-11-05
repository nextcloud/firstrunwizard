<?php

/**
 * SPDX-FileCopyrightText: 2016 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FirstRunWizard\Tests\AppInfo;

use Test\TestCase;

/**
 * Class RoutesTest
 *
 * @package OCA\FirstRunWizard\Tests\AppInfo
 */
class RoutesTest extends TestCase {
	public function testRoutes(): void {
		$routes = include(__DIR__ . '/../../appinfo/routes.php');
		$this->assertIsArray($routes);
		$this->assertCount(1, $routes);
		$this->assertArrayHasKey('routes', $routes);
		$this->assertIsArray($routes['routes']);
		$this->assertSame([
			['name' => 'Wizard#disable', 'url' => '/wizard', 'verb' => 'DELETE'],
		], $routes['routes']);
	}
}
