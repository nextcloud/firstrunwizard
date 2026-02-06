<!--
  - SPDX-FileCopyrightText: 2019 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<div :class="$style.introAnimation">
		<video
			ref="video"
			:class="$style.introAnimation__video"
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
		<NcButton
			v-if="canSkip"
			:class="$style.introAnimation__skipButton"
			alignment="end-reverse"
			variant="primary"
			@click="handleEnded">
			<template #icon>
				<NcIconSvgWrapper directional :path="mdiChevronRight" />
			</template>
			{{ t('firstrunwizard', 'Skip') }}
		</NcButton>
	</div>
</template>

<script setup lang="ts">
import { mdiChevronRight } from '@mdi/js'
import { t } from '@nextcloud/l10n'
import { imagePath } from '@nextcloud/router'
import { computed, onMounted, ref, useTemplateRef } from 'vue'
import NcButton from '@nextcloud/vue/components/NcButton'
import NcIconSvgWrapper from '@nextcloud/vue/components/NcIconSvgWrapper'

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
const canSkip = ref(false)
const videoPoster = computed(() => (autoPlayDisabled.value || videoStarted.value) ? videoFallbackImage : videoFallbackImagePre)

onMounted(() => {
	autoPlayDisabled.value = 'getAutoplayPolicy' in navigator
		// @ts-expect-error -- firefox experimental API
		&& navigator.getAutoplayPolicy(videoElement.value) === 'disallowed'

	window.setTimeout(() => {
		// allow skipping after 2 seconds
		window.setTimeout(() => {
			canSkip.value = true
		}, 1200)

		if (!videoStarted.value || autoPlayDisabled.value) {
			// skip to the end after showing the fallback image for a short time
			window.setTimeout(handleEnded, 1200)
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
.introAnimation {
	background-color: var(--color-primary-element);
}

.introAnimation__video {
	display: block;
	object-fit: cover;
	height: 100%;
	width: 100%;
}

.introAnimation__skipButton {
	position: absolute !important;
	inset-block-end: var(--default-grid-baseline);
	inset-inline-end: var(--default-grid-baseline);
}
</style>
