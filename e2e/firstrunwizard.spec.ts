/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { expect, test } from '@playwright/test'
import { createRandomUser, deleteUser, login, setUserPreference } from './support/utils.ts'

test.describe('First Run Wizard', () => {
	test('opens automatically on first login', async ({ page }) => {
		const user = await createRandomUser()

		try {
			await login(page, user.userId, user.password)

			// The wizard is injected by first-run.ts and opened automatically
			const wizard = page.locator('.first-run-wizard')
			await expect(wizard).toBeVisible()

			// For a brand-new user the intro animation (video) is shown first
			await expect(wizard.locator('video')).toBeVisible()
		} finally {
			await deleteUser(user.userId)
		}
	})

	test('opens when a new major version was shipped', async ({ page }) => {
		const user = await createRandomUser()

		try {
			// Simulate a user who last saw wizard version 2.0.0.
			// The stored version is greater than "1" (so changelogOnly = true)
			// but less than the current CHANGELOG_VERSION (33.0.0),
			// so the wizard is injected and opened again.
			await setUserPreference(user.userId, 'firstrunwizard', 'show', '2.0.0')

			await login(page, user.userId, user.password)

			const wizard = page.locator('.first-run-wizard')
			await expect(wizard).toBeVisible()

			// The intro animation is always shown first; skip it to advance
			// directly to the "What's new" page (changelog-only mode).
			const skipButton = wizard.getByRole('button', { name: 'Skip' })
			await expect(skipButton).toBeVisible({ timeout: 5_000 })
			await skipButton.click()

			// In changelog-only mode the wizard advances directly to the
			// "What's new" page after the intro animation.
			await expect(wizard).toContainText('New in Nextcloud Hub')
		} finally {
			await deleteUser(user.userId)
		}
	})

	test('"About & What\'s new" menu entry reopens the wizard', async ({ page }) => {
		const user = await createRandomUser()

		try {
			await login(page, user.userId, user.password)

			// Close the first-run wizard that opens automatically on first login
			const wizard = page.locator('.first-run-wizard')
			await expect(wizard).toBeVisible()

			// Skip the intro animation as soon as the Skip button appears (~2s)
			const skipButton = wizard.getByRole('button', { name: 'Skip' })
			await expect(skipButton).toBeVisible({ timeout: 5_000 })
			await skipButton.click()

			// Close the slideshow
			const closeButton = wizard.getByRole('button', { name: 'Close' })
			await expect(closeButton).toBeVisible()
			await closeButton.click()
			await expect(wizard).not.toBeVisible()

			// Open the user settings menu to find the "About & What's new" entry
			const userMenu = page.locator('[aria-controls="header-menu-user-menu"]')
			await userMenu.click()

			// Use the link role to avoid strict mode violation from the duplicate ID
			// that Nextcloud renders on both the <li> and the inner <a> element
			const aboutEntry = page.getByRole('link', { name: "About & What's new" })
			await aboutEntry.click()

			// The wizard should open again via the app-menu.ts handler
			await expect(wizard).toBeVisible()
		} finally {
			await deleteUser(user.userId)
		}
	})

	test('can be navigated and closed', async ({ page }) => {
		const user = await createRandomUser()

		try {
			await login(page, user.userId, user.password)

			const wizard = page.locator('.first-run-wizard')
			await expect(wizard).toBeVisible()

			// Skip the intro animation as soon as the Skip button appears (~2s)
			const skipButton = wizard.getByRole('button', { name: 'Skip' })
			await expect(skipButton).toBeVisible({ timeout: 5_000 })
			await skipButton.click()

			// The slideshow is now shown with the Close button always visible.
			const closeButton = wizard.getByRole('button', { name: 'Close' })
			await expect(closeButton).toBeVisible()

			// Navigate through all pages by repeatedly clicking the last button
			// (always the forward/primary navigation button) until the final
			// page's "Get started!" button is reached.
			const getStartedButton = wizard.getByRole('button', { name: 'Get started!' })

			while (!(await getStartedButton.isVisible())) {
				// The last button in DOM order is always the last navigation button
				// in the button_wrapper (after the Close and Back buttons)
				await wizard.getByRole('button').last().click()
			}

			// Clicking "Get started!" on the last page closes the wizard
			await getStartedButton.click()

			// The wizard should no longer be visible after closing
			await expect(wizard).not.toBeVisible()
		} finally {
			await deleteUser(user.userId)
		}
	})
})
