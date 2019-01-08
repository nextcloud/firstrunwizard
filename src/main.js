import Vue from 'vue';
import { generateFilePath } from 'nextcloud-server/dist/router'
__webpack_public_path__ = generateFilePath('firstrunwizard', '', 'js/')

import App from './App.vue';



/* global t */
// bind to window
Vue.prototype.OC = OC;
Vue.prototype.t = t;
Vue.prototype.oc_defaults = oc_defaults;


let el = document.createElement('div');
el.id = 'firstrunwizard'
document.querySelector('body').appendChild(el);

const app = new Vue({
	el: '#firstrunwizard',
	render: h => h(App)
});

window.OCA.FirstRunWizard = app.$children[0];
