/**
 * SPDX-FileCopyrightText: 2016 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: CC0-1.0
 */

import { createAppConfig } from '@nextcloud/vite-config'
import { join } from 'node:path'

export default createAppConfig({
	activate: join(__dirname, 'src', 'first-run.js'),
	about: join(__dirname, 'src', 'app-menu.js'),
	settings: join(__dirname, 'src', 'personal-settings.ts'),
}, {
	extractLicenseInformation: {
		includeSourceMaps: true,
		overwriteLicenses: {
			'@nextcloud/axios': 'GPL-3.0-or-later',
		},
	},
	thirdPartyLicense: false,
	config: {
		build: {
			// Just one CSS files for now
			cssCodeSplit: false,
		},
	},
})
