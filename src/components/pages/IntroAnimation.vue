<!--
  - SPDX-FileCopyrightText: 2019 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<div :class="$style.wrapper">
		<video
			ref="video"
			:class="$style.video"
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
import { onMounted, useTemplateRef } from 'vue'

const emit = defineEmits<{
	(e: 'next'): void
}>()

const videoMp4 = imagePath('firstrunwizard', 'Nextcloud.mp4')
const videoWebm = imagePath('firstrunwizard', 'Nextcloud.webm')
const videoFallbackImage = imagePath('firstrunwizard', 'Nextcloud.webp')
const videoFallbackText = t('firstrunwizard', 'Welcome to {cloudName}!', { cloudName: window.OC.theme.name })

const videoElement = useTemplateRef('video')

onMounted(() => {
	// check if the browser allows auto play - otherwise we need to skip this
	if (navigator.getAutoplayPolicy && navigator.getAutoplayPolicy(videoElement.value) === 'disallowed') {
		videoElement.value!.poster = videoFallbackImage
		window.setTimeout(handleEnded, 2500)
	}
})

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
