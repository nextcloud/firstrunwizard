/**
 * SPDX-FileCopyrightText: 2026 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { runOcc } from '@nextcloud/e2e-test-server/docker'
import { createRandomUser } from '@nextcloud/e2e-test-server/playwright'
import type { User } from '@nextcloud/e2e-test-server'
import { test as baseTest } from '@playwright/test'

export type { User }

/**
 * Extended test fixture that provides a logged-in random user for each test.
 * The user is automatically created, authenticated via the login form,
 * and deleted after the test.
 */
export const test = baseTest.extend<{ user: User }>({
	user: async ({ page }, use) => {
		const user = await createRandomUser()

		// Log in via the login form so session cookies are set in the browser page
		await page.goto('/login')
		await page.locator('#user').fill(user.userId)
		await page.locator('#password').fill(user.password)
		await page.locator('[type=submit]').click()
		// Wait for the redirect to an app page AND for the page to fully load,
		// ensuring the session is fully established before the test body runs.
		await page.waitForURL('**/apps/**')
		await page.waitForLoadState('networkidle')

		await use(user)

		await runOcc(['user:delete', user.userId])
	},
})
