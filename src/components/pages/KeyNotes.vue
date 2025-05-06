<!--
  - SPDX-FileCopyrightText: 2023 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<WizardPage
		:scroller-classes="scrollerClasses"
		:title="t('firstrunwizard', 'A collaboration platform that puts you in control')">
		<InfoCard
			:title="t('firstrunwizard', 'Privacy')"
			:subtitle="t('firstrunwizard', 'Host your data and files where you decide.')">
			<NcIconSvgWrapper :class="$style.icon" inline :path="mdiLock" />
		</InfoCard>
		<InfoCard
			:title="t('firstrunwizard', 'Productivity')"
			:subtitle="t('firstrunwizard', 'Collaborate and communicate across any platform.')">
			<NcIconSvgWrapper :class="$style.icon" inline :path="mdiBriefcaseCheck" />
		</InfoCard>
		<InfoCard
			:title="t('firstrunwizard', 'Interoperability')"
			:subtitle="t('firstrunwizard', 'Import and export anything you want with open standards.')">
			<NcIconSvgWrapper :class="$style.icon" inline :path="mdiSwapHorizontal" />
		</InfoCard>
		<InfoCard
			:title="t('firstrunwizard', 'Community')"
			:subtitle="t('firstrunwizard', 'Enjoy constant improvements from a thriving open-source community.')">
			<NcIconSvgWrapper :class="$style.icon" inline :path="mdiAccountGroup" />
		</InfoCard>

		<p :class="$style.version">
			{{ versionNumber }}
		</p>
	</WizardPage>
</template>

<script setup lang="ts">
import { mdiAccountGroup, mdiBriefcaseCheck, mdiLock, mdiSwapHorizontal } from '@mdi/js'
import { translate as t } from '@nextcloud/l10n'
import NcIconSvgWrapper from '@nextcloud/vue/components/NcIconSvgWrapper'
import InfoCard from '../InfoCard.vue'
import WizardPage from '../WizardPage.vue'

defineProps<{
	scrollerClasses?: string | string[] | Record<string, boolean>
}>()

const versionNumber = t('firstrunwizard', 'This Nextcloud is on version {version}', { version: window.OC.config.versionstring })
</script>

<style module>
.icon {
	margin-block: calc((1lh - 20px) / 2);
}

.version {
	color: var(--color-text-maxcontrast);
	margin-block: calc(var(--default-grid-baseline) * 4) 0;
	text-align: center;
}
</style>
