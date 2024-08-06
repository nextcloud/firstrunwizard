/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

// eslint-disable-next-line import/no-unresolved, n/no-missing-import
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
			const { open } = await import('./main.js')
			open(focusReturn)
			OC.hideMenus(() => false)
		})
	}

	if (aboutEntry()) {
		addListener()
	} else {
		window._nc_event_bus.subscribe('core:user-menu:mounted', addListener)
	}
})
