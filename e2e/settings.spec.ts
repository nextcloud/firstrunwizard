/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { expect, test } from '@playwright/test'
import { createRandomUser, deleteUser, login } from './support/utils.ts'
import type { User } from './support/utils.ts'

test.describe('Settings page', () => {
	let user: User

	test.beforeAll(async () => {
		user = await createRandomUser()
	})

	test.afterAll(async () => {
		await deleteUser(user.userId)
	})

	test.beforeEach(async ({ page }) => {
		await login(page, user.userId, user.password)
		// Navigate to the personal settings page for sync clients
		await page.goto('/settings/user/sync-clients')
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
