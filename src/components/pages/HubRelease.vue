<!--
  - SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<WizardPage :title="t('firstrunwizard', 'Introducing Nextcloud Hub {version}', { version: HUBRelease.version })">
		<a :href="HUBRelease.link" :class="$style.anchor" target="_blank">
			<video
				:class="$style.animation"
				autoplay
				muted
				playsinline
				:poster="videoFallbackImage">
				<source :src="videoWebm" type="video/webm;codecs=vp9">
				<source :src="videoMp4" type="video/mp4">
				{{ HUBRelease.videoAltText }}
			</video>
		</a>
	</WizardPage>
</template>

<script setup lang="ts">
import { translate as t } from '@nextcloud/l10n'
import { imagePath } from '@nextcloud/router'
import WizardPage from '../WizardPage.vue'
import HUBRelease from '../../hub-release.ts'

const videoMp4 = imagePath('firstrunwizard', 'nextcloudHub.mp4')
const videoWebm = imagePath('firstrunwizard', 'nextcloudHub.webm')
const videoFallbackImage = imagePath('firstrunwizard', 'nextcloudHub.webp')
</script>

<style module>
.anchor {
	width: 100%;
}

.animation {
	border-radius: var(--border-radius-rounded);
	object-fit: contain;
	width: 100%;
}
</style>
