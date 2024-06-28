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

use Test\TestCase;

/**
 * Class RoutesTest
 *
 * @package OCA\FirstRunWizard\Tests\AppInfo
 */
class RoutesTest extends TestCase {
	public function testRoutes() {
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
