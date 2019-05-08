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
use OCP\AppFramework\Http\JSONResponse;
use OCP\Defaults;
use OCP\IConfig;
use OCP\IGroupManager;
use OCP\IRequest;

class WizardController extends Controller {

	/** @var IConfig */
	protected $config;

	/** @var string */
	protected $userId;

	/** @var Defaults */
	protected $theming;

	/** @var IGroupManager */
	protected $groupManager;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param IConfig $config
	 * @param string $userId
	 * @param Defaults $theming
	 */
	public function __construct($appName, IRequest $request, IConfig $config, $userId, Defaults $theming, IGroupManager $groupManager) {
		parent::__construct($appName, $request);

		$this->config = $config;
		$this->userId = $userId;
		$this->theming = $theming;
		$this->groupManager = $groupManager;
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
	 * @return JsonResponse
	 */
	public function show() {
		$data = [
			'desktop'      => $this->config->getSystemValue('customclient_desktop', $this->theming->getSyncClientUrl()),
			'android'      => $this->config->getSystemValue('customclient_android', $this->theming->getAndroidClientUrl()),
			'ios'          => $this->config->getSystemValue('customclient_ios', $this->theming->getiOSClientUrl()),
			'appStore'     => $this->config->getSystemValue('appstoreenabled', true),
			'useTLS'       => $this->request->getServerProtocol() === 'https',
			'macOSProfile' => \OCP\Util::linkToRemote('dav') . 'provisioning/apple-provisioning.mobileconfig',
		];

		$slides = [
			$this->staticSlide('page.intro', $data),
			$this->staticSlide('page.values', $data)
		];
		if ($this->groupManager->isAdmin($this->userId)) {
			$slides[] = $this->staticSlide('page.apps', $data);
		}
		$slides[] = $this->staticSlide('page.clients', $data);
		$slides[] = $this->staticSlide('page.final', $data);

		return new JSONResponse($slides);
	}

	public function staticSlide($name, $params) {
		$template = new \OCP\Template($this->appName, $name, false);

		foreach($params as $key => $value){
			$template->assign($key, $value);
		}

		return [
			'type' => 'inline',
			'content' => $template->fetchPage($params)
		];
	}
}
