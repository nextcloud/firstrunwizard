/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */
import { translate as t } from '@nextcloud/l10n'

/* How to do a new release?
 * 1. Update the `version` to the current HUB release
 * 2. Update the `link` for further information
 * 3. Add release notes, each entry is a new point.
 * 4. Update the alt text for the animation if needed.
 */
export default {
	/** The HUB release version */
	version: '9',

	/** Link to further information (e.g. blog post) */
	link: 'https://nextcloud.com/blog/nextcloud-hub9/',

	/** Release notes in list format */
	releaseNotes: [
		'🌐 ' + t('firstrunwizard', 'Federated collaboration: file sharing, messaging, calls'),

		'🗂️ ' + t('firstrunwizard', 'Nextcloud Project'),

		'📌 ' + t('firstrunwizard', 'Nextcloud Whiteboard'),

		'✳️ ' + t('firstrunwizard', 'Workflow Engine'),

		'💌 ' + t('firstrunwizard', 'Safer and swifter mail'),

		'🔗 ' + t('firstrunwizard', 'Public Collectives sharing, previews and QR-codes'),

		'🎨 ' + t('firstrunwizard', 'Office and PDF templates'),

		'💬 ' + t('firstrunwizard', 'Chat mode for Nextcloud Assistant'),
	],

	/** Alternative text for the release animation */
	videoAltText: t('firstrunwizard', 'Get to know the new features of Hub 9'),

	/** Subject that is used when sharing the post */
	shareSubject: t('firstrunwizard', 'Nextcloud Hub {version} release', { version: '9' }),
}
