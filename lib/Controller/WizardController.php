<?php
/**
 * @copyright Copyright (c) 2016 Joas Schilling <coding@schilljs.com>
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

namespace OCA\FirstRunWizard\Controller;


use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\Defaults;
use OCP\IConfig;
use OCP\IRequest;

class WizardController extends Controller  {

	/** @var IConfig */
	protected $config;

	/** @var string */
	protected $userId;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param IConfig $config
	 * @param string $userId
	 */
	public function __construct($appName, IRequest $request, IConfig $config, $userId) {
		parent::__construct($appName, $request);

		$this->config = $config;
		$this->userId = $userId;
	}

	/**
	 * @NoAdminRequired
	 * @return DataResponse
	 */
	public function disable() {
		$this->config->setUserValue($this->userId, 'firstrunwizard', 'show', 0);
		return new DataResponse();
	}

	/**
	 * @NoAdminRequired
	 * @return TemplateResponse
	 */
	public function show() {
		/** @var Defaults $theming */
		$theming = \OC::$server->query(Defaults::class);
		return new TemplateResponse('firstrunwizard', 'wizard', [
			'desktop'      => $this->config->getSystemValue('customclient_desktop', $theming->getSyncClientUrl()),
			'android'      => $this->config->getSystemValue('customclient_android', $theming->getAndroidClientUrl()),
			'ios'          => $this->config->getSystemValue('customclient_ios', $theming->getiOSClientUrl()),
		], '');
	}
}
