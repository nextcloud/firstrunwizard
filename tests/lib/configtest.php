<?php

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