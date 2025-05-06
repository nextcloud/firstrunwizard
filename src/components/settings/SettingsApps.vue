<!--
  - SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<NcSettingsSection
		:name="t('firstrunwizard', 'Connect other apps to {productName}', { productName }, null, { escape: false })"
		:description="
			t('firstrunwizard', 'Besides the mobile apps and desktop client you can connect any other software that supports the WebDAV/CalDAV/CardDAV protocols to {productName}.', { productName }, null, { escape: false })
		">
		<ul
			:class="$style.list"
			:aria-label="t('firstrunwizard', 'Apps to connect to {productName}', { productName }, null, { escape: false })">
			<li
				v-for="app, id of apps"
				:key="id">
				<NcButton :href="app.link">
					<template #icon>
						<img :class="$style.icon" :src="app.image" alt="">
					</template>
					{{ app.label }}
				</NcButton>
			</li>
		</ul>
	</NcSettingsSection>
</template>

<script setup lang="ts">
import { loadState } from '@nextcloud/initial-state'
import { translate as t } from '@nextcloud/l10n'
import NcButton from '@nextcloud/vue/components/NcButton'
import NcSettingsSection from '@nextcloud/vue/components/NcSettingsSection'

const apps = loadState<{ [id: string]: { image: string, label: string, link: string } }>('firstrunwizard', 'apps')

const productName = window.OC.theme.name ?? 'Nextcloud'
</script>

<style module>
.list {
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	gap: calc(3 * var(--default-grid-baseline));
}

.icon {
	height: 20px;
	width: 20px;

	filter: var(--background-invert-if-dark)
}
</style>
