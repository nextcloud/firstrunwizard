/**
 * @copyright Copyright (c) 2024 Ferdinand Thiessen <opensource@fthiessen.de>
 *
 * @author Ferdinand Thiessen <opensource@fthiessen.de>
 *
 * @license AGPL-3.0-or-later
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
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

import type { Component } from 'vue'

import { translate as t } from '@nextcloud/l10n'

import AboutNextcloudPage from './components/pages/AboutNextcloud.vue'
import DeviceIntegrationPage from './components/pages/DeviceIntegration.vue'
import HubReleasePage from './components/pages/HubRelease.vue'
import KeyNotesPage from './components/pages/KeyNotes.vue'
import SharePage from './components/pages/SharePage.vue'
import WhatsNewPage from './components/pages/WhatsNew.vue'

import HubRelease from './hub-release'

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
		buttons: [{
			to: 'hub-release',
			label: t('firstrunwizard', 'What\'s new?'),
		}, {
			to: 'devices',
			label: t('firstrunwizard', 'Nextcloud on all your devices'),
		}],
	},

	{
		id: 'devices',
		component: DeviceIntegrationPage,
		buttons: [{
			to: 'about',
			label: t('firstrunwizard', 'More about Nextcloud'),
		}],
	},

	{
		id: 'about',
		component: AboutNextcloudPage,
		buttons: [{
			to: 'hub-release',
			label: t('firstrunwizard', 'Nextcloud Hub {version}', { version: HubRelease.version }),
		}],
	},

	{
		id: 'hub-release',
		component: HubReleasePage,
		buttons: [{
			to: 'whats-new',
			label: t('firstrunwizard', 'Read more'),
		}],
	},

	{
		id: 'whats-new',
		component: WhatsNewPage,
		buttons: [{
			to: 'share',
			label: t('firstrunwizard', 'Share on social media'),
		}],
	},

	{
		id: 'share',
		component: SharePage,
		buttons: [{
			to: 'close',
			label: t('firstrunwizard', 'Get started!'),
		}],
	},

] as IPage[]
