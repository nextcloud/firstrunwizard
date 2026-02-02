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
			:poster="videoPoster"
			@ended="handleEnded"
			@play="videoStarted = true">
			<source :src="videoWebm" type="video/webm">
			<source :src="videoMp4" type="video/mp4">
			{{ videoFallbackText }}
		</video>
	</div>
</template>

<script setup lang="ts">
import { translate as t } from '@nextcloud/l10n'
import { imagePath } from '@nextcloud/router'
import { computed, onMounted, ref, useTemplateRef } from 'vue'

const emit = defineEmits<{
	(e: 'next'): void
}>()

const videoMp4 = imagePath('firstrunwizard', 'nextcloudHub.mp4')
const videoWebm = imagePath('firstrunwizard', 'nextcloudHub.webm')
const videoFallbackImagePre = imagePath('firstrunwizard', 'nextcloudHub-preload.webp') // first frame of the video
const videoFallbackImage = imagePath('firstrunwizard', 'nextcloudHub.webp') // best visual fallback image of the video
const videoFallbackText = t('firstrunwizard', 'Welcome to {cloudName}!', { cloudName: window.OC.theme.name })

const videoElement = useTemplateRef('video')

const autoPlayDisabled = ref(false)
const videoStarted = ref(false)
const videoPoster = computed(() => (autoPlayDisabled.value || videoStarted.value) ? videoFallbackImage : videoFallbackImagePre)

onMounted(() => {
	autoPlayDisabled.value = 'getAutoplayPolicy' in navigator
		// @ts-expect-error -- firefox experimental API
		&& navigator.getAutoplayPolicy(videoElement.value) === 'disallowed'

	window.setTimeout(() => {
		if (!videoStarted.value || autoPlayDisabled.value) {
			// skip to the end after showing the fallback image for a short time
			window.setTimeout(handleEnded, 1700)
		}
		if (!videoStarted.value) {
			// video has not started playing within 800ms - probably due to browser restrictions
			videoStarted.value = true
		}
	}, 800)
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
