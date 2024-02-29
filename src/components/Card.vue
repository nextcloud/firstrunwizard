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
	<element :is="isLink ? 'a' : 'div'"
		:href="href || undefined"
		:class="[$style.card, { [$style.link]: isLink }]"
		:target="!isLink ? undefined : '_blank'"
		:rel="!isLink ? undefined : 'noreferrer'">
		<div :class="$style.icon">
			<slot />
		</div>
		<div :class="$style.text">
			<h3 :class="$style.heading">
				{{ title }}
			</h3>
			<p v-if="subtitle !== undefined" v-text="subtitle" />
		</div>
	</element>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps<{
	title: string
	subtitle?: string
	href?: string
}>()

const isLink = computed(() => !!props.href)
</script>

<style module lang="scss">
.card {
	display: flex;
	max-width: 250px;
	box-sizing: border-box;
	height: fit-content;
}

.icon {
	display: flex;
	flex: 0 0 44px;
	align-items: center;

	&:empty {
		display: none;
	}
}

.heading {
	font-weight: bold;
	margin: 0;
}

.link {
	box-shadow: 0px 0px 10px 0px var(--color-box-shadow);
	border-radius: var(--border-radius-large);
	padding: calc(var(--default-grid-baseline) * 4);
	&:focus-visible {
		outline: 2px solid var(--color-main-text);
		box-shadow: 0 0 0 4px var(--color-main-background);
	}
}

.text {
	display: flex;
	flex-direction: column;
	justify-content: center;
}
</style>
