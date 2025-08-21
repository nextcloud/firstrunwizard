<?php

/**
 * SPDX-FileCopyrightText: 2016 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FirstRunWizard\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IConfig;
use OCP\IRequest;

class WizardController extends Controller {

	public function __construct(
		string $appName,
		IRequest $request,
		private ?string $userId,
		private IConfig $config,
	) {
		parent::__construct($appName, $request);
	}

	/**
	 * @NoAdminRequired
	 * @return DataResponse
	 */
	public function disable() {
		// get the current Nextcloud version
		$version = \OCP\Util::getVersion();
		// we only use major.minor.patch
		array_splice($version, 3);
		// Set "show" to current version to only show on update
		$this->config->setUserValue($this->userId, 'firstrunwizard', 'show', implode('.', $version));
		return new DataResponse();
	}
}
