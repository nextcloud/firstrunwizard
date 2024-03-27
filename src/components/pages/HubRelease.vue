<!--
  - @copyright Copyright (c) 2024 Ferdinand Thiessen <opensource@fthiessen.de>
  -
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
	<WizardPage :title="t('firstrunwizard', 'Introducing Nextcloud Hub {version}', { version: HUBRelease.version })">
		<a :href="HUBRelease.link" :class="$style.anchor" target="_blank">
			<video :class="$style.animation"
				playsinline
				autoplay
				muted>
				<source :src="videoWebm" type="video/webm">
				<source :src="videoMp4" type="video/mp4">
				{{ HUBRelease.videoAltText }}
			</video>
		</a>
	</WizardPage>
</template>

<script setup lang="ts">
import { translate as t } from '@nextcloud/l10n'
import { imagePath } from '@nextcloud/router'

import HUBRelease from '../../hub-release'
import WizardPage from '../WizardPage.vue'

const videoMp4 = imagePath('firstrunwizard', 'nextcloudHub.mp4')
const videoWebm = imagePath('firstrunwizard', 'nextcloudHub.webm')
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
