<!--
  - SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<div :class="$style.wrapper">
		<div :class="[$style.scroller, scrollerClasses]">
			<h2 :class="$style.heading">
				{{ title }}
			</h2>
			<p v-if="subtitle" :class="$style.subtitle">
				{{ subtitle }}
			</p>
			<div :class="$style.content">
				<slot />
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
defineProps<{
	title: string
	subtitle?: string
	scrollerClasses?: string | string[] | Record<string, boolean>
}>()
</script>

<style module>
.wrapper {
	display: flex;
	flex-direction: column;
	justify-content: space-between;
	min-height: min(520px, 50dvh);
}

.scroller {
	overflow-y: scroll;
	margin-top: calc(var(--default-grid-baseline) * 8);
}

.heading {
	text-align: center;
}

.subtitle{
	max-width: 450px;
	margin: auto;
	text-align: center;
}

.content {
	display: flex;
	flex-wrap: wrap;
	gap: calc(var(--default-grid-baseline) * 6);
	justify-content: center;
	margin: calc(var(--default-grid-baseline) * 10) 0;
}
</style>
