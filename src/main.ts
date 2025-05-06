/**
 * SPDX-FileCopyrightText: 2020 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { translate, translatePlural } from '@nextcloud/l10n'
import Vue from 'vue'
import App from './views/App.vue'

Vue.prototype.t = translate
Vue.prototype.n = translatePlural

const el = document.createElement('div')
el.id = 'firstrunwizard'
document.querySelector('body')!.appendChild(el)

const View = Vue.extend(App)
const vm = new View().$mount(el)

export const open = vm.open
