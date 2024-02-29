<!--
  - @copyright Copyright (c) 2019 Julius Härtl <jus@bitgrid.net>
  -
  - @author Julius Härtl <jus@bitgrid.net>
  - @author Simon Lindner <szaimen@e.mail.de>
  - @author Marco Ambrosini <marcoambrosini@proton.me>
  - @author Ferdinand Thiessen <opensource@fthiessen.de>
  -
  - @license AGPL-3.0-or-later
  -
  - This program is free software: you can redistribute it and/or modify
  - it under the terms of the GNU Affero General Public License as
  - published by the Free Software Foundation, either version 3 of the
  - License, or (at your option) any later version.
  -
  - This program is distributed in the hope that it will be useful,
  - but WITHOUT ANY WARRANTY; without even the implied warranty of
  - MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  - GNU Affero General Public License for more details.
  -
  - You should have received a copy of the GNU Affero General Public License
  - along with this program. If not, see <http://www.gnu.org/licenses/>.
  -
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
