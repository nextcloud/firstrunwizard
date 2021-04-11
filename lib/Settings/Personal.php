<?php
/**
 * @copyright Copyright (c) 2017 Arthur Schiwon <blizzz@arthur-schiwon.de>
 *
 * @author Arthur Schiwon <blizzz@arthur-schiwon.de>
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

namespace OCA\FirstRunWizard\Settings;


use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\Settings\ISettings;
use OCP\IURLGenerator;

class Personal implements ISettings {

	/** @var IConfig */
	private $config;
	/** @var \OC_Defaults */
	private $defaults;

	public function __construct(IConfig $config, IURLGenerator $urlGenerator, \OC_Defaults $defaults) {
		$this->config = $config;
		$this->urlGenerator = $urlGenerator;
		$this->defaults = $defaults;
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
