<!--
  - SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<NcSettingsSection
		:name="t('firstrunwizard', 'Server address')"
		:description="t('firstrunwizard', 'Use this link to connect your apps and desktop client to this server:')">
		<NcInputField
			id="endpoint-url"
			:class="$style.input"
			:label="t('firstrunwizard', 'Server address')"
			show-trailing-button
			readonly
			:value="url"
			@trailing-button-click="onCopyContent">
			<template #trailing-button-icon>
				<NcIconSvgWrapper :path="copyIcon" />
			</template>
		</NcInputField>
	</NcSettingsSection>
</template>

<script setup lang="ts">
import { mdiCheck, mdiContentCopy } from '@mdi/js'
import { showSuccess } from '@nextcloud/dialogs'
import { translate as t } from '@nextcloud/l10n'
import { getBaseUrl } from '@nextcloud/router'
import { ref } from 'vue'
import NcIconSvgWrapper from '@nextcloud/vue/components/NcIconSvgWrapper'
import NcInputField from '@nextcloud/vue/components/NcInputField'
import NcSettingsSection from '@nextcloud/vue/components/NcSettingsSection'

const url = getBaseUrl()

const copyIcon = ref(mdiContentCopy)
const pendingTimeout = ref(0)

/**
 * Copy the base URL to the clipboard
 */
function onCopyContent() {
	try {
		window.navigator.clipboard.writeText(url)
		showSuccess(t('firstrunwizard', 'URL copied'))
		// Reset pending resets
		if (pendingTimeout.value) {
			window.clearTimeout(pendingTimeout.value)
		}
		// Update the icon to check to show success
		copyIcon.value = mdiCheck
		pendingTimeout.value = window.setTimeout(() => {
			copyIcon.value = mdiContentCopy
		}, 3000)
	} catch {
		window.prompt(t('firstrunwizard', 'Could not copy the URL, please copy manually'), url)
	}
}
</script>

<style module>
.input {
	max-width: min(50vw, 450px) !important;
}
</style>
