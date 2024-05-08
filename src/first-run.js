/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

// eslint-disable-next-line import/no-unresolved, n/no-missing-import
import 'vite/modulepreload-polyfill'

/**
 * Handling opening the first-run-wizard the first time
 *
 * Dynamically load the first-run-wizard and open it when loaded
 */
document.addEventListener('DOMContentLoaded', async function() {
	const wizard = await import('./main.js')
	wizard.open()
})
