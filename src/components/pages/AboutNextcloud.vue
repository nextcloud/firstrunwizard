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
	<WizardPage :title="t('firstrunwizard', 'More about Nextcloud')">
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

		<p :class="$style.version">
			{{ versionNumber }}
		</p>
	</WizardPage>
</template>

<script setup lang="ts">
import { translate as t } from '@nextcloud/l10n'

import Card from '../Card.vue'
import WizardPage from '../WizardPage.vue'

const versionNumber = t('firstrunwizard', 'This Nextcloud is on version {version}', { version: window.OC.config.versionstring })
</script>

<style module>
.version {
	color: var(--color-text-maxcontrast);
	margin-block: calc(var(--default-grid-baseline) * 4) 0;
	text-align: center;
}
</style>
