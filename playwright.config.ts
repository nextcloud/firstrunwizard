/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { defineConfig, devices } from '@playwright/test'

export default defineConfig({
	testDir: './e2e',
	fullyParallel: false,
	/* Fail the build on CI if you accidentally left test.only in the source code. */
	forbidOnly: !!process.env.CI,
	/* Retry on CI only */
	retries: process.env.CI ? 2 : 0,
	/* Opt out of parallel tests */
	workers: 1,
	/* Reporter to use */
	reporter: process.env.CI ? 'github' : 'list',
	use: {
		/* Base URL to use in actions like `await page.goto('/')`. */
		baseURL: process.env.baseURL ?? 'http://localhost:8089',

		/* Collect trace when retrying the failed test. */
		trace: 'on-first-retry',
		screenshot: 'only-on-failure',
		video: 'on-first-retry',
	},
	projects: [
		{
			name: 'chromium',
			use: { ...devices['Desktop Chrome'] },
		},
	],

	webServer: {
		// Starts the Nextcloud docker container
		command: 'npm run start:nextcloud',
		// we use SIGTERM to notify the script to stop the container
		// if it does not respond, we force kill it after 10 seconds
		gracefulShutdown: {
			signal: 'SIGTERM',
			timeout: 10000,
		},
		reuseExistingServer: !process.env.CI,
		stderr: 'pipe',
		stdout: 'pipe',
		url: 'http://127.0.0.1:8089',
		timeout: 5 * 60 * 1000, // max. 5 minutes for creating the container
		wait: {
			// we wait for this line to appear in stdout before considering the server ready
			stdout: /Nextcloud is now ready to use/,
		},
	},
})
