/*!
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import {
	configureNextcloud,
	getContainerName,
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

/**
 * Patch the container's run.sh to remove SSL configuration so Apache starts
 * on HTTP only. The Docker image's run.sh enables SSL but does not ship with
 * a certificate, which causes Apache to fail to start. By removing the SSL
 * directives we run on plain HTTP instead.
 *
 * This must be called after startNextcloud() (container is running) but before
 * waitOnNextcloud() (Apache has not started yet), while initnc.sh is still
 * setting up the Nextcloud instance.
 */
function makeHttpOnly() {
	execSync(
		`docker exec ${getContainerName()} `
		+ `sed -i `
		+ `-e '/a2enmod ssl/d' `
		+ `-e '/a2ensite default-ssl/d' `
		+ `-e '/a2enconf ssl-params/d' `
		+ `-e '/apache2ctl configtest/d' `
		+ `/usr/local/bin/run.sh`,
		{ stdio: 'pipe', timeout: 30_000 },
	)
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

// Patch run.sh to disable SSL so Apache starts on plain HTTP
makeHttpOnly()

await waitOnNextcloud(ip)
await configureNextcloud(['firstrunwizard'])

// Idle to keep the process alive until a SIGTERM/SIGINT signal is received
// (sent by Playwright's gracefulShutdown when tests finish)
while (true) {
	await new Promise((resolve) => setTimeout(resolve, 5000))
}
