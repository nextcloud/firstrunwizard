<!--
  - SPDX-FileCopyrightText: 2023 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<a
		:class="$style.badge"
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
