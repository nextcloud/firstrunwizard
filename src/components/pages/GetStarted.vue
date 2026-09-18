<!--
  - SPDX-FileCopyrightText: 2026 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<script setup lang="ts">
import { mdiAccountCircleOutline, mdiCalendarAccount, mdiCellphone, mdiCheck, mdiChevronRight, mdiEmailOutline, mdiMonitor } from '@mdi/js'
import { loadState } from '@nextcloud/initial-state'
import { translate as t } from '@nextcloud/l10n'
import { generateUrl } from '@nextcloud/router'
import { computed } from 'vue'
import NcIconSvgWrapper from '@nextcloud/vue/components/NcIconSvgWrapper'
import WizardPage from '../WizardPage.vue'

defineProps<{
	scrollerClasses?: string | string[] | Record<string, boolean>
}>()

interface Onboarding {
	displayName: string
	hasAvatar: boolean
	hasName: boolean
	hasEmail: boolean
	canChangeAvatar: boolean
	canChangeName: boolean
}

const onboarding = loadState<Onboarding>('firstrunwizard', 'onboarding', {
	displayName: '',
	hasAvatar: false,
	hasName: false,
	hasEmail: false,
	canChangeAvatar: true,
	canChangeName: true,
})
const desktop = loadState<string>('firstrunwizard', 'desktop', '#')
const android = loadState<string>('firstrunwizard', 'android', '#')
const ios = loadState<string>('firstrunwizard', 'ios', '#')

const profileUrl = generateUrl('/settings/user')
const syncClientsUrl = generateUrl('/settings/user/sync-clients')

/** Rough device family from the user agent, to lead with the right client. */
const ua = navigator.userAgent
const platform = /android/i.test(ua)
	? 'android'
	: /iphone|ipad|ipod/i.test(ua)
		? 'ios'
		: /macintosh|mac os x/i.test(ua)
			? 'mac'
			: /windows/i.test(ua)
				? 'windows'
				: /linux/i.test(ua)
					? 'linux'
					: 'other'
const isMobilePlatform = platform === 'android' || platform === 'ios'

interface Link {
	label: string
	href: string
	/** Filled (primary) button — the option that fits the visitor's device. */
	primary?: boolean
}

interface Step {
	key: string
	icon: string
	title: string
	subtitle: string
	/** true = done (checked), false = to-do (checkable), null = an action with no completion state */
	done: boolean | null
	links: Link[]
	recommended?: boolean
}

/** Both mobile stores, with the one matching the visitor's device leading and filled. */
const mobileLinks = computed<Link[]>(() => {
	const appStore = { label: t('firstrunwizard', 'App Store'), href: ios, primary: platform === 'ios' }
	const playStore = { label: t('firstrunwizard', 'Google Play'), href: android, primary: platform === 'android' }
	return platform === 'ios' ? [appStore, playStore] : [playStore, appStore]
})

const steps = computed<Step[]>(() => {
	const list: Step[] = []
	if (onboarding.canChangeAvatar) {
		list.push({
			key: 'avatar',
			icon: mdiAccountCircleOutline,
			done: onboarding.hasAvatar,
			title: t('firstrunwizard', 'Add a profile picture'),
			subtitle: t('firstrunwizard', 'Help colleagues recognise you across every app.'),
			links: [{ label: t('firstrunwizard', 'Add photo'), href: profileUrl }],
		})
	}
	if (onboarding.canChangeName) {
		list.push({
			key: 'name',
			icon: mdiAccountCircleOutline,
			done: onboarding.hasName,
			title: t('firstrunwizard', 'Set your full name'),
			subtitle: t('firstrunwizard', 'So your name shows up instead of your username.'),
			links: [{ label: t('firstrunwizard', 'Set name'), href: profileUrl }],
		})
	}
	list.push({
		key: 'email',
		icon: mdiEmailOutline,
		done: onboarding.hasEmail,
		title: t('firstrunwizard', 'Add your email address'),
		subtitle: t('firstrunwizard', 'Needed for notifications and to reset your password.'),
		links: [{ label: t('firstrunwizard', 'Add email'), href: profileUrl }],
	})
	list.push({
		key: 'desktop',
		icon: mdiMonitor,
		done: null,
		title: t('firstrunwizard', 'Install the desktop app'),
		subtitle: t('firstrunwizard', 'Keep your files in sync on Windows, macOS and Linux.'),
		links: [{ label: t('firstrunwizard', 'Download'), href: desktop, primary: !isMobilePlatform }],
		recommended: !isMobilePlatform,
	})
	list.push({
		key: 'mobile',
		icon: mdiCellphone,
		done: null,
		title: t('firstrunwizard', 'Get the mobile app'),
		subtitle: t('firstrunwizard', 'Your files, calendar and contacts in your pocket.'),
		links: mobileLinks.value,
		recommended: isMobilePlatform,
	})
	list.push({
		key: 'calendar',
		icon: mdiCalendarAccount,
		done: null,
		title: t('firstrunwizard', 'Connect calendar & contacts'),
		subtitle: t('firstrunwizard', 'Sync them with the devices you already use.'),
		links: [{ label: t('firstrunwizard', 'Connect'), href: syncClientsUrl }],
	})
	return list
})

const checkable = computed(() => steps.value.filter((s) => s.done !== null))
const doneCount = computed(() => checkable.value.filter((s) => s.done === true).length)
const allDone = computed(() => doneCount.value === checkable.value.length)
const progressPct = computed(() => checkable.value.length === 0 ? 0 : Math.round(doneCount.value / checkable.value.length * 100))

const greeting = computed(() => onboarding.displayName
	? t('firstrunwizard', 'Welcome, {name}!', { name: onboarding.displayName.split(' ')[0] })
	: t('firstrunwizard', 'Let\'s get you set up'))
</script>

<template>
	<WizardPage
		:scrollerClasses="scrollerClasses"
		:title="greeting"
		:subtitle="t('firstrunwizard', 'A few quick steps to get the most out of Nextcloud.')">
		<div :class="$style.panel">
			<!-- Progress -->
			<div :class="$style.progress">
				<div :class="$style.progressBar">
					<div :class="$style.progressFill" :style="{ width: progressPct + '%' }" />
				</div>
				<span :class="$style.progressLabel">
					{{ allDone
						? t('firstrunwizard', 'All set — nice one! 🎉')
						: t('firstrunwizard', '{done} of {total} done', { done: doneCount, total: checkable.length }) }}
				</span>
			</div>

			<!-- Checklist -->
			<ul :class="$style.steps">
				<li
					v-for="(step, index) in steps"
					:key="step.key"
					:class="[$style.step, { [$style.stepDone]: step.done === true }]"
					:style="{ '--reveal-delay': (index * 70) + 'ms' }">
					<span :class="[$style.badge, { [$style.badgeDone]: step.done === true }]">
						<NcIconSvgWrapper :path="step.done === true ? mdiCheck : step.icon" :size="20" />
					</span>
					<span :class="$style.body">
						<span :class="$style.stepTitle">{{ step.title }}</span>
						<span :class="$style.stepSub">
							{{ step.subtitle }}
							<span v-if="step.recommended" :class="$style.recommended">· {{ t('firstrunwizard', 'recommended for your device') }}</span>
						</span>
					</span>
					<span v-if="step.done !== true" :class="$style.ctaGroup">
						<a
							v-for="link in step.links"
							:key="link.label"
							:class="[$style.cta, { [$style.ctaPrimary]: link.primary }]"
							:href="link.href"
							target="_blank"
							rel="noreferrer">
							<span :class="$style.ctaLabel">{{ link.label }}</span>
							<NcIconSvgWrapper :class="$style.ctaIcon" :path="mdiChevronRight" :size="16" />
						</a>
					</span>
				</li>
			</ul>
		</div>
	</WizardPage>
</template>

<style module lang="scss">
.panel {
	width: 100%;
	max-width: 500px;
	margin-inline: auto;
	text-align: start;
}

.progress {
	display: flex;
	align-items: center;
	gap: calc(var(--default-grid-baseline) * 3);
	margin-bottom: calc(var(--default-grid-baseline) * 4);
}

.progressBar {
	flex: 1;
	height: 8px;
	border-radius: 4px;
	background: var(--color-background-dark);
	overflow: hidden;
}

.progressFill {
	height: 100%;
	border-radius: 4px;
	background: var(--color-primary-element);
	transition: width .6s cubic-bezier(0.22, 1, 0.36, 1);
}

.progressLabel {
	font-size: .85rem;
	color: var(--color-text-maxcontrast);
	white-space: nowrap;
}

.steps {
	list-style: none;
	padding: 0;
	margin: 0;
	display: flex;
	flex-direction: column;
	gap: 2px;
}

.step {
	display: flex;
	align-items: center;
	gap: calc(var(--default-grid-baseline) * 3);
	padding: calc(var(--default-grid-baseline) * 2) calc(var(--default-grid-baseline) * 2);
	border-radius: var(--border-radius-large);
	transition: background-color .15s ease;

	// Staggered entrance.
	opacity: 0;
	animation: step-reveal .5s cubic-bezier(0.22, 1, 0.36, 1) forwards;
	animation-delay: var(--reveal-delay, 0ms);

	&:hover {
		background: var(--color-background-hover);
	}
}

// Uniform circular leading badge for every row.
.badge {
	flex: 0 0 34px;
	width: 34px;
	height: 34px;
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 50%;
	background: var(--color-background-dark);
	color: var(--color-text-maxcontrast);
	transition: transform .2s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.step:hover .badge {
	transform: scale(1.08);
}

.badgeDone {
	background: color-mix(in srgb, var(--color-success, #46ba61) 22%, transparent);
	color: var(--color-success, #46ba61);
}

.body {
	flex: 1;
	display: flex;
	flex-direction: column;
	gap: 1px;
	min-width: 0;
}

.stepTitle {
	font-weight: 600;
}

.stepSub {
	font-size: .84rem;
	color: var(--color-text-maxcontrast);
}

.recommended {
	color: var(--color-primary-element);
	font-weight: 600;
}

.stepDone {
	.stepTitle {
		color: var(--color-text-maxcontrast);
	}
}

// One or two action buttons, always the same width, stacked when there are two.
.ctaGroup {
	flex: 0 0 auto;
	display: flex;
	flex-direction: column;
	align-items: stretch;
	gap: 6px;
}

.cta {
	box-sizing: border-box;
	width: 148px;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	gap: 2px;
	padding-block: 6px;
	padding-inline: 14px;
	border-radius: var(--border-radius-pill);
	font-weight: 600;
	white-space: nowrap;
	color: var(--color-primary-element-light-text);
	background: var(--color-primary-element-light);
	transition: background-color .15s ease;

	&:hover {
		background: var(--color-primary-element-light-hover);
	}

	&:focus-visible {
		outline: 2px solid var(--color-main-text);
	}
}

// The option that matches the visitor's device stands out with a filled button.
.ctaPrimary {
	color: var(--color-primary-element-text);
	background: var(--color-primary-element);

	&:hover {
		background: var(--color-primary-element-hover);
	}
}

.ctaIcon {
	margin-inline-end: -4px;
}

@keyframes step-reveal {
	from { opacity: 0; transform: translateY(12px); }
	to { opacity: 1; transform: none; }
}

@media (prefers-reduced-motion: reduce) {
	.step,
	.badge {
		opacity: 1;
		animation: none;
		transition: background-color .15s ease;
		transform: none;
	}

	.progressFill {
		transition: none;
	}
}
</style>
