<?php

/**
 * ownCloud - firstrunwizard App
 *
 * @author Georg Ehrke
 * @copyright 2015 Georg Ehrke georg@ownCloud.com
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
namespace OCA\FirstRunWizard;

use OCP\App\IAppManager;
use OCP\Defaults;
use OCP\IConfig;

class Util {

	protected $appManager;

	protected $config;

	protected $defaults;

	/**
	 * @param IAppManager $appManager
	 * @param IConfig $config
	 * @param Defaults $defaults
	 */
	public function __construct(IAppManager $appManager, IConfig $config, Defaults $defaults) {
		$this->appManager = $appManager;
		$this->config = $config;
		$this->defaults = $defaults;
	}

	/**
	 * mimic \OC_Util::getEditionString()
	 * @return string
	 */
	public function getEdition() {
		if ($this->appManager->isEnabledForUser('enterprise_key')) {
			return 'Enterprise';
		}
		return '';
	}

	/**
	 * @return array
	 */
	public function getSyncClientUrls() {
		return array(
			'desktop' => $this->config->getSystemValue('customclient_desktop', $this->defaults->getSyncClientUrl()),
			'android' => $this->config->getSystemValue('customclient_android', $this->defaults->getAndroidClientUrl()),
			'ios'     => $this->config->getSystemValue('customclient_ios', $this->defaults->getiOSClientUrl())
		);
	}
}