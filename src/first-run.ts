/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */
import 'vite/modulepreload-polyfill'

/**
 * Handling opening the first-run-wizard the first time
 *
 * Dynamically load the first-run-wizard and open it when loaded
 */
document.addEventListener('DOMContentLoaded', async function() {
	const wizard = await import('./main.ts')
	wizard.open()
})
