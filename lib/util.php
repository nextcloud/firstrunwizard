<?php
/**
 * @copyright 2015 Georg Ehrke <georg@owncloud.com>
 *
 * @author Bjoern Schiessle <bjoern@schiessle.org>
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

	/**
	 * @return string
	 */
	public function getSlogan() {
		return $this->defaults->getSlogan();
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->defaults->getBaseUrl();
	}

	/**
	 * @return string
	 */
	public function getDocumentationUrl() {
		return $this->defaults->getDocBaseUrl();
	}
}
