/**
 * SPDX-FileCopyrightText: 2026 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { expect } from '@playwright/test'
import { test } from './support/fixtures.ts'

test.describe('Settings page', () => {
	test.beforeEach(async ({ page }) => {
		await page.goto('/index.php/settings/user/sync-clients')
	})

	test('shows the sync clients section', async ({ page }) => {
		// The SettingsClients section heading should be visible
		await expect(
			page.getByRole('heading', { name: 'Get the apps to sync your files' }),
		).toBeVisible()
	})

	test('shows the connected apps section', async ({ page }) => {
		// The SettingsApps section should be visible
		const heading = page.getByRole('heading', { name: /Connect other apps to/i })
		await expect(heading).toBeVisible()
	})

	test('shows the server address section', async ({ page }) => {
		// The SettingsServer section should be visible
		await expect(
			page.getByRole('heading', { name: 'Server address' }),
		).toBeVisible()
	})
})
