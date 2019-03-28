
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('filter-component', require('./components/FilterComponent.vue').default);
Vue.component('filterrow-date', require('./components/FilterRowDate.vue').default);
Vue.component('filterrow-visited', require('./components/FilterRowVisited.vue').default);
Vue.component('filterrow-wkt', require('./components/FilterRowWkt.vue').default);
Vue.component('filterrow-priority', require('./components/FilterRowPriority.vue').default);
Vue.component('filterrow-tag', require('./components/FilterRowTag.vue').default);
Vue.component('filterrow-unesco', require('./components/FilterRowUnesco.vue').default);

Vue.config.ignoredElements = ['tags'];

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

require('./tagify');

require('./photoswipe');




require('./leaflet');

