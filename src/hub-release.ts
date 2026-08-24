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
	version: '26 Summer',

	/** Link to further information (e.g. blog post) */
	link: 'https://nextcloud.com/blog/nextcloud-hub26-summer/',

	/** Release notes in list format */
	releaseNotes: [
		'✨' + t('firstrunwizard', 'Refined design, optimized performance'),
		'👥' + t('firstrunwizard', 'Your team’s own space with Nextcloud Teams app'),
		'💬' + t('firstrunwizard', 'Classified conversations, channels and announcements'),
		'✍️' + t('firstrunwizard', 'Comments & footnotes in Nextcloud Text'),
		'💫' + t('firstrunwizard', 'Nextcloud Assistant: skills, OCR, split-second performance'),
		'🌄' + t('firstrunwizard', 'Photos, reimagined'),
		'🖥️' + t('firstrunwizard', 'Nextcloud Office for desktop'),
		'🌳' + t('firstrunwizard', 'A new phase for the ecosystem and ISVs'),
		t('firstrunwizard', '… and many more improvements in all apps!'),
		t('firstrunwizard', 'Experience the brand new Nextcloud Hub!'),
	],

	/** Alternative text for the release animation */
	videoAltText: t('firstrunwizard', 'Get to know the new features of Hub {version}', { version: '26 Summer' }),

	/** Subject that is used when sharing the post */
	shareSubject: t('firstrunwizard', 'Time to own your collaboration: Meet Nextcloud Hub 26 Summer! 🚀'),
}
