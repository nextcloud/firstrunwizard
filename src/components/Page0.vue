<!--
  - @copyright Copyright (c) 2019 Julius Härtl <jus@bitgrid.net>
  -
  - @author Julius Härtl <jus@bitgrid.net>
  - @author Simon Lindner <szaimen@e.mail.de>
  - @author Marco Ambrosini <marcoambrosini@proton.me>
  -
  - @license GNU AGPL version 3 or any later version
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
	<div class="video-wrapper">
		<video ref="video"
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

<script>
import { generateFilePath } from '@nextcloud/router'

export default {
	name: 'Page0',
	data() {
		return {
			videoMp4: generateFilePath('firstrunwizard', 'img', 'Nextcloud.mp4'),
			videoWebm: generateFilePath('firstrunwizard', 'img', 'Nextcloud.webm'),
		}
	},
	computed: {
		videoFallbackText() {
			return t('firstrunwizard', 'Welcome to {cloudName}!', { cloudName: window.OC.theme.name })
		},
	},

	methods: {
		handleEnded() {
			this.$emit('next')
		},
	},
}
</script>

<style scoped lang="scss">
	video {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	.video-wrapper {
		background-color: var(--color-primary-element);
	}
</style>
