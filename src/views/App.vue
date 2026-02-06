<!--
  - SPDX-FileCopyrightText: 2023 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<script setup lang="ts">
import axios from '@nextcloud/axios'
import { loadState } from '@nextcloud/initial-state'
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
/** This is set to true in case the user already received the wizard but Nextcloud was updated to show the changelog only */
const showChangelogOnly = loadState<boolean>('firstrunwizard', 'changelogOnly', false)
/** The index of the changelog page for first run on updated Nextcloud Hub only */
const changelogPage = Math.max(pages.findIndex((page) => page.id === 'whats-new'), 0)

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
		noClose
		:dark="!isMobile"
		:setReturnFocus
		@close="close"
		@next="currentPage += 1"
		@previous="currentPage -= 1">
		<IntroAnimation
			v-if="currentPage === -1"
			@next="currentPage = showChangelogOnly ? changelogPage : 0" />
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
