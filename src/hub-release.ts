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
	version: '10',

	/** Link to further information (e.g. blog post) */
	link: 'https://nextcloud.com/blog/nextcloud-hub10/',

	/** Release notes in list format */
	releaseNotes: [
		'🔒 ' + t('firstrunwizard', 'End-to-end encryption in calls and web'),

		'⚡ ' + t('firstrunwizard', 'Performance improvements across all our products'),

		'⚙️ ' + t('firstrunwizard', 'Thousands of tweaks for improved UX and stability'),

		'✨ ' + t('firstrunwizard', 'Your own new personal assistant'),

		'🔄 ' + t('firstrunwizard', 'Seamless file conversions'),

		'👥 ' + t('firstrunwizard', 'Smarter team sharing with Team folders'),

		'💬 ' + t('firstrunwizard', 'Schedule meetings directly in Talk'),

		'📧 ' + t('firstrunwizard', 'Mail you love again: translations, summaries, and mentions'),
	],

	/** Alternative text for the release animation */
	videoAltText: t('firstrunwizard', 'Get to know the new features of Hub {version}', { version: '10' }),

	/** Subject that is used when sharing the post */
	shareSubject: t('firstrunwizard', 'Nextcloud Hub 10 is here – your modular & unified digital workspace! 💫'),
}
