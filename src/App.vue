<!--
  - @copyright Copyright (c) 2023 Marco Ambrosini <marcoambrosini@proton.me>
  -
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
	<NcModal v-if="showModal"
		id="firstrunwizard"
		class="first-run-wizard"
		size="normal"
		:has-next="hasNext"
		:has-previous="hasPrevious"
		:set-return-focus="setReturnFocus"
		@close="close"
		@next="goToNextPage"
		@previous="goToPreviousPage">
		<Page0 v-if="page === 0" @next="goToNextPage" />
		<div v-else
			class="first-run-wizard__wrapper">
			<Transition :name="circleSlideDirection">
				<div v-if="page === 1" class="first-run-wizard__background-circle" />
			</Transition>
			<div class="first-run-wizard__background-bar" />
			<NcButton v-if="page > 1"
				type="tertiary"
				class="first-run-wizard__back-button"
				aria-label="t('firstrunwizard', 'Go to previous page')"
				@click="goToPreviousPage">
				<template #icon>
					<ArrowLeft :size="20" />
				</template>
			</NcButton>
			<NcButton :type="page === 1 ? 'primary' : 'tertiary'"
				class="first-run-wizard__close-button"
				aria-label="t('firstrunwizard', 'Close dialog')"
				@click="close">
				<template #icon>
					<Close :size="20" />
				</template>
			</NcButton>
			<div v-if="page === 1" class="first-run-wizard__logo" :style="logoStyle" />
			<Transition :name="pageSlideDirection"
				mode="out-in">
				<Page1 v-if="page === 1" />
				<Page2 v-else-if="page === 2" />
				<Page3 v-else-if="page === 3" />
			</Transition>
			<NcButton type="primary"
				alignment="center-reverse"
				:wide="true"
				@click="handleButtonCLick">
				<template v-if="page !== 3" #icon>
					<ArrowRight :size="20" />
				</template>
				{{ buttonText }}
			</NcButton>
		</div>
	</NcModal>
</template>

<script>
import { NcModal, NcButton } from '@nextcloud/vue'
import { imagePath, generateUrl } from '@nextcloud/router'
import axios from '@nextcloud/axios'

import Page0 from './components/Page0.vue'
import Page1 from './components/Page1.vue'
import Page2 from './components/Page2.vue'
import Page3 from './components/Page3.vue'

import ArrowLeft from 'vue-material-design-icons/ArrowLeft.vue'
import ArrowRight from 'vue-material-design-icons/ArrowRight.vue'
import Close from 'vue-material-design-icons/Close.vue'

export default {
	name: 'App',
	components: {
		NcModal,
		Page0,
		Page1,
		Page2,
		NcButton,
		ArrowLeft,
		ArrowRight,
		Page3,
		Close,
	},

	data() {
		return {
			showModal: false,
			page: 0,
			logoURL: imagePath('firstrunwizard', 'nextcloudLogo.svg'),
			pageSlideDirection: undefined,
			circleSlideDirection: undefined,
			setReturnFocus: undefined,
		}
	},

	computed: {
		logoStyle() {
			return { backgroundImage: 'url(' + this.logoURL + ')' }
		},

		hasPrevious() {
			if (window.innerWidth <= 512) {
				return false
			} else {
				return this.page > 1
			}
		},

		hasNext() {
			if (window.innerWidth <= 512) {
				return false
			} else {
				return this.page < 3
			}
		},

		buttonText() {
			if (this.page === 1) {
				return t('firstrunwizard', 'Nextcloud on all your devices')
			} else if (this.page === 2) {
				return t('firstrunwizard', 'More about Nextcloud')
			} else if (this.page === 3) {
				return t('firstrunwizard', 'Get started!')
			}
			return ''
		},
	},

	methods: {
		open({ setReturnFocus }) {
			if (setReturnFocus) {
				this.setReturnFocus = setReturnFocus
			}
			this.page = 0
			this.showModal = true
		},

		close() {
			this.page = 0
			this.showModal = false
			this.setReturnFocus = undefined
			axios.delete(generateUrl('/apps/firstrunwizard/wizard'))
		},

		goToNextPage() {
			this.pageSlideDirection = 'slide-left'
			if (this.page === 1) {
				this.circleSlideDirection = 'slide-up'
			}
			this.$nextTick(() => {
				this.page++
			})
		},

		goToPreviousPage() {
			this.pageSlideDirection = 'slide-right'
			if (this.page === 2) {
				this.circleSlideDirection = 'slide-down'
			}
			this.$nextTick(() => {
				this.page--
			})

		},

		handleButtonCLick() {
			if (this.page < 3) {
				this.goToNextPage()
			} else {
				this.close()
			}
		},
	},
}
</script>

<style lang="scss" scoped>

.first-run-wizard {
	&__wrapper {
		position: relative;
		overflow: hidden;
		padding: calc(var(--default-grid-baseline) * 5);
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}

	&__background-circle {
		height: 6000px;
		width: 6000px;
		border-radius: 3000px;
		background-color: var(--color-primary-element);
		position: absolute;
		top: -5900px;
		left: calc( -3000px + 50%);
	}

	&__background-bar {
		position:absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 10px;
		background-color: var(--color-primary-element);
	}

	&__back-button {
		position: absolute;
		top: var(--default-grid-baseline);
		left: var(--default-grid-baseline);
	}

	&__close-button {
		position: absolute;
		top: var(--default-grid-baseline);
		right: var(--default-grid-baseline);
	}

	&__logo {
		height: 70px;
		background-repeat: no-repeat;
		background-position: center;
		background-size: 100px;
		margin: auto;
		position: absolute;
		left: 0;
		width: 100%;
		pointer-events: none;
	}
}

:deep .modal-wrapper .modal-container {
	overflow: hidden;
}

:deep .modal-wrapper .modal-container__content {
	overflow: hidden;
	height: 100%;
	display: contents;
}

@media only screen and (max-width: 512px) {
	:deep .modal-wrapper .modal-container {
		height: 100dvh;
		top: 0;
	}

	:deep .modal-header {
		pointer-events: none;
	}
}

:deep .modal-container__close {
	display: none;
}

.slide-right-enter-active,
.slide-right-leave-active,
.slide-left-enter-active,
.slide-left-leave-active,
.slide-up-enter-active,
.slide-up-leave-active,
.slide-down-enter-active,
.slide-down-leave-active {
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
