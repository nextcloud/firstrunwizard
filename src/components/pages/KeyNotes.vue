<!--
  - SPDX-FileCopyrightText: 2023 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<WizardPage :scroller-classes="scrollerClasses"
		:title="t('firstrunwizard', 'A collaboration platform that puts you in control')">
		<Card :title="t('firstrunwizard', 'Privacy')"
			:subtitle="t('firstrunwizard', 'Host your data and files where you decide.')">
			<NcIconSvgWrapper :path="mdiLock" />
		</Card>
		<Card :title="t('firstrunwizard', 'Productivity')"
			:subtitle="t('firstrunwizard', 'Collaborate and communicate across any platform.')">
			<NcIconSvgWrapper :path="mdiBriefcaseCheck" />
		</Card>
		<Card :title="t('firstrunwizard', 'Interoperability')"
			:subtitle="t('firstrunwizard', 'Import and export anything you want with open standards.')">
			<NcIconSvgWrapper :path="mdiSwapHorizontal" />
		</Card>
		<Card :title="t('firstrunwizard', 'Community')"
			:subtitle="t('firstrunwizard', 'Enjoy constant improvements from a thriving open-source community.')">
			<NcIconSvgWrapper :path="mdiAccountGroup" />
		</Card>
	</WizardPage>
</template>

<script setup lang="ts">
import { mdiAccountGroup, mdiBriefcaseCheck, mdiLock, mdiSwapHorizontal } from '@mdi/js'
import { translate as t } from '@nextcloud/l10n'
import { NcIconSvgWrapper } from '@nextcloud/vue'

import Card from '../Card.vue'
import WizardPage from '../WizardPage.vue'

defineProps<{
	scrollerClasses?: string | string[] | Record<string, boolean>
}>()
</script>
