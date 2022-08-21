
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';


import $ from 'jquery'
window.jQuery = window.$ = $

import * as bootstrap from 'bootstrap'
window.bootstrap = bootstrap;

import DataTable from "datatables.net-bs5";
DataTable(window, window.$);

import './leaflet';
import './tagify';



import PhotoSwipeLightbox from  'photoswipe/lightbox';
window.PhotoSwipeLightbox = PhotoSwipeLightbox;

import PhotoSwipe from 'photoswipe';
window.PhotoSwipe = PhotoSwipe;

//require('./photoswipe');


