import { translate as t } from '@nextcloud/l10n'

/* How to do a new release?
 * 1. Update the `version` to the current HUB release
 * 2. Update the `link` for further informations
 * 3. Add release notes, each entry is a new point.
 * 4. Update the alt text for the animation if needed.
 */
export default {
	/** The HUB release version */
	version: '8',

	/** Link to further information (e.g. blog post) */
	link: 'https://nextcloud.com/blog/nextcloud-hub8/',

	/** Release notes in list format */
	releaseNotes: [
		t('firstrunwizard', '🥳 Point one'),
		t('firstrunwizard', '🚀 Point two'),
		t('firstrunwizard', '🤟 Point three'),
	],

	/** Alternative text for the release animation */
	videoAltText: t('firstrunwizard', 'Get to know the new features of Hub 8'),

	/** Subject that is used when sharing the post */
	shareSubject: t('firstrunwizard', 'Nextcloud Hub {version} release', { version: '8' }),
}
