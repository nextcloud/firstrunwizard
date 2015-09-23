<?php

/**
 * ownCloud - firstrunwizard App
 *
 * @author Frank Karlitschek
 * @copyright 2012 Frank Karlitschek frank@owncloud.org
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

use OCP\IConfig;
use OCP\IUserSession;

class Config {

	protected $config;

	protected $userSession;

	/**
	 * @param IConfig $config
	 * @param IUserSession $userSession
	 */
	public function __construct(IConfig $config, IUserSession $userSession) {
		$this->config = $config;
		$this->userSession = $userSession;
	}

	/**
	* @brief Disable the FirstRunWizard
	*/
	public function enable() {
		$user = $this->userSession->getUser();
		if ($user) {
			$this->config->setUserValue($user->getUID(), 'firstrunwizard', 'show', 1);
		}
	}

	/**
	* @brief Enable the FirstRunWizard
	*/
	public function disable() {
		$user = $this->userSession->getUser();
		if ($user) {
			$this->config->setUserValue($user->getUID(), 'firstrunwizard', 'show', 0);
		}
	}

	/**
	* @brief Check if the FirstRunWizard is enabled or not
	* @return bool
	*/
	public function isEnabled() {
		$user = $this->userSession->getUser();
		if ($user) {
			$conf = $this->config->getUserValue($user->getUID(), 'firstrunwizard', 'show', 1);
			return (intval($conf) === 1);
		} else {
			return false;
		}
	}
}
