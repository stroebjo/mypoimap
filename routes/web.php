<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'PlaceController@map')->name('place.map');
Route::get('/table', 'PlaceController@index')->name('place.table');

Route::get('/home', 'HomeController@index')->name('home');


Route::resources([
    'place' => 'PlaceController'
]);

Route::get('/tags', 'PlaceController@tags')->name('tags.autocomplete');


Route::resources([
    'user_category' => 'UserCategoryController'
]);
