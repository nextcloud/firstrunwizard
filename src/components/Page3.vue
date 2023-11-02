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
				{{ t('firstrunwizard', 'More about Nextcloud') }}
			</h2>
			<div class="page__content">
				<Card href="https://apps.nextcloud.com/"
					:title="t('firstrunwizard', 'Explore more apps ↗')"
					:subtitle="t('firstrunwizard', 'Extend the functionality of Nextcloud with hundreds of community-developed apps.')" />
				<Card href="https://nextcloud.com/contribute/"
					:title="t('firstrunwizard', 'Get involved! ↗')"
					:subtitle="t('firstrunwizard', 'Be a part of the community that helps build, design, translate and promote Nextcloud!')" />
				<Card href="https://docs.nextcloud.com/"
					:title="t('firstrunwizard', 'Need help? ↗')"
					:subtitle="t('firstrunwizard', 'Find out more about your Nextcloud setup with the admin, user or developer documentation.')" />
				<Card href="https://nextcloud.com/enterprise/"
					:title="t('firstrunwizard', 'For large organisations ↗')"
					:subtitle="t('firstrunwizard', 'Get Nextcloud Enterprise for mission critical environments where advanced security and compliance are important.')" />
			</div>
			<p class="version-number">
				{{ versionNumbrer }}
			</p>
		</div><NcButton type="primary"
			alignment="center-reverse"
			:wide="true"
			@click="$emit('close')">
			{{ t('firstrunwizard', 'Get started!') }}
		</NcButton>
	</div>
</template>

<script>
import Card from './Card.vue'
import { NcButton } from '@nextcloud/vue'

export default {
	name: 'Page3',

	components: {
		NcButton,
		Card,
	},

	computed: {
		versionNumbrer() {
			return t('firstrunwizard ', 'This Nextcloud is on version ') + OC.config.versionstring
		},
	},
}
</script>

<style lang="scss" scoped>
@import "pageStyles";

.page__content {
	margin: calc(var(--default-grid-baseline) * 6) 0 calc(var(--default-grid-baseline) * 4) 0;
}

.version-number {
	margin: 0px 0 calc(var(--default-grid-baseline) * 4) 0;
	color: var(--color-text-maxcontrast);
	text-align: center;
}
</style>
