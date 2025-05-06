/**
 * SPDX-FileCopyrightText: 2020 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { createApp } from 'vue'
import FirstRunWizard from './views/App.vue'

let vm: InstanceType<typeof FirstRunWizard>
/**
 * Open the wizard and mount if needed.
 *
 * @param focusReturn - Where to return focus after the wizard is closed
 */
export function open(focusReturn?: HTMLElement | SVGElement | string) {
	if (vm === undefined) {
		const el = document.createElement('div')
		el.id = 'firstrunwizard'
		document.querySelector('body')!.appendChild(el)
		vm = createApp(FirstRunWizard)
			.mount(el) as InstanceType<typeof FirstRunWizard>
	}
	vm.open(focusReturn)
}
