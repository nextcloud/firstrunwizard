<!--
  - SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<WizardPage :title="t('firstrunwizard', 'Find out more on the blog')">
		<NcButton :href="HubRelease.link" target="_blank">
			{{ t('firstrunwizard', 'Read the Nextcloud Hub {version} blog', { version: HubRelease.version }) }} ↗
		</NcButton>

		<section :class="$style.share_section">
			<h3 :class="$style.heading">
				{{ t('firstrunwizard', 'Share your opinion about Nextcloud Hub {version}', { version: HubRelease.version }) }}
			</h3>
			<div :class="$style.share_wrapper">
				<InfoCard
					v-for="entry of shareLinks"
					:key="entry.id"
					:class="$style.card"
					:href="entry.link"
					:title="entry.id === 'email' ? t('firstrunwizard', 'Share via email') : t('firstrunwizard', 'Share on {socialMedia}', { socialMedia: entry.name })">
					<NcIconSvgWrapper
						v-if="entry.icon"
						:svg="entry.id !== 'email' ? entry.icon : undefined"
						:path="entry.id === 'email' ? entry.icon : undefined" />
				</InfoCard>
			</div>
		</section>
	</WizardPage>
</template>

<script setup lang="ts">
import { mdiEmail } from '@mdi/js'
import { translate as t } from '@nextcloud/l10n'
import NcButton from '@nextcloud/vue/components/NcButton'
import NcIconSvgWrapper from '@nextcloud/vue/components/NcIconSvgWrapper'
import InfoCard from '../InfoCard.vue'
import WizardPage from '../WizardPage.vue'
import blueskySvg from '../../../img/bluesky.svg?raw'
import facebookSvg from '../../../img/facebook.svg?raw'
import linkedInSvg from '../../../img/linkedin.svg?raw'
import mastodonSvg from '../../../img/mastodon.svg?raw'
import xSvg from '../../../img/x.svg?raw'
import HubRelease from '../../hub-release.ts'

const encodedLink = encodeURIComponent(encodeURI(HubRelease.link))
const mailSubject = encodeURIComponent(HubRelease.shareSubject ?? t('firstrunwizard', 'Nextcloud Hub {version} release', { version: HubRelease.version }))
const mailBody = encodeURIComponent(t('firstrunwizard', 'Read more about it on the Nextcloud Hub {version} blog', { version: HubRelease.version }) + '\n' + HubRelease.link)

const shareLinks = [
	{
		id: 'bluesky',
		name: 'Bluesky',
		link: `https://bsky.app/intent/compose?text=${encodedLink}`,
		icon: blueskySvg,
	},
	{
		id: 'facebook',
		name: 'Facebook',
		link: `https://www.facebook.com/sharer/sharer.php?u=${encodedLink}`,
		icon: facebookSvg,
	},
	{
		id: 'linkedin',
		name: 'LinkedIn',
		link: `https://www.linkedin.com/sharing/share-offsite/?url=${encodedLink}`,
		icon: linkedInSvg,
	},
	{
		id: 'mastodon',
		name: 'Mastodon',
		link: `https://mastodon.social/share?text=${encodedLink}`,
		icon: mastodonSvg,
	},
	{
		id: 'x',
		name: 'X',
		link: `https://x.com/intent/post?url=${encodedLink}&via=Nextclouders&text=${encodeURIComponent(HubRelease.shareSubject ?? '')}`,
		icon: xSvg,
	},
	{
		id: 'email',
		name: 'EMail',
		link: `mailto:?subject=${mailSubject}&body=${mailBody}`,
		icon: mdiEmail,
	},
]
</script>

<style module>
.share_section {
	width: 100%;
}

.share_wrapper {
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	gap: calc(var(--default-grid-baseline) * 4);
	justify-content: space-around;
	width: 100%;
}

.card {
	flex: 1 1 auto;
	min-width: calc(50% - var(--default-grid-baseline) * 10);

	/* Reduce padding a bit as we only have a single line of text with icon */
	padding: calc(var(--default-grid-baseline) * 2) !important;
}

.heading {
	/* Semantically a heading but visually bold text */
	font-size: var(--default-font-size);
	font-weight: bold;
}
</style>
