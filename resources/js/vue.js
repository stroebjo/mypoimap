import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */
const app = createApp({});

//import ExampleComponent from './components/ExampleComponent.vue';
//app.component('example-component', ExampleComponent);

import FilterComponent from './components/FilterComponent.vue';
app.component('filter-component', FilterComponent);

import FilterRowDate from './components/FilterRowDate.vue';
app.component('filterrow-date', FilterRowDate);

import FilterRowVisited from './components/FilterRowVisited.vue';
app.component('filterrow-visited', FilterRowVisited);

import FilterRowWkt from './components/FilterRowWkt.vue';
app.component('filterrow-wkt', FilterRowWkt);

import FilterRowPriority from './components/FilterRowPriority.vue';
app.component('filterrow-priority', FilterRowPriority);

import FilterRowTag from './components/FilterRowTag.vue';
app.component('filterrow-tag', FilterRowTag);

import FilterRowUnesco from './components/FilterRowUnesco.vue';
app.component('filterrow-unesco', FilterRowUnesco);

app.mount('#app');
