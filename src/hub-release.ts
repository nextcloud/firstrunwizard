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
		'✨ ' + t('firstrunwizard', 'Assistant: chat summaries, Mail reply suggestions, answers based on your data, and more'),

		'🖱️ ' + t('firstrunwizard', 'Interactive previews for files, folders, boards and events'),

		'🌐 ' + t('firstrunwizard', 'Federated chat and message editing in Talk'),

		'🗒️ ' + t('firstrunwizard', 'Mini-apps based on Tables'),

		'🔗 ' + t('firstrunwizard', 'Public Collectives sharing, previews and QR-codes'),

		'👥 ' + t('firstrunwizard', 'Manage your team resources like a pro with Nextcloud Teams'),

		'🔄 ' + t('firstrunwizard', 'Forms: automatically sync with a spreadsheet'),
	],

	/** Alternative text for the release animation */
	videoAltText: t('firstrunwizard', 'Get to know the new features of Hub 8'),

	/** Subject that is used when sharing the post */
	shareSubject: t('firstrunwizard', 'Nextcloud Hub {version} release', { version: '8' }),
}
