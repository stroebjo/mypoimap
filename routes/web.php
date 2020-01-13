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


/**
 * Registration is disabled. Use first line and comment out second line to enable.
 *
 */
//Auth::routes();
Auth::routes(['register' => false]);

Route::get('/', 'PlaceController@map')->name('place.map');

Route::resources([
    'place'         => 'PlaceController',
    'journey'       => 'JourneyController',
    'user_category' => 'UserCategoryController',
    'filter'        => 'FilterController'
]);

Route::get('/kml', 'PlaceController@kml')->name('place.kml');
Route::get('/tags', 'PlaceController@tags')->name('tags.autocomplete');
Route::get('/map/{filter}', 'FilterController@map')->name('filter.map');

Route::get('/shared/map/{uuid}', 'FilterController@sharedmap')->name('filter.sahredmap');
Route::get('/shared/journey/{uuid}', 'SharedController@journey')->name('shared.journey');
