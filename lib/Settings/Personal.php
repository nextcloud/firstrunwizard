<?php
/**
 * SPDX-FileCopyrightText: 2017 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FirstRunWizard\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\Defaults;
use OCP\IConfig;
use OCP\IURLGenerator;
use OCP\Settings\ISettings;

class Personal implements ISettings {

	public function __construct(
		private IConfig $config,
		private IURLGenerator $urlGenerator,
		private Defaults $defaults,
	) {
	}

	/**
	 * @return TemplateResponse returns the instance with all parameters set, ready to be rendered
	 * @since 9.1
	 */
	public function getForm() {
		$url = $this->urlGenerator->getAbsoluteURL('');
		$parameters = [ 'clients' => $this->getClientLinks() ,'url' => $url];
		return new TemplateResponse('firstrunwizard', 'personal-settings', $parameters);
	}

	/**
	 * @return string the section ID, e.g. 'sharing'
	 * @since 9.1
	 */
	public function getSection() {
		return 'sync-clients';
	}

	/**
	 * @return int whether the form should be rather on the top or bottom of
	 * the admin section. The forms are arranged in ascending order of the
	 * priority values. It is required to return a value between 0 and 100.
	 *
	 * E.g.: 70
	 * @since 9.1
	 */
	public function getPriority() {
		return 20;
	}

	/**
	 * returns an array containing links to the various clients
	 *
	 * @return array
	 */
	private function getClientLinks() {
		$clients = [
			'desktop' => $this->config->getSystemValue('customclient_desktop', $this->defaults->getSyncClientUrl()),
			'android' => $this->config->getSystemValue('customclient_android', $this->defaults->getAndroidClientUrl()),
			'fdroid' => $this->config->getSystemValue('customclient_fdroid', $this->defaults->getFDroidClientUrl()),
			'ios' => $this->config->getSystemValue('customclient_ios', $this->defaults->getiOSClientUrl())
		];
		return $clients;
	}
}
