/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import Vue from 'vue'
import PersonalSettings from './views/PersonalSettings.vue'

const View = Vue.extend(PersonalSettings)
new View().$mount('#firstrunwizard-settings')
