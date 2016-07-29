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

use OCA\FirstRunWizard\Util;

class UtilTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider getEditionData
	 */
	public function testGetEdition($isEnterpriseKeyEnabled, $string) {
		$appManager = $this->getMockBuilder('\OCP\App\IAppManager')
			->disableOriginalConstructor()->getMock();
		$config = $this->getMockBuilder('\OCP\IConfig')
			->disableOriginalConstructor()->getMock();
		$defaults = $this->getMockBuilder('\OCP\Defaults')
			->disableOriginalConstructor()->getMock();

		$appManager->expects($this->once())
			->method('isEnabledForUser')
			->with('enterprise_key')
			->will($this->returnValue($isEnterpriseKeyEnabled));

		$util = new Util($appManager, $config, $defaults);
		$this->assertEquals($string, $util->getEdition());
	}

	public function getEditionData() {
		return [
			[true, 'Enterprise'],
			[false, ''],
		];
	}

	/**
	 * @dataProvider getSyncClientUrlsData
	 */
	public function testGetSyncClientUrls($configValues, $defaultValues) {
		$appManager = $this->getMockBuilder('\OCP\App\IAppManager')
			->disableOriginalConstructor()->getMock();
		$config = $this->getMockBuilder('\OCP\IConfig')
			->disableOriginalConstructor()->getMock();
		$defaults = $this->getMockBuilder('\OCP\Defaults')
			->disableOriginalConstructor()->getMock();

		$defaults->expects($this->once())
			->method('getSyncClientUrl')
			->will($this->returnValue($defaultValues[0]));
		$defaults->expects($this->once())
			->method('getAndroidClientUrl')
			->will($this->returnValue($defaultValues[1]));
		$defaults->expects($this->once())
			->method('getiOSClientUrl')
			->will($this->returnValue($defaultValues[2]));

		$config->expects($this->at(0))
			->method('getSystemValue')
			->with('customclient_desktop', $defaultValues[0])
			->will($this->returnValue($configValues[0]));
		$config->expects($this->at(1))
			->method('getSystemValue')
			->with('customclient_android', $defaultValues[1])
			->will($this->returnValue($configValues[1]));
		$config->expects($this->at(2))
			->method('getSystemValue')
			->with('customclient_ios', $defaultValues[2])
			->will($this->returnValue($configValues[2]));

		$util = new Util($appManager, $config, $defaults);
		$this->assertEquals([
			'desktop' => $configValues[0],
			'android' => $configValues[1],
			'ios' => $configValues[2],
		], $util->getSyncClientUrls());
	}

	public function getSyncClientUrlsData() {
		return [
			[
				['a', 'b', 'c'],
				['d', 'e', 'f'],
			],
		];
	}
}