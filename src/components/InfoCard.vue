<!--
  - SPDX-FileCopyrightText: 2023 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps<{
	title: string
	subtitle?: string
	href?: string
	/** When set, the card fades/rises in with a stagger based on this index. */
	revealIndex?: number
}>()

const isLink = computed(() => !!props.href)
const revealStyle = computed(() => props.revealIndex === undefined
	? undefined
	: { '--reveal-delay': `${props.revealIndex * 80}ms` })
</script>

<template>
	<component
		:is="isLink ? 'a' : 'div'"
		:href="href || undefined"
		:class="[$style.card, { [$style.link]: isLink, [$style.reveal]: revealIndex !== undefined }]"
		:style="revealStyle"
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

<style module lang="scss">
.card {
	display: flex;
	gap: var(--default-grid-baseline);
	max-width: 250px;
	box-sizing: border-box;
	height: auto;
	transition: transform .2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow .2s ease;

	// The icon pops a touch on hover — playful, and it works for plain cards too.
	.icon :deep(svg),
	.icon :deep(img) {
		transition: transform .2s cubic-bezier(0.34, 1.56, 0.64, 1);
	}

	&:hover .icon :deep(svg),
	&:hover .icon :deep(img) {
		transform: scale(1.18) rotate(-4deg);
	}
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

	&:hover {
		transform: translateY(-3px);
		box-shadow: 0 6px 20px 0 var(--color-box-shadow);
	}

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

// Staggered entrance.
.reveal {
	opacity: 0;
	animation: card-reveal .5s cubic-bezier(0.22, 1, 0.36, 1) forwards;
	animation-delay: var(--reveal-delay, 0ms);
}

@keyframes card-reveal {
	from { opacity: 0; transform: translateY(14px); }
	to { opacity: 1; transform: none; }
}

@media (prefers-reduced-motion: reduce) {
	.card,
	.card:hover .icon :deep(svg),
	.card:hover .icon :deep(img) {
		transition: none;
		transform: none;
	}

	.reveal {
		opacity: 1;
		animation: none;
	}
}
</style>
