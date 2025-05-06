<!--
  - SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<NcSettingsSection
		class="settings-clients"
		:name="t('firstrunwizard', 'Get the apps to sync your files')"
		:description="
			t(
				'firstrunwizard',
				'{productName} gives you access to your files wherever you are. Our easy to use desktop and mobile clients are available for all major platforms at zero cost.',
				{ productName },
				null,
				{ escape: false },
			)
		">
		<ul :class="$style.list" :aria-label="t('firstrunwizard', 'App for syncing')">
			<li
				v-for="client, id of clients"
				:key="id"
				:class="$style.entry">
				<a
					:class="$style.link"
					:href="client.href"
					rel="noreferrer noopener"
					target="_blank">
					<img
						:class="$style.image"
						:src="client.image"
						:alt="client.name">
				</a>
			</li>
		</ul>
		<!-- eslint-disable-next-line vue/no-v-html -->
		<p :class="$style.text" v-html="settingsText" />
	</NcSettingsSection>
</template>

<script setup lang="ts">
import { loadState } from '@nextcloud/initial-state'
import { translate as t } from '@nextcloud/l10n'
import NcSettingsSection from '@nextcloud/vue/components/NcSettingsSection'

interface InitialState {
	appPasswords: string
	clients: {
		[id: string]: {
			href: string
			name: string
			image: string
		}
	}
}

const { clients, appPasswords } = loadState<InitialState>('firstrunwizard', 'links')

const productName = window.OC.theme.name ?? 'Nextcloud'
const linkStart = `<a href="${appPasswords}">`
const linkEnd = '</a>'
const settingsText = t(
	'firstrunwizard',
	'Set up sync clients using an {linkStart}app password{linkEnd}. That way you can make sure you are able to revoke access in case you lose that device.',
	{ linkStart, linkEnd },
	undefined,
	{ escape: false },
)
</script>

<style module>
.list {
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	gap: calc(3 * var(--default-grid-baseline));
}

.enty {
	display: flex;
	flex: 1 0 0px;
}

.link {
	display: flex;
}

.image {
	height: calc(2 * var(--default-clickable-area));
}

.text {
	margin-block-start: calc(3 * var(--default-grid-baseline));
}
</style>
