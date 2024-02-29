import type { Component } from 'vue'

import { translate as t } from '@nextcloud/l10n'

import AboutNextcloud from './components/pages/AboutNextcloud.vue'
import DeviceIntegration from './components/pages/DeviceIntegration.vue'
import KeyNotes from './components/pages/KeyNotes.vue'

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
		component: KeyNotes,
		buttons: [{
			to: 'devices',
			label: t('firstrunwizard', 'Nextcloud on all your devices'),
		}],
	},

	{
		id: 'devices',
		component: DeviceIntegration,
		buttons: [{
			to: 'about',
			label: t('firstrunwizard', 'More about Nextcloud'),
		}],
	},

	{
		id: 'about',
		component: AboutNextcloud,
		buttons: [{
			to: 'close',
			label: t('firstrunwizard', 'Get started!'),
		}],
	}

] as IPage[]
