<!--
  - SPDX-FileCopyrightText: 2023 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<WizardPage :title="t('firstrunwizard', 'More about Nextcloud')">
		<InfoCard
			href="https://apps.nextcloud.com/"
			:title="t('firstrunwizard', 'Explore more apps ↗')"
			:subtitle="t('firstrunwizard', 'Extend the functionality of Nextcloud with hundreds of community-developed apps.')" />
		<InfoCard
			href="https://nextcloud.com/contribute/"
			:title="t('firstrunwizard', 'Get involved! ↗')"
			:subtitle="t('firstrunwizard', 'Be a part of the community that helps build, design, translate and promote Nextcloud!')" />
		<InfoCard
			href="https://docs.nextcloud.com/"
			:title="t('firstrunwizard', 'Need help? ↗')"
			:subtitle="t('firstrunwizard', 'Find out more about your Nextcloud setup with the admin, user or developer documentation.')" />
		<InfoCard
			href="https://nextcloud.com/enterprise/"
			:title="t('firstrunwizard', 'For large organisations ↗')"
			:subtitle="t('firstrunwizard', 'Get Nextcloud Enterprise for mission critical environments where advanced security and compliance are important.')" />
	</WizardPage>
</template>

<script setup lang="ts">
import { translate as t } from '@nextcloud/l10n'
import InfoCard from '../InfoCard.vue'
import WizardPage from '../WizardPage.vue'
</script>
