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
 * The user is automatically created, authenticated via the Nextcloud login
 * form, and deleted after the test.
 *
 * Using `auto: true` ensures every test in files that import this `test`
 * object gets a fresh random-user session without having to explicitly
 * request the `user` fixture.
 */
export const test = baseTest.extend<{ user: User }>({
	user: [async ({ page }, use) => {
		const user = await createRandomUser()

		// Log in via the Nextcloud login form so session cookies are set in
		// the browser page used by the test.
		await page.goto('/index.php/login')
		await page.locator('#user').fill(user.userId)
		await page.locator('#password').fill(user.password)
		await page.locator('[type=submit]').click()
		await page.waitForURL('**/apps/**')

		await use(user)

		await runOcc(['user:delete', user.userId])
	}, { auto: true }],
})
