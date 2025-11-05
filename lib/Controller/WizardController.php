<?php

/**
 * SPDX-FileCopyrightText: 2016 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FirstRunWizard\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\DataResponse;
use OCP\IConfig;
use OCP\IRequest;
use OCP\ServerVersion;

class WizardController extends Controller {

	public function __construct(
		string $appName,
		IRequest $request,
		private readonly ?string $userId,
		private readonly IConfig $config,
		private readonly ServerVersion $serverVersion,
	) {
		parent::__construct($appName, $request);
	}

	#[NoAdminRequired]
	public function disable(): DataResponse {
		assert($this->userId !== null);

		// get the current Nextcloud version
		$version = $this->serverVersion->getVersion();
		// we only use major.minor.patch
		array_splice($version, 3);
		/** @var list<int> $version */
		// Set "show" to current version to only show on update
		$this->config->setUserValue($this->userId, 'firstrunwizard', 'show', implode('.', $version));
		return new DataResponse();
	}
}
