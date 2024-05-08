<!--
  - SPDX-FileCopyrightText: 2019 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<div :class="$style.wrapper">
		<video :class="$style.video"
			playsinline
			autoplay
			muted
			@ended="handleEnded">
			<source :src="videoWebm" type="video/webm">
			<source :src="videoMp4" type="video/mp4">
			{{ videoFallbackText }}
		</video>
	</div>
</template>

<script setup lang="ts">
import { translate as t } from '@nextcloud/l10n'
import { imagePath } from '@nextcloud/router'

const emit = defineEmits<{
	(e: 'next'): void
}>()

const videoMp4 = imagePath('firstrunwizard', 'Nextcloud.mp4')
const videoWebm = imagePath('firstrunwizard', 'Nextcloud.webm')

const videoFallbackText = t('firstrunwizard', 'Welcome to {cloudName}!', { cloudName: window.OC.theme.name })

/**
 * Handle video has ended
 */
function handleEnded() {
	emit('next')
}
</script>

<style module>
.video {
	width: 100%;
	height: 100%;
	object-fit: cover;
}

.wrapper {
	background-color: var(--color-primary-element);
}
</style>
