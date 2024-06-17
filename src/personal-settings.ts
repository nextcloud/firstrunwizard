/**
 * SPDX-FileCopyrightText: 2024 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import Vue from 'vue'
import Settings from './views/Settings.vue'

const View = Vue.extend(Settings)
new View().$mount('#firstrunwizard-settings')
