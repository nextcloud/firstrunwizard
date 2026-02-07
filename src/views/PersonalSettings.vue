<!--
  - SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<script setup lang="ts">
import SettingsApps from '../components/settings/SettingsApps.vue'
import SettingsClients from '../components/settings/SettingsClients.vue'
import SettingsServer from '../components/settings/SettingsServer.vue'
</script>

<template>
	<SettingsClients />
	<SettingsApps />
	<SettingsServer />
</template>
