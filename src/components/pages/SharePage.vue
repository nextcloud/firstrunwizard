<!--
  - SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<WizardPage :title="t('firstrunwizard', 'Find out more on the blog')">
		<NcButton :href="HubRelease.link" target="_blank">
			{{ t('firstrunwizard', 'Read the Nextcloud Hub {version} blog', { version: HubRelease.version}) }} ↗
		</NcButton>

		<section :class="$style.share_section">
			<h2>{{ t('firstrunwizard', 'Share your opinion about Nextcloud Hub {version}', { version: HubRelease.version }) }}</h2>
			<div :class="$style.share_wrapper">
				<Card v-for="entry of shareLinks"
					:key="entry.id"
					:class="$style.card"
					:href="entry.link"
					:title="entry.id === 'mail' ? t('firstrunwizard', 'Share via email') : t('firstrunwizard', 'Share on {socialMedia}', { socialMedia: entry.name })">
					<NcIconSvgWrapper v-if="entry.icon"
						:svg="entry.id !== 'email' ? entry.icon : undefined"
						:path="entry.id === 'email' ? entry.icon : undefined" />
				</Card>
			</div>
		</section>
	</WizardPage>
</template>

<script setup lang="ts">
import { mdiEmail } from '@mdi/js'
import { translate as t } from '@nextcloud/l10n'
import NcButton from '@nextcloud/vue/dist/Components/NcButton.js'
import NcIconSvgWrapper from '@nextcloud/vue/dist/Components/NcIconSvgWrapper.js'

import facebookSvg from '../../../img/facebook.svg?raw'
import mastodonSvg from '../../../img/mastodon.svg?raw'
import xSvg from '../../../img/x.svg?raw'

import HubRelease from '../../hub-release'
import WizardPage from '../WizardPage.vue'
import Card from '../Card.vue'

const encodedLink = encodeURIComponent(encodeURI(HubRelease.link))
const mailSubject = encodeURIComponent(HubRelease.shareSubject ?? t('firstrunwizard', 'Nextcloud Hub {version} release', { version: HubRelease.version }))
const mailBody = encodeURIComponent(t('firstrunwizard', 'Read more about it on the Nextcloud Hub {version} blog', { version: HubRelease.version }) + '\n' + HubRelease.link)

const shareLinks = [
	{
		id: 'facebook',
		name: 'Facebook',
		link: `https://www.facebook.com/sharer/sharer.php?u=${encodedLink}`,
		icon: facebookSvg,
	},
	{
		id: 'x',
		name: 'X',
		link: `https://x.com/intent/post?url=${encodedLink}&via=Nextclouders&text=${encodeURIComponent(HubRelease.shareSubject ?? '')}`,
		icon: xSvg,
	},
	{
		id: 'mastodon',
		name: 'Mastodon',
		link: `https://mastodon.social/share?text=${encodedLink}`,
		icon: mastodonSvg,
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

	/* Reduce padding a bit as we only have a single line of text with icon */
	padding: calc(var(--default-grid-baseline) * 2) !important;
}
</style>
