<!--
  - @copyright Copyright (c) 2023 Marco Ambrosini <marcoambrosini@proton.me>
  -
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
	<a :class="$style.badge"
		:aria-label="ariaLabel"
		target="_blank"
		rel="noreferrer"
		:href="href" />
</template>

<script setup lang="ts">
import { loadState } from '@nextcloud/initial-state'
import { translate as t } from '@nextcloud/l10n'
import { imagePath } from '@nextcloud/router'
import { computed } from 'vue'

const props = defineProps<{
	type: 'ios' | 'android'
}>()

const android = loadState<string>('firstrunwizard', 'android')
const ios = loadState<string>('firstrunwizard', 'ios')

/**
 * Path to the app store badge image
 */
const badgeImagePath = computed(() => {
	if (props.type === 'ios') {
		return imagePath('firstrunwizard', 'iosBadge.png')
	} else if (props.type === 'android') {
		return imagePath('firstrunwizard', 'androidBadge.png')
	}
	return undefined
})

/**
 * The badge image as CSS source URL
 */
const cssBackgroundImage = computed(() => `url('${badgeImagePath.value}')`)

const href = computed(() => {
	if (props.type === 'ios') {
		return ios
	} else if (props.type === 'android') {
		return android
	}
	return undefined
})

const ariaLabel = computed(() => {
	if (props.type === 'ios') {
		return t('firstrunwizard', 'Download on Apple app store')
	} else if (props.type === 'android') {
		return t('firstrunwizard', 'Download on Google play store')
	}
	return undefined
})
</script>

<style module lang="scss">
.badge {
	height: 74px;
	width: 250px;
	background-image: v-bind(cssBackgroundImage);
	background-size: contain;
	background-repeat: no-repeat;
	&:focus-visible {
		outline: 2px solid var(--color-main-text);
		box-shadow: 0 0 0 4px var(--color-main-background);
	}
}
</style>
