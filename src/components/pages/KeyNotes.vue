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
	<WizardPage :scroller-classes="scrollerClasses"
		:title="t('firstrunwizard', 'A collaboration platform that puts you in control')">
		<Card :title="t('firstrunwizard', 'Privacy')"
			:subtitle="t('firstrunwizard', 'Host your data and files where you decide.')">
			<NcIconSvgWrapper :path="mdiLock" />
		</Card>
		<Card :title="t('firstrunwizard', 'Productivity')"
			:subtitle="t('firstrunwizard', 'Collaborate and communicate across any platform.')">
			<NcIconSvgWrapper :path="mdiBriefcaseCheck" />
		</Card>
		<Card :title="t('firstrunwizard', 'Interoperability')"
			:subtitle="t('firstrunwizard', 'Import and export anything you want with open standards.')">
			<NcIconSvgWrapper :path="mdiSwapHorizontal" />
		</Card>
		<Card :title="t('firstrunwizard', 'Community')"
			:subtitle="t('firstrunwizard', 'Enjoy constant improvements from a thriving open-source community.')">
			<NcIconSvgWrapper :path="mdiAccountGroup" />
		</Card>
	</WizardPage>
</template>

<script setup lang="ts">
import { mdiAccountGroup, mdiBriefcaseCheck, mdiLock, mdiSwapHorizontal } from '@mdi/js'
import { translate as t } from '@nextcloud/l10n'
import { NcIconSvgWrapper } from '@nextcloud/vue'

import Card from '../Card.vue'
import WizardPage from '../WizardPage.vue'

defineProps<{
	scrollerClasses?: string | string[] | Record<string, boolean>
}>()
</script>
