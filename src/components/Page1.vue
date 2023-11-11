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
		<div class="page__scroller first-page">
			<h2 class="page__heading">
				{{ t('firstrunwizard', 'A collaboration platform that puts you in control') }}
			</h2>
			<div class="page__content">
				<Card :title="t('firstrunwizard', 'Privacy')"
					:subtitle="t('firstrunwizard', 'Host your data and files where you decide.')">
					<Lock :size="20" />
				</Card>
				<Card :title="t('firstrunwizard', 'Productivity')"
					:subtitle="t('firstrunwizard', 'Collaborate and communicate across any platform.')">
					<BriefcaseCheck :size="20" />
				</Card>
				<Card :title="t('firstrunwizard', 'Interoperability')"
					:subtitle="t('firstrunwizard', 'Import and export anything you want with open standards.')">
					<SwapHorizontal :size="20" />
				</Card>
				<Card :title="t('firstrunwizard', 'Community')"
					:subtitle="t('firstrunwizard', 'Enjoy constant improvements from a thriving open-source community.')">
					<AccountGroup :size="20" />
				</Card>
			</div>
		</div>
	</div>
</template>

<script>
import Card from './Card.vue'

import Lock from 'vue-material-design-icons/Lock.vue'
import BriefcaseCheck from 'vue-material-design-icons/BriefcaseCheck.vue'
import SwapHorizontal from 'vue-material-design-icons/SwapHorizontal.vue'
import AccountGroup from 'vue-material-design-icons/AccountGroup.vue'

export default {
	name: 'Page1',

	components: {
		Card,
		Lock,
		BriefcaseCheck,
		SwapHorizontal,
		AccountGroup,
	},
}
</script>

<style lang="scss" scoped>
@import "pageStyles";

.first-page{
	margin-top: 100px;
}
</style>
