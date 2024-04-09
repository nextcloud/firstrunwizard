<!--
  - @copyright Copyright (c) 2024 Ferdinand Thiessen <opensource@fthiessen.de>
  -
  - @author Ferdinand Thiessen <opensource@fthiessen.de>
  -
  - @license AGPL-3.0-or-later
  -
  - This program is free software: you can redistribute it and/or modify
  - it under the terms of the GNU Affero General Public License as
  - published by the Free Software Foundation, either version 3 of the
  - License, or (at your option) any later version.
  -
  - This program is distributed in the hope that it will be useful,
  - but WITHOUT ANY WARRANTY; without even the implied warranty of
  - MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  - GNU Affero General Public License for more details.
  -
  - You should have received a copy of the GNU Affero General Public License
  - along with this program. If not, see <http://www.gnu.org/licenses/>.
  -
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

import HubRelease from '../../hub-release'
import WizardPage from '../WizardPage.vue'
</script>

<style module>
.list {
	margin-inline: 2em auto;
}

.entry {
	padding-block: var(--default-grid-baseline);
}
</style>
