import Vue from 'vue'
import { generateFilePath } from '@nextcloud/router'

import App from './App.vue'
// eslint-disable-next-line
__webpack_public_path__ = generateFilePath('firstrunwizard', '', 'js/');

/* global t oc_defaults */
// bind to window
Vue.prototype.t = t
// eslint-disable-next-line
Vue.prototype.oc_defaults = oc_defaults

let el = document.createElement('div')
el.id = 'firstrunwizard'
document.querySelector('body').appendChild(el)

const app = new Vue({
	el: '#firstrunwizard',
	name: 'FirstRunWizardRoot',
	render: h => h(App)
})

window.OCA.FirstRunWizard = app.$children[0]
