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
	version: '26 Spring',

	/** Link to further information (e.g. blog post) */
	link: 'https://nextcloud.com/blog/nextcloud-hub26-spring/',

	/** Release notes in list format */
	releaseNotes: [
		'💫' + t('firstrunwizard', 'Refined design, optimized performance'),
		'💪' + t('firstrunwizard', 'Empowering developers with an open platform'),
		'✏️' + t('firstrunwizard', 'Your choice: Nextcloud Office powered by Collabora or Euro-Office'),
		'💌' + t('firstrunwizard', 'Delegate calendars, meetings and mail boxes for better collaboration'),
		'📈' + t('firstrunwizard', 'Gantt charts, dependencies & more in Nextcloud Deck'),
		'🧠' + t('firstrunwizard', 'More agency: let the Assistant work for you across files, emails, forms, and more'),
		'🧩' + t('firstrunwizard', 'Pexip, Matrix, and more updates in integrations'),
		t('firstrunwizard', '… and many more improvements in all apps!'),
		t('firstrunwizard', 'Experience the brand new Nextcloud Hub!'),
	],

	/** Alternative text for the release animation */
	videoAltText: t('firstrunwizard', 'Get to know the new features of Hub {version}', { version: '26 Spring' }),

	/** Subject that is used when sharing the post */
	shareSubject: t('firstrunwizard', 'Time to own your collaboration: Meet Nextcloud Hub 26 Spring! 🚀'),
}
