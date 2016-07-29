<?php
/**

 *
 * @author Georg Ehrke <georg@owncloud.com>
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
namespace OCA\FirstRunWizard\Tests;

use OCA\FirstRunWizard\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider enableDisableData
	 */
	public function testEnable($isUserAvailable) {
		$config = $this->getMockBuilder('\OCP\IConfig')
			->disableOriginalConstructor()->getMock();
		$userSession = $this->getMockBuilder('\OCP\IUserSession')
			->disableOriginalConstructor()->getMock();
		$user = $this->getMockBuilder('\OCP\IUser')
			->disableOriginalConstructor()->getMock();

		if ($isUserAvailable) {
			$user->expects($this->once())
				->method('getUID')
				->will($this->returnValue('user123'));

			$userSession->expects($this->once())
				->method('getUser')
				->will($this->returnValue($user));

			$config->expects($this->once())
				->method('setUserValue')
				->with('user123', 'firstrunwizard', 'show', 1);

			$c = new Config($config, $userSession);
			$c->enable();
		} else {
			$userSession->expects($this->once())
				->method('getUser')
				->will($this->returnValue(null));
			$user->expects($this->never())
				->method('getUID');
			$config->expects($this->never())
				->method('setUserValue');

			$c = new Config($config, $userSession);
			$c->enable();
		}
	}

	/**
	 * @dataProvider enableDisableData
	 */
	public function testDisable($isUserAvailable) {
		$config = $this->getMockBuilder('\OCP\IConfig')
			->disableOriginalConstructor()->getMock();
		$userSession = $this->getMockBuilder('\OCP\IUserSession')
			->disableOriginalConstructor()->getMock();
		$user = $this->getMockBuilder('\OCP\IUser')
			->disableOriginalConstructor()->getMock();

		if ($isUserAvailable) {
			$user->expects($this->once())
				->method('getUID')
				->will($this->returnValue('user123'));

			$userSession->expects($this->once())
				->method('getUser')
				->will($this->returnValue($user));

			$config->expects($this->once())
				->method('setUserValue')
				->with('user123', 'firstrunwizard', 'show', 0);

			$c = new Config($config, $userSession);
			$c->disable();
		} else {
			$userSession->expects($this->once())
				->method('getUser')
				->will($this->returnValue(null));
			$user->expects($this->never())
				->method('getUID');
			$config->expects($this->never())
				->method('setUserValue');

			$c = new Config($config, $userSession);
			$c->disable();
		}
	}

	public function enableDisableData() {
		return [
			[true],
			[false],
		];
	}

	/**
	 * @dataProvider isEnabledData
	 */
	public function testIsEnabled($isEnabled) {
		$config = $this->getMockBuilder('\OCP\IConfig')
			->disableOriginalConstructor()->getMock();
		$userSession = $this->getMockBuilder('\OCP\IUserSession')
			->disableOriginalConstructor()->getMock();
		$user = $this->getMockBuilder('\OCP\IUser')
			->disableOriginalConstructor()->getMock();

		if ($isEnabled === true) {
			$user->expects($this->once())
				->method('getUID')
				->will($this->returnValue('user123'));

			$userSession->expects($this->once())
				->method('getUser')
				->will($this->returnValue($user));

			$config->expects($this->once())
				->method('getUserValue')
				->with('user123', 'firstrunwizard', 'show', 1)
				->will($this->returnValue(1));

			$c = new Config($config, $userSession);
			$this->assertEquals(true, $c->isEnabled());
		} elseif ($isEnabled === false) {
			$user->expects($this->once())
				->method('getUID')
				->will($this->returnValue('user123'));

			$userSession->expects($this->once())
				->method('getUser')
				->will($this->returnValue($user));

			$config->expects($this->once())
				->method('getUserValue')
				->with('user123', 'firstrunwizard', 'show', 1)
				->will($this->returnValue(0));

			$c = new Config($config, $userSession);
			$this->assertEquals(false, $c->isEnabled());
		} elseif ($isEnabled === null) {
			$userSession->expects($this->once())
				->method('getUser')
				->will($this->returnValue(null));
			$user->expects($this->never())
				->method('getUID');
			$config->expects($this->never())
				->method('getUserValue');

			$c = new Config($config, $userSession);
			$this->assertEquals(false, $c->isEnabled());
		}
	}

	public function isEnabledData() {
		return [
			[true],
			[false],
			[null],
		];
	}
}