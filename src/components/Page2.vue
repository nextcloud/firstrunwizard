<!--
  - @copyright Copyright (c) 2023 Marco Ambrosini <marcoambrosini@proton.me>
  -
  - @author Simon Lindner <szaimen@e.mail.de>
  - @author Marco Ambrosini <marcoambrosini@proton.me>
  -
  - @license GNU AGPL version 3 or any later version
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
	<div class="page__wrapper">
		<div class="page__scroller">
			<h2 class="page__heading">
				{{ t('firstrunwizard', 'Seamless integration with your devices.') }}
			</h2>
			<p class="page__subtitle">
				{{ subtitleText }}
			</p>
			<div class="page__content">
				<AppStoreBadge type="android" />
				<AppStoreBadge type="ios" />
				<Card :href="desktop"
					:title="t('firstrunwizard', 'Desktop app ↗')"
					:subtitle="t('firstrunwizard', 'Download For Windows, Mac OS and Linux.')" />
				<Card :href="syncClientsUrl"
					:title="t('firstrunwizard', 'Calendar and contacts ↗')"
					:subtitle="t('firstrunwizard', 'Connect your calendar and contacts with your devices.')" />
			</div>
		</div>
	</div>
</template>

<script>
import Card from './Card.vue'
import AppStoreBadge from './AppStoreBadge.vue'
import { generateUrl } from '@nextcloud/router'
import { loadState } from '@nextcloud/initial-state'

const desktop = loadState('firstrunwizard', 'desktop')

export default {
	name: 'Page2',

	components: {
		Card,
		AppStoreBadge,
	},

	data() {
		return {
			subtitleText: t('firstrunwizard', 'Sync your files across your devices with the desktop and mobile apps, and connect your calendar and contacts.'),
			syncClientsUrl: generateUrl('settings/user/sync-clients'),
			desktop,
		}
	},

}
</script>

<style lang="scss" scoped>
@import 'pageStyles';
</style>
