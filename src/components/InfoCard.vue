<!--
  - SPDX-FileCopyrightText: 2023 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<component
		:is="isLink ? 'a' : 'div'"
		:href="href || undefined"
		:class="[$style.card, { [$style.link]: isLink }]"
		:target="!isLink ? undefined : '_blank'"
		:rel="!isLink ? undefined : 'noreferrer'">
		<div :class="$style.icon">
			<slot />
		</div>
		<div :class="$style.text">
			<h3 :class="$style.heading">
				{{ title }}
			</h3>
			<p v-if="subtitle !== undefined" v-text="subtitle" />
		</div>
	</component>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps<{
	title: string
	subtitle?: string
	href?: string
}>()

const isLink = computed(() => !!props.href)
</script>

<style module lang="scss">
.card {
	display: flex;
	gap: var(--default-grid-baseline);
	max-width: 250px;
	box-sizing: border-box;
	height: auto;
}

.icon {
	display: flex;
	flex: 0 0 var(--default-clickable-area);
	align-items: start;

	&:empty {
		display: none;
	}
}

.heading {
	// While this is semantically a heading, visually it should be bold text
	font-size: var(--default-font-size);
	font-weight: bold;
	margin: 0;
}

.link {
	box-shadow: 0px 0px 10px 0px var(--color-box-shadow);
	border-radius: var(--border-radius-large);
	padding: calc(var(--default-grid-baseline) * 4);
	&:focus-visible {
		outline: 2px solid var(--color-main-text);
		box-shadow: 0 0 0 4px var(--color-main-background);
	}
}

.text {
	display: flex;
	flex-direction: column;
	justify-content: center;
}
</style>
