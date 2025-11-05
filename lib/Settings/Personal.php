<?php

/**
 * SPDX-FileCopyrightText: 2017 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FirstRunWizard\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Services\IInitialState;
use OCP\Defaults;
use OCP\IConfig;
use OCP\IL10N;
use OCP\IRequest;
use OCP\IURLGenerator;
use OCP\Settings\ISettings;
use Override;

class Personal implements ISettings {

	public function __construct(
		private readonly IConfig $config,
		private readonly IURLGenerator $urlGenerator,
		private readonly Defaults $defaults,
		private readonly IInitialState $initialState,
		private readonly IL10N $l,
		private readonly IRequest $request,
	) {
	}

	#[Override]
	public function getForm(): TemplateResponse {
		$apps = [
			'calendar' => [
				'label' => $this->l->t('Connect your calendar'),
				'link' => $this->urlGenerator->linkToDocs('user-sync-calendars'),
				'image' => $this->urlGenerator->imagePath('core', 'places/calendar.svg'),
			],
			'contacts' => [
				'label' => $this->l->t('Connect your contacts'),
				'link' => $this->urlGenerator->linkToDocs('user-sync-contacts'),
				'image' => $this->urlGenerator->imagePath('core', 'places/contacts.svg'),
			],
			'webdav' => [
				'label' => $this->l->t('Access files via WebDAV'),
				'link' => $this->urlGenerator->linkToDocs('user-webdav'),
				'image' => $this->urlGenerator->imagePath('files', 'folder.svg'),
			],
		];
		if ($this->request->getServerProtocol() === 'https') {
			$apps['mac'] = [
				'label' => $this->l->t('Download macOS/iOS configuration profile'),
				'link' => \OCP\Util::linkToRemote('dav') . 'provisioning/apple-provisioning.mobileconfig',
				'image' => $this->urlGenerator->imagePath('core', 'actions/settings.svg'),
			];
		}

		$this->initialState->provideInitialState('apps', $apps);
		$this->initialState->provideInitialState('links', [
			'clients' => $this->getClientLinks(),
			'appPasswords' => $this->urlGenerator->linkToRoute('settings.PersonalSettings.index', ['section' => 'security']),
		]);

		\OCP\Util::addStyle('firstrunwizard', 'firstrunwizard-style');
		\OCP\Util::addScript('firstrunwizard', 'firstrunwizard-settings', 'settings');
		return new TemplateResponse('firstrunwizard', 'personal-settings');
	}

	#[Override]
	public function getSection(): string {
		return 'sync-clients';
	}

	#[Override]
	public function getPriority(): int {
		return 20;
	}

	private function getClientLinks(): array {
		return [
			'desktop' => [
				'href' => $this->config->getSystemValue('customclient_desktop', $this->defaults->getSyncClientUrl()),
				'name' => $this->l->t('Desktop client'),
				'image' => $this->urlGenerator->imagePath('core', 'desktopapp.svg'),
			],
			'android' => [
				'href' => $this->config->getSystemValue('customclient_android', $this->defaults->getAndroidClientUrl()),
				'name' => $this->l->t('Android app on Google Play Store'),
				'image' => $this->urlGenerator->imagePath('core', 'googleplay.png'),
			],
			'fdroid' => [
				'href' => $this->config->getSystemValue('customclient_fdroid', $this->defaults->getFDroidClientUrl()),
				'name' => $this->l->t('Android app on F-Droid'),
				'image' => $this->urlGenerator->imagePath('core', 'f-droid.svg'),
			],
			'ios' => [
				'href' => $this->config->getSystemValue('customclient_ios', $this->defaults->getiOSClientUrl()),
				'name' => $this->l->t('iOS app'),
				'image' => $this->urlGenerator->imagePath('core', 'appstore.svg'),
			],
		];
	}
}
