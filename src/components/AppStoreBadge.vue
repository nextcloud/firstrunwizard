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
	<a class="app-store-badge"
		:aria-label="ariaLabel"
		target="_blank"
		rel="noreferrer"
		:href="href"
		:style="badgeStyle" />
</template>

<script>
import { imagePath } from '@nextcloud/router'
import { loadState } from '@nextcloud/initial-state'

const android = loadState('firstrunwizard', 'android')
const ios = loadState('firstrunwizard', 'ios')

export default {
	name: 'AppStoreBadge',

	props: {
		type: {
			type: String,
			required: true,
			validator: type => ['ios', 'android'].includes(type),
		},
	},

	data() {
		return {
			android,
			ios,
		}
	},

	computed: {
		imagePath() {
			if (this.type === 'ios') {
				return imagePath('firstrunwizard', 'iosBadge.png')
			} else if (this.type === 'android') {
				return imagePath('firstrunwizard', 'androidBadge.png')
			}
			return undefined
		},

		badgeStyle() {
			return { backgroundImage: 'url(' + this.imagePath + ')' }
		},

		href() {
			if (this.type === 'ios') {
				return this.ios
			} else if (this.type === 'android') {
				return this.android
			}
			return undefined
		},

		ariaLabel() {
			if (this.type === 'ios') {
				return t('firstrunwizard', 'Download on Apple app store')
			} else if (this.type === 'android') {
				return t('firstrunwizard', 'Download on Google play store')
			}
			return undefined
		},
	},
}
</script>

<style lang="scss" scoped>
.app-store-badge {
	height: 74px;
	width: 250px;
	background-size: contain;
	background-repeat: no-repeat;
	&:focus-visible {
		outline: 2px solid var(--color-main-text);
		box-shadow: 0 0 0 4px var(--color-main-background);
	}
}
</style>
