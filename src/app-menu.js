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

// eslint-disable-next-line import/no-unresolved, n/no-missing-import
import 'vite/modulepreload-polyfill'

/**
 * Handle adding the first-run-wizard as an app menu entry
 */
document.addEventListener('DOMContentLoaded', function() {
	const aboutEntry = document.querySelector('#firstrunwizard_about button')

	const addListener = () => {
		const aboutEntry = document.querySelector('#firstrunwizard_about button')

		aboutEntry.addEventListener('click', async function(event) {
			event.stopPropagation()
			event.preventDefault()
			const focusReturn = document.querySelector('[aria-controls="header-menu-user-menu"]') ?? undefined
			const { open } = await import('./main.js')
			open(focusReturn)
			OC.hideMenus(() => false)
		})
	}

	if (aboutEntry) {
		addListener()
	} else {
		window._nc_event_bus.subscribe('core:user-menu:mounted', addListener)
	}
})
