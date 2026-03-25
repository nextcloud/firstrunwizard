/**
 * SPDX-FileCopyrightText: 2026 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { runOcc } from '@nextcloud/e2e-test-server/docker'

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
