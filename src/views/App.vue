<!--
  - SPDX-FileCopyrightText: 2023 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<script setup lang="ts">
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'
import { useIsSmallMobile } from '@nextcloud/vue/composables/useIsMobile'
import { ref } from 'vue'
import NcModal from '@nextcloud/vue/components/NcModal'
import IntroAnimation from '../components/pages/IntroAnimation.vue'
import SlideShow from '../components/SlideShow.vue'
import pages from '../pages.ts'

// Exposes open and close functions from the component
defineExpose({ open, close })

const isMobile = useIsSmallMobile()

const showModal = ref(false)
const currentPage = ref(-1)
const setReturnFocus = ref<HTMLElement | SVGElement | string>()

/**
 * Open the first run wizard modal
 *
 * @param focusReturn The element to return focus after the modal is closed
 */
function open(focusReturn?: HTMLElement | SVGElement | string) {
	setReturnFocus.value = focusReturn
	currentPage.value = -1
	showModal.value = true
}

/**
 * Close the modal
 */
function close() {
	currentPage.value = -1
	showModal.value = false

	// Important: Do not show again automatically
	axios.delete(generateUrl('/apps/firstrunwizard/wizard'))
}
</script>

<template>
	<!-- The dark prop is set to prevent backdrop "hit" when the first real page is shown -->
	<NcModal
		v-if="showModal"
		id="firstrunwizard"
		class="first-run-wizard"
		size="normal"
		closeOnClickOutside
		:dark="!isMobile"
		:setReturnFocus
		@close="close"
		@next="currentPage += 1"
		@previous="currentPage -= 1">
		<IntroAnimation
			v-if="currentPage === -1"
			@next="currentPage = 0" />
		<SlideShow
			v-else
			v-model="currentPage"
			:pages
			@close="close" />
	</NcModal>
</template>

<style lang="scss">
/**
 * Global styles to override vue component styles of the modal
 */

.first-run-wizard .modal-wrapper {
	.modal-container {
		overflow: hidden;

		&__content {
			overflow: hidden;
			height: 100%;
			display: contents;
		}
	}
}

/**
 * Soften the backdrop. NcModal's opaque/dark backdrop is ~92% black, which dims
 * the whole page quite heavily behind the wizard; ease it to a gentler tint that
 * still lifts the modal off the page. (`--opaque` is the current class; `--dark`
 * is kept for older NcModal versions.)
 */
.first-run-wizard.modal-mask--opaque,
.first-run-wizard.modal-mask--dark {
	background-color: rgba(0, 0, 0, 0.75) !important;
	// Frosted backdrop. The blur radius itself is animated on enter/leave (below)
	// for a "focus pull" — the page behind gradually softens as the wizard arrives.
	backdrop-filter: blur(5px) saturate(1.08);
	-webkit-backdrop-filter: blur(5px) saturate(1.08);
}

/**
 * Custom appear/disappear animation. NcModal drives this modal with its `fade`
 * transition, which by default just eases opacity (250ms) and lightly scales the
 * container. We override it (scoped styles, so !important is required) to give the
 * wizard a polished entrance: it rises with a spring, sharpens from a soft blur
 * into focus, and the backdrop pulls focus behind it — then folds away cleanly.
 */

// Backdrop: fade + animate the blur radius so the page eases out of / into focus.
.first-run-wizard.fade-enter-active {
	transition: opacity .45s ease, backdrop-filter .55s ease, -webkit-backdrop-filter .55s ease !important;
}

.first-run-wizard.fade-leave-active {
	transition: opacity .8s ease, backdrop-filter .9s ease, -webkit-backdrop-filter .9s ease !important;
}

.first-run-wizard.fade-enter-from,
.first-run-wizard.fade-leave-to {
	backdrop-filter: blur(0) saturate(1) !important;
	-webkit-backdrop-filter: blur(0) saturate(1) !important;
}

// Container: spring up into place while sharpening from a soft blur.
.first-run-wizard.fade-enter-active .modal-container {
	transition:
		transform .62s cubic-bezier(0.22, 1.35, 0.5, 1),
		filter .45s ease,
		box-shadow .62s ease !important;
}

.first-run-wizard.fade-leave-active .modal-container {
	// Long, gently accelerating ease so it drifts away serenely.
	transition:
		transform .8s cubic-bezier(0.33, 0, 0.2, 1),
		filter .8s ease,
		box-shadow .8s ease !important;
}

.first-run-wizard.fade-enter-from .modal-container {
	transform: translateY(40px) scale(0.9) !important;
	filter: blur(12px) !important;
	box-shadow: 0 0 0 rgba(0, 0, 0, 0) !important;
}

.first-run-wizard.fade-enter-to .modal-container,
.first-run-wizard.fade-leave-from .modal-container {
	// Resting elevation the entrance settles into (and the exit lifts off from).
	box-shadow: 0 24px 60px -12px rgba(0, 0, 0, 0.35) !important;
}

.first-run-wizard.fade-leave-to .modal-container {
	transform: translateY(22px) scale(0.93) !important;
	filter: blur(6px) !important;
	box-shadow: 0 0 0 rgba(0, 0, 0, 0) !important;
}

@media (prefers-reduced-motion: reduce) {
	.first-run-wizard.modal-mask--opaque,
	.first-run-wizard.modal-mask--dark {
		backdrop-filter: none !important;
		-webkit-backdrop-filter: none !important;
	}

	.first-run-wizard.fade-enter-active .modal-container,
	.first-run-wizard.fade-leave-active .modal-container {
		transition: none !important;
	}

	.first-run-wizard.fade-enter-from .modal-container,
	.first-run-wizard.fade-leave-to .modal-container {
		transform: none !important;
		filter: none !important;
	}
}

@media only screen and (max-width: 512px) {
	.first-run-wizard {
		.modal-wrapper .modal-container {
			height: 100dvh;
			top: 0;
		}

		.modal-header {
			pointer-events: none;
		}
	}
}
</style>
