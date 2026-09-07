<!--
  - SPDX-FileCopyrightText: 2026 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<script setup lang="ts">
import { loadState } from '@nextcloud/initial-state'
import { translate as t } from '@nextcloud/l10n'
import NcSettingsSection from '@nextcloud/vue/components/NcSettingsSection'

interface InitialState {
	office: {
		[id: string]: {
			href: string
			name: string
			image: string
		}
	}
}

const { office } = loadState<InitialState>('firstrunwizard', 'links')
</script>

<template>
	<NcSettingsSection
		class="settings-office"
		:name="t('firstrunwizard', 'Get office editing on your desktop')"
		:description="t('firstrunwizard', 'Edit office documents on your desktop, available for all major platforms at zero cost.')">
		<ul :class="$style.list" :aria-label="t('firstrunwizard', 'Office desktop editors')">
			<li
				v-for="editor, id of office"
				:key="id"
				:class="$style.entry">
				<a
					:class="$style.link"
					:href="editor.href"
					rel="noreferrer noopener"
					target="_blank">
					<img
						:class="$style.image"
						:src="editor.image"
						:alt="editor.name">
				</a>
			</li>
		</ul>
	</NcSettingsSection>
</template>

<style module>
.list {
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	gap: calc(3 * var(--default-grid-baseline));
}

.entry {
	display: flex;
}

.link {
	display: flex;
}

.image {
	height: calc(2 * var(--default-clickable-area));
}
</style>
