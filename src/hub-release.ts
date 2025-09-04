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
	version: '25 Autumn',

	/** Link to further information (e.g. blog post) */
	link: 'https://nextcloud.com/blog/nextcloud-hub25-autumn/',

	/** Release notes in list format */
	releaseNotes: [
		'🫧 ' + t('firstrunwizard', 'Global redesign and usability lift'),
		'🎨 ' + t('firstrunwizard', 'New Office UI: colors, tabs, bars'),
		'💪 ' + t('firstrunwizard', 'Performance and stability boost'),
		'🧠 ' + t('firstrunwizard', 'New AI Agency tools unlocked'),
		'💬 ' + t('firstrunwizard', 'Talk threads & live transcription'),
		'📅 ' + t('firstrunwizard', 'Calendar: date poll for participants'),
		'🔎 ' + t('firstrunwizard', 'Intuitive file search'),
		'👥 ' + t('firstrunwizard', 'Teams 2.0 & quick Guest accounts'),
		'👑 ' + t('firstrunwizard', 'Quick presets & many other admin updates'),
		'⚡ ' + t('firstrunwizard', 'Vue3, WebSockets and more OpenAPI for devs'),
		t('firstrunwizard', '… and much more!'),
	],

	/** Alternative text for the release animation */
	videoAltText: t('firstrunwizard', 'Get to know the new features of Hub {version}', { version: '25 Autumn' }),

	/** Subject that is used when sharing the post */
	shareSubject: t('firstrunwizard', 'Nextcloud Hub 25 Autumn – Your digital workspace, ready in no time ⚡'),
}
