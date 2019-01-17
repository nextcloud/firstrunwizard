<template>
	<transition v-if="showModal" name="modal">
		<div id="firstrunwizard" class="modal-mask">
			<div id="firstrunwizard-navigation">
				<a v-if="hasPrevious" id="prev" @click="previous">
					<div class="icon-view-previous icon-white"><span class="hidden-visually">{{ t('firstrunwizard', 'Previous') }}</span></div>
				</a>
				<a v-if="hasNext" id="next" @click="next">
					<div class="icon-view-next icon-white"><span class="hidden-visually">{{ t('firstrunwizard', 'Next') }}</span></div>
				</a>
				<a id="close" class="icon-close icon-white" @click="close">
					<span class="hidden-visually">{{ t('firstrunwizard', 'Close') }}</span>
				</a>
			</div>
			<div class="modal-wrapper" @click.self="close">
				<div class="modal-container">
					<div class="modal-header">
						<div class="firstrunwizard-header">
							<div class="logo">
								<p class="hidden-visually">
									{{ oc_defaults.name }}
								</p>
							</div>
							<h2 v-html="oc_defaults.slogan" />
							<p />
						</div>
					</div>
					<div class="modal-body">
						<slot v-if="slides.length > 0" name="body">
							<transition name="fade" mode="out-in">
								<div v-if="slides[currentSlide].type === 'inline'" :key="currentSlide" v-html="slides[currentSlide].content" />
							</transition>
						</slot>
					</div>
					<div class="modal-footer">
						<button v-if="isLast" class="primary modal-default-button" @click="close">
							{{ t('firstrunwizard', 'Start using Nextcloud') }}
						</button>
					</div>
				</div>
			</div>
		</div>
	</transition>
</template>
<style lang="scss">
	/* Page styling needs to be unscoped, since we load it separately from the server */
	#firstrunwizard {

		.page {
			display: flex;
			flex-direction: row;
			flex-wrap: wrap;
			max-width: 900px;
			width: 70vw;

			&:not(.intro) {
				overflow: auto;
				max-height: 60vh;
			}
			&.intro {
				margin: 0 0 -60px;
				max-height: 60vh;
				.content {
					padding: 0;
					img {
						width: 100%;
					}
				}
			}

			h3 {
				margin: 10px 0 10px;
				line-height: 120%;
				padding: 0;
			}
			.image {
				padding: 20px;
				max-width: calc(50% - 40px);
				flex-grow: 1;
				img {
					width: 100%;
				}
			}
			.content {
				padding: 20px;
				width: 100%;
			}
			p {
				margin-bottom: 20px;
			}
			.description-block {
				margin-bottom: 40px;
			}
			.description {
				margin: 20px;
				width: auto;
				flex-grow: 1;
				max-width: calc(50% - 40px);
			}
			ul {
				margin: 10px;
				li {
					margin-left: 20px;
					margin-bottom: 10px;
					list-style: circle outside;
				}
			}
			a:not(.button) {
				&:hover,
				&:focus {
					text-decoration: underline;
				}
			}
			.button {
				display: inline-block;

				img {
					width: 16px;
					height: 16px;
					opacity: .5;
					margin-top: -3px;
					vertical-align: middle;
				}
			}
		}

		.content-clients {
			width: 100%;
			text-align: center;
			a {
				text-decoration: none;
				display: inline-block;
			}
			.clientslinks .appsmall {
				height: 32px;
				width: 32px;
				position: relative;
				opacity: .5;
				vertical-align: middle;
			}
			.clientslinks .button {
				display: inline-block;
				padding: 8px;
				font-weight: normal;
				font-size: 14px;
			}
		}
		.content-final {
			h3 {
				background-position: 0;
				background-size: 16px 16px;
				padding-left: 26px;
				opacity: .7;
			}
		}
		p a {
			font-weight: bold;
			color: var(--color-primary);
			&:hover,
			&:focus {
				color: var(color-text-light);
			}
		}

		.footnote {
			margin-top: 40px;
		}
	}

	.clientslinks {
		margin-top: 20px;
		margin-bottom: 20px;
	}

	#wizard-values {
		list-style-type: none;
		display: flex;
		flex-wrap: wrap;
		li {
			display: block;
			min-width: 250px;
			width: 33%;
			flex-grow: 1;
			margin: 20px 0 20px 0;
			span {
				opacity: .7;
				display: block;
				height: 50px;
				width: 50px;
				background-size: 40px;
				margin: auto;
			}
			h3 {
				margin: 10px 0 10px 0;
				font-size: 130%;
				text-align: center;
			}
		}
	}

	.details-link {
		text-align: center;
	}

	@media only screen and (max-width: 680px) {
		#firstrunwizard {
			.firstrunwizard-header div.logo {
				background-size: 120px;
			}
			h2 {
				font-size: 20px;
			}
			.page > div {
				max-width: 100% !important;
				width: 100%;
			}
			.page #wizard-values li {
				min-width: 100%;
				overflow: hidden;
				display: flex;
				span {
					width: 44px !important;
					padding-right: 20px;
					flex-grow: 0;
				}
				h3 {
					font-size: 12px;
					text-align: left;
					flex-grow: 1;
				}
			}
		}
	}
</style>

<style lang="scss">
	.modal-mask {
		position: fixed;
		z-index: 9998;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, .7);
		display: table;
		transition: opacity .3s ease;
	}

	.modal-wrapper {
		display: table-cell;
		vertical-align: middle;
	}

	.modal-container {
		width: 70%;
		max-width: 900px;
		max-height: 80%;
		margin: 0 auto;
		padding: 0;
		background-color: var(--color-main-background);
		border-radius: var(--border-radius-large);
		overflow: hidden;
		box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
		transition: all .3s ease;
		display: table;
	}

	.modal-header {
		max-height: 30vh;
		overflow: hidden;

		.firstrunwizard-header {
			padding: 20px 12px;
			background: var(--color-primary) var(--image-login-background) no-repeat 50% 50%;
			background-size: cover;
			color: var(--color-primary-text);
			text-align: center;
			.logo {
				background: var(--image-logo) no-repeat center;
				background-size: contain;
				width: 175px;
				height: 120px;
				margin: 0 auto;
				max-height: 10vh;
			}
			h2 {
				font-size: 4vh;
				margin-top: 3vh;
				line-height: 5vh;
				color: var(--color-primary-text);
				font-weight: 300;
				padding: 0 0 10px;
			}
		}
	}

	.modal-body {
		margin: 0;
		transition: all 1s;
	}

	.modal-default-button {
		float: right;
	}

	.modal-footer {
		overflow: hidden;
	}

	.modal-footer button {
		margin: 10px;
		display: inline-block;
	}

	/* Transitions */

	.fade-enter-active, .fade-leave-active {
		transition: transform .1s, opacity .25s;
	}
	.fade-enter {
		transform: translateX(50%);
		opacity: 0;
	}
	.fade-leave-to {
		transform: translateX(-50%);
		opacity: 0;
	}

	.modal-enter {
		opacity: 0;
	}

	.modal-leave-active {
		opacity: 0;
	}

	.modal-enter .modal-container,
	.modal-leave-active .modal-container {
		-webkit-transform: scale(1.1);
		transform: scale(1.1);
	}

	#firstrunwizard-navigation {
		#prev, #next {
			position: absolute;
			top: 0;
			z-index: 10000;
			width: 15%;
			height: 100%;
			display: block;
		}
		#prev {
			left: 0;
		}
		#next {
			right: 0;
		}

		.icon-view-next,
		.icon-view-previous {
			background-size: 24px;
			background-position: center;
			width: 44px;
			height: 44px;
			border-radius: 50%;
			top: 50%;
			position: absolute;
			margin: auto;
			left: calc(100% - 22px - 44px);
		}
		.icon-view-next {
			background-color: var(--color-primary);
			box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
			left: 22px;
		}

		.icon-close {
			position: absolute;
			top: 0;
			right: 0;
			z-index: 10000;
			width: 44px;
			height: 44px;
			display: block;
			background-size: 24px;
			background-position: center;
		}
	}

</style>
<script>
import axios from 'nextcloud-axios'

export default {
	name: 'FirstRunWizard',
	data() {
		return {
			showModal: false,
			slides: [],
			currentSlide: 0
		}
	},
	computed: {
		hasNext() {
			return this.currentSlide < this.slides.length - 1
		},
		hasPrevious() {
			return this.currentSlide > 0
		},
		isLast() {
			return this.currentSlide === this.slides.length - 1
		},
		isFirst() {
			return this.currentSlide === 0
		}
	},
	beforeMount() {
		axios.get(OC.generateUrl('/apps/firstrunwizard/wizard')).then((response) => {
			this.slides = response.data
			this.showModal = true
		})
	},
	methods: {
		open() {
			this.showModal = true
			window.addEventListener('keydown', this.handleKeydown)
		},
		close() {
			this.showModal = false
			axios.delete(OC.generateUrl('/apps/firstrunwizard/wizard'))
			window.removeEventListener('keydown', this.handleKeydown)
		},
		next() {
			if (this.isLast) {
				this.close()
				return
			}
			this.currentSlide += 1
		},
		previous() {
			if (this.isFirst) {
				return
			}
			this.currentSlide -= 1
		},
		handleKeydown(e) {
			switch (e.keyCode) {
			case 37:
				this.previous()
				break
			case 13:
			case 39:
				this.next()
				break
			case 27:
				this.close()
				break
			}
		}
	}
}
</script>
