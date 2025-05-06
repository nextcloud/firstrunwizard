/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { createApp } from 'vue'
import PersonalSettings from './views/PersonalSettings.vue'

const app = createApp(PersonalSettings)
app.mount('#firstrunwizard-settings')
