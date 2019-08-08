/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');



Vue.component('export', require('./components/ExportComponent.vue').default);

Vue.component('sp-connect', require('./components/SPConnectComponent.vue').default);

Vue.component('synсronization', require('./components/SynсronizationComponent.vue').default);
Vue.component('synс-item', require('./components/SyncItem.vue').default);

const app = new Vue({
    el: '#app',
});
