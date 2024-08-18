
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';

/**
 * Svelte components.
 *
 *
 */
import Filter from './components/Filter.svelte';

import $ from 'jquery'
window.jQuery = window.$ = $

import * as bootstrap from 'bootstrap'
window.bootstrap = bootstrap;

import DataTable from 'datatables.net-bs5';
window.DataTable = DataTable;

import './leaflet';
import './tagify';



import PhotoSwipeLightbox from  'photoswipe/lightbox';
window.PhotoSwipeLightbox = PhotoSwipeLightbox;

import PhotoSwipe from 'photoswipe';
window.PhotoSwipe = PhotoSwipe;

//require('./photoswipe');


// wrapper to dynamically load EasyMDE (~300kb js file!)
async function loadEasyMDE(config) {
    const easymdeModule = await import('easymde');
    const EasyMDE = easymdeModule.default;

    var editor = new EasyMDE({
        element: document.getElementById(config.id),
        shortcuts: {
            drawImage: null // don't overload DevTools shortcuts if EasyMDE has focus...
        },
        autoDownloadFontAwesome: false,
        promptURLs: true,
        status: false,
        spellChecker: false
    });
}
window.loadEasyMDE = loadEasyMDE;

