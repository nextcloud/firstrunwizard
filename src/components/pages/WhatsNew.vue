<!--
  - SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->

<template>
	<WizardPage :title="t('firstrunwizard', 'New in Nextcloud Hub {version}', { version: HubRelease.version }) + ' 🚀'">
		<ul :class="$style.list">
			<li v-for="(entry, index) of HubRelease.releaseNotes" :key="index" :class="$style.entry">
				{{ entry }}
			</li>
		</ul>
	</WizardPage>
</template>

<script setup lang="ts">
import { translate as t } from '@nextcloud/l10n'
import WizardPage from '../WizardPage.vue'
import HubRelease from '../../hub-release.ts'
</script>

<style module>
.list {
	margin-inline: 2em auto;
}

.entry {
	padding-block: var(--default-grid-baseline);
}
</style>
