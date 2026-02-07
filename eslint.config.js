/*!
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: CC0-1.0
 */

import { recommended } from '@nextcloud/eslint-config'
import { defineConfig } from 'eslint/config'

export default defineConfig([
	...recommended,

	{
		files: ['**/*.vue'],
		rules: {
			'vue/block-order': ['error', {
				order: ['script', 'template', 'style'],
			}],
		},
	},

	{
		ignores: [
			'js/**',
			'l10n/**',
		],
	},
])
