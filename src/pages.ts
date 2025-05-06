/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import type { Component } from 'vue'

import { translate as t } from '@nextcloud/l10n'
import AboutNextcloudPage from './components/pages/AboutNextcloud.vue'
import DeviceIntegrationPage from './components/pages/DeviceIntegration.vue'
import HubReleasePage from './components/pages/HubRelease.vue'
import KeyNotesPage from './components/pages/KeyNotes.vue'
import SharePage from './components/pages/SharePage.vue'
import WhatsNewPage from './components/pages/WhatsNew.vue'
import HubRelease from './hub-release.ts'

interface IPageButton {
	to: string
	label: string
}

export interface IPage {
	id: string
	component: Component
	buttons: IPageButton[]
}

export default [
	{
		id: 'key-aspects',
		component: KeyNotesPage,
		buttons: [
			{
				to: 'hub-release',
				label: t('firstrunwizard', 'What\'s new?'),
			}, {
				to: 'devices',
				label: t('firstrunwizard', 'Nextcloud on all your devices'),
			},
		],
	},

	{
		id: 'devices',
		component: DeviceIntegrationPage,
		buttons: [
			{
				to: 'about',
				label: t('firstrunwizard', 'More about Nextcloud'),
			},
		],
	},

	{
		id: 'about',
		component: AboutNextcloudPage,
		buttons: [
			{
				to: 'hub-release',
				label: t('firstrunwizard', 'Nextcloud Hub {version}', { version: HubRelease.version }),
			},
		],
	},

	{
		id: 'hub-release',
		component: HubReleasePage,
		buttons: [
			{
				to: 'whats-new',
				label: t('firstrunwizard', 'Read more'),
			},
		],
	},

	{
		id: 'whats-new',
		component: WhatsNewPage,
		buttons: [
			{
				to: 'share',
				label: t('firstrunwizard', 'Share on social media'),
			},
		],
	},

	{
		id: 'share',
		component: SharePage,
		buttons: [
			{
				to: 'close',
				label: t('firstrunwizard', 'Get started!'),
			},
		],
	},

] as IPage[]
