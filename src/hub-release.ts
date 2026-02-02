/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { t } from '@nextcloud/l10n'

/* How to do a new release?
 * 1. Update the `version` to the current HUB release
 * 2. Update the `link` for further information
 * 3. Add release notes, each entry is a new point.
 * 4. Update the alt text for the animation if needed.
 */
export default {
	/** The HUB release version */
	version: '26 Winter',

	/** Link to further information (e.g. blog post) */
	link: 'https://nextcloud.com/blog/nextcloud-hub26-winter/',

	/** Release notes in list format */
	releaseNotes: [
		'🌐 ' + t('firstrunwizard', 'Growing sovereignty: new federation features, improved data export and import'),
		'💬 ' + t('firstrunwizard', 'Nextcloud Talk: live translations, pinned messages, scheduling'),
		'🔎 ' + t('firstrunwizard', 'Office document comparison'),
		'🧑‍🎨 ' + t('firstrunwizard', 'Whiteboard: comments, reactions, timers'),
		'✨ ' + t('firstrunwizard', 'Nextcloud Assistant performance upgrade and AI labeling'),
		'🔐 ' + t('firstrunwizard', 'Powerful E2EE in the web interface'),
		'💪 ' + t('firstrunwizard', 'Speed-up with ADA engine'),
		t('firstrunwizard', '… and many more improvements in all apps!'),
		t('firstrunwizard', 'Experience the brand new Nextcloud Hub!'),
	],

	/** Alternative text for the release animation */
	videoAltText: t('firstrunwizard', 'Get to know the new features of Hub {version}', { version: '26 Winter' }),

	/** Subject that is used when sharing the post */
	shareSubject: t('firstrunwizard', 'Time to own your collaboration: Meet Nextcloud Hub 26 Winter! 🚀'),
}
