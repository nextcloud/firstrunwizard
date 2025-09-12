<!--
  - SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<div :class="$style.wrapper">
		<!-- The "wave" background for the logo on the first page-->
		<Transition
			:enter-class="waveTransitionClasses.enter"
			:enter-active-class="waveTransitionClasses.active"
			:leave-active-class="waveTransitionClasses.active"
			:leave-to-class="waveTransitionClasses.leave">
			<div v-if="isFirstPage" :class="$style.background_circle" />
		</Transition>

		<!-- Bar on the modal top -->
		<div :class="$style.background_bar" />

		<!-- Back button on mobile if not first page -->
		<NcButton
			v-if="!isFirstPage"
			:aria-label="t('firstrunwizard', 'Go to previous page')"
			:class="$style.button_back"
			variant="tertiary-no-background"
			@click="$emit('update:current-index', currentIndex - 1)">
			<template #icon>
				<NcIconSvgWrapper :path="mdiArrowLeft" />
			</template>
		</NcButton>

		<!-- Custom close button to fix color contrast on first page -->
		<NcButton
			:aria-label="t('firstrunwizard', 'Close')"
			:class="$style.button_close"
			:variant="isFirstPage ? 'tertiary-on-primary' : 'tertiary-no-background'"
			@click="$emit('update:current-index', -1)">
			<template #icon>
				<NcIconSvgWrapper :path="mdiClose" />
			</template>
		</NcButton>

		<!-- The first page has the logo within a "wave" style background -->
		<div v-if="isFirstPage" :class="$style.logo" />

		<!-- The page that is currently show wrapped in a slide transition -->
		<Transition
			mode="out-in"
			:enter-class="transitionClasses.enter"
			:enter-active-class="transitionClasses.active"
			:leave-active-class="transitionClasses.active"
			:leave-to-class="transitionClasses.leave">
			<component :is="currentPage.component" :scroller-classes="isFirstPage ? $style.first_page_scroller : ''" />
		</Transition>

		<!-- Next button(s) -->
		<div :class="$style.button_wrapper">
			<NcButton
				v-for="button, index of currentPage.buttons"
				:key="button.to"
				alignment="center-reverse"
				:variant="index === currentPage.buttons.length - 1 ? 'primary' : 'secondary'"
				:wide="index === currentPage.buttons.length - 1"
				@click="goToPage(button.to)">
				<template v-if="!isLastPage" #icon>
					<NcIconSvgWrapper :path="mdiArrowRight" />
				</template>
				{{ button.label }}
			</NcButton>
		</div>
	</div>
</template>

<script setup lang="ts">
import type { IPage } from '../pages.ts'

import { mdiArrowLeft, mdiArrowRight, mdiClose } from '@mdi/js'
import { translate as t } from '@nextcloud/l10n'
import { imagePath } from '@nextcloud/router'
import { computed, ref, useCssModule, watch } from 'vue'
import NcButton from '@nextcloud/vue/components/NcButton'
import NcIconSvgWrapper from '@nextcloud/vue/components/NcIconSvgWrapper'

const props = defineProps<{
	pages: IPage[]
	currentIndex: number
}>()

const emit = defineEmits<{
	(e: 'update:current-index', index: number): void
}>()

/**
 * True if the transition effect should be reversed (e.g. going back)
 */
const reverseTransition = ref(false)

const currentPage = computed(() => props.pages[props.currentIndex])
const isFirstPage = computed(() => props.currentIndex === 0)
const isLastPage = computed(() => props.currentIndex === (props.pages.length - 1))

const cssLogoUrl = `url('${imagePath('firstrunwizard', 'nextcloudLogo.svg')}')`

const transitions = useCssModule('transitions')

/**
 * The transition effect to use for the page change
 */
const transitionClasses = computed(() => {
	const direction = reverseTransition.value ? 'right' : 'left'

	return {
		active: transitions['slide-active'],
		enter: transitions[`slide-${direction}-enter`],
		leave: transitions[`slide-${direction}-leave-to`],
	}
})

/**
 * The transition effect for the wave on the first page
 */
const waveTransitionClasses = computed(() => {
	const direction = reverseTransition.value ? 'down' : 'up'
	return {
		active: transitions['slide-active'],
		enter: transitions[`slide-${direction}-enter`],
		leave: transitions[`slide-${direction}-leave-to`],
	}
})

/**
 * When we show a previous page we want to reverse the transition
 */
watch(() => props.currentIndex, (newPage, oldPage) => {
	if (newPage < oldPage) {
		reverseTransition.value = true
	} else {
		reverseTransition.value = false
	}
})

/**
 * Move to page with given ID
 *
 * @param pageId ID of the page to got to
 */
function goToPage(pageId: string) {
	const id = props.pages.findIndex((page) => page.id === pageId)
	emit('update:current-index', id)
}
</script>

<style module lang="scss">
.wrapper {
	position: relative;
	overflow: hidden;
	padding: calc(var(--default-grid-baseline) * 5);
	display: flex;
	flex-direction: column;
	justify-content: space-between;
	width: 100%;
	min-height: min(590px, calc(100dvh - 2 * var(--header-height)));
}

.background_circle {
	height: 6000px;
	width: 6000px;
	border-radius: 3000px;
	background-color: var(--color-primary-element);
	position: absolute;
	top: -5900px;
	left: calc( -3000px + 50%);
}

.background_bar {
	position:absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 10px;
	background-color: var(--color-primary-element);
}

.button_back {
	position: absolute!important;
	top: var(--default-grid-baseline);
	left: var(--default-grid-baseline);
}

.button_close {
	position: absolute!important;
	top: var(--default-grid-baseline);
	right: var(--default-grid-baseline);
}

.button_wrapper {
	display: flex;
	flex-wrap: wrap;
	gap: 22px;
	width: 100%;

	// Do not change width of buttons
	> * {
		flex: 0 0 fit-content;
	}

	// stretch the last one
	> *:last-of-type {
		flex: 1 0 fit-content;
	}
}

.logo {
	height: 70px;
	background-image: var(--image-logoheader, var(--image-logo, v-bind(cssLogoUrl)));
	background-repeat: no-repeat;
	background-position: center;
	background-size: 100px;
	margin: auto;
	position: absolute;
	left: 0;
	width: 100%;
	pointer-events: none;
}

// Compensate logo height on first page
.first_page_scroller {
	margin-top: calc(var(--default-grid-baseline) * 8 + 70px) !important;
}
</style>

<style module="transitions">
/**
 * The transition classes
 */
.slide-active {
	transition: all .2s;
}

.slide-left-enter {
	opacity: 0;
	transform: translateX(30%);
}

.slide-left-leave-to {
	opacity: 0;
	transform: translateX(-30%);
}

.slide-right-enter {
	opacity: 0;
	transform: translateX(-30%);
}

.slide-right-leave-to {
	opacity: 0;
	transform: translateX(30%);
}

.slide-up-enter {
	top: calc(-5900px);
}

.slide-up-leave-to {
	top: calc(-5900px - 80px);
}

.slide-down-enter {
	top: calc(-5900px - 80px);
}

.slide-down-leave-to {
	top: calc(-5900px);
}
</style>
