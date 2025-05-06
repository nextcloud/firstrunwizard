/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { subscribe } from '@nextcloud/event-bus'

import 'vite/modulepreload-polyfill'

/**
 * Handle adding the first-run-wizard as an app menu entry
 */
document.addEventListener('DOMContentLoaded', function() {
	const aboutEntry = () => document.querySelector('#firstrunwizard_about')

	const addListener = () => {
		aboutEntry().addEventListener('click', async function(event) {
			event.stopPropagation()
			event.preventDefault()
			const focusReturn = document.querySelector('[aria-controls="header-menu-user-menu"]') ?? undefined
			const { open } = await import('./main.ts')
			open(focusReturn)
			OC.hideMenus(() => false)
		})
	}

	if (aboutEntry()) {
		addListener()
	} else {
		subscribe('core:user-menu:mounted', addListener)
	}
})
