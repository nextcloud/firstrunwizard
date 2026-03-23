/*!
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import {
	configureNextcloud,
	startNextcloud,
	stopNextcloud,
	waitOnNextcloud,
} from '@nextcloud/e2e-test-server/docker'
import { readFileSync } from 'fs'
import { execSync } from 'node:child_process'

async function start() {
	const appinfo = readFileSync('appinfo/info.xml').toString()
	const maxVersion = appinfo.match(
		/<nextcloud min-version="\d+" max-version="(\d\d+)" \/>/,
	)?.[1]

	let branch = 'master'
	if (maxVersion) {
		try {
			const refs = execSync('git ls-remote --refs').toString('utf-8')
			branch = refs.includes(`refs/heads/stable${maxVersion}`)
				? `stable${maxVersion}`
				: branch
		} catch {
			// If git command fails, fall back to 'master'
		}
	}

	return await startNextcloud(branch, true, {
		exposePort: 8089,
	})
}

async function stop() {
	process.stderr.write('Stopping Nextcloud server…\n')
	await stopNextcloud()
	process.exit(0)
}

process.on('SIGTERM', stop)
process.on('SIGINT', stop)

// Start the Nextcloud docker container
const ip = await start()
await waitOnNextcloud(ip)
await configureNextcloud(['firstrunwizard'])

// Idle to keep the process alive until a SIGTERM/SIGINT signal is received
// (sent by Playwright's gracefulShutdown when tests finish)
while (true) {
	await new Promise((resolve) => setTimeout(resolve, 5000))
}
