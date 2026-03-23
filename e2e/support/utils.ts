/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { createRandomUser as createRandomUserNC } from '@nextcloud/e2e-test-server/playwright'
import { runOcc } from '@nextcloud/e2e-test-server/docker'
import type { User } from '@nextcloud/e2e-test-server'
import type { Page } from '@playwright/test'

export type { User }

/**
 * Create a new random Nextcloud user via occ.
 *
 * @return The newly created User object (userId + password)
 */
export async function createRandomUser(): Promise<User> {
	return createRandomUserNC()
}

/**
 * Delete a Nextcloud user via occ.
 *
 * @param userId - Username to delete
 */
export async function deleteUser(userId: string): Promise<void> {
	await runOcc(['user:delete', userId])
}

/**
 * Set a user preference via occ user:setting.
 *
 * @param userId - Username
 * @param app - App ID
 * @param key - Preference key
 * @param value - Preference value to set
 */
export async function setUserPreference(
	userId: string,
	app: string,
	key: string,
	value: string,
): Promise<void> {
	await runOcc(['user:setting', userId, app, key, value])
}

/**
 * Log in to Nextcloud using the given credentials via the login form.
 *
 * @param page - Playwright page object
 * @param user - Username
 * @param password - Password
 */
export async function login(page: Page, user: string, password: string): Promise<void> {
	await page.goto('/login')
	await page.locator('#user').fill(user)
	await page.locator('#password').fill(password)
	await page.locator('[type=submit]').click()
	await page.waitForURL('**/apps/**')
}
