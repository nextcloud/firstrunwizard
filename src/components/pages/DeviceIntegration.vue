<!--
  - SPDX-FileCopyrightText: 2023 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<WizardPage
		:title="t('firstrunwizard', 'Seamless integration with your devices.')"
		:subtitle="t('firstrunwizard', 'Sync your files across your devices with the desktop and mobile apps, and connect your calendar and contacts.')">
		<AppStoreBadge type="android" />
		<AppStoreBadge type="ios" />
		<InfoCard
			:href="desktop"
			:title="t('firstrunwizard', 'Desktop app ↗')"
			:subtitle="t('firstrunwizard', 'Download For Windows, Mac OS and Linux.')" />
		<InfoCard
			:href="syncClientsUrl"
			:title="t('firstrunwizard', 'Calendar and contacts ↗')"
			:subtitle="t('firstrunwizard', 'Connect your calendar and contacts with your devices.')" />
	</WizardPage>
</template>

<script setup lang="ts">
import { loadState } from '@nextcloud/initial-state'
import { translate as t } from '@nextcloud/l10n'
import { generateUrl } from '@nextcloud/router'
import AppStoreBadge from '../AppStoreBadge.vue'
import InfoCard from '../InfoCard.vue'
import WizardPage from '../WizardPage.vue'

const desktop = loadState<string>('firstrunwizard', 'desktop')
const syncClientsUrl = generateUrl('settings/user/sync-clients')
</script>
