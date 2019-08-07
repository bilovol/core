/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');



Vue.component('export', require('./components/export/ExportComponent.vue').default);

Vue.component('connect', require('./components/connect/ConnectComponent.vue').default);
Vue.component('first-connect', require('./components/connect/FirstConnect.vue').default);

Vue.component('synсronization', require('./components/syncronization/SynсronizationComponent.vue').default);
Vue.component('synс-item', require('./components/syncronization/SyncItem.vue').default);

const app = new Vue({
    el: '#app',
});
