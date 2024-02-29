<!--
  - @copyright Copyright (c) 2023 Marco Ambrosini <marcoambrosini@proton.me>
  -
  - @author Simon Lindner <szaimen@e.mail.de>
  - @author Marco Ambrosini <marcoambrosini@proton.me>
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
	<WizardPage :title="t('firstrunwizard', 'Seamless integration with your devices.')"
		:subtitle="t('firstrunwizard', 'Sync your files across your devices with the desktop and mobile apps, and connect your calendar and contacts.')">
		<AppStoreBadge type="android" />
		<AppStoreBadge type="ios" />
		<Card :href="desktop"
			:title="t('firstrunwizard', 'Desktop app ↗')"
			:subtitle="t('firstrunwizard', 'Download For Windows, Mac OS and Linux.')" />
		<Card :href="syncClientsUrl"
			:title="t('firstrunwizard', 'Calendar and contacts ↗')"
			:subtitle="t('firstrunwizard', 'Connect your calendar and contacts with your devices.')" />
	</WizardPage>
</template>

<script setup lang="ts">
import { loadState } from '@nextcloud/initial-state'
import { translate as t } from '@nextcloud/l10n'
import { generateUrl } from '@nextcloud/router'

import AppStoreBadge from '../AppStoreBadge.vue'
import Card from '../Card.vue'
import WizardPage from '../WizardPage.vue'

const desktop = loadState<string>('firstrunwizard', 'desktop')
const syncClientsUrl = generateUrl('settings/user/sync-clients')
</script>
