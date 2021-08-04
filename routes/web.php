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

Route::get('/settings', 'SettingsController@index')->name('settings.index');
Route::get('/settings/place_ids', 'SettingsController@place_ids')->name('settings.place_ids');
Route::post('/settings/place_ids', 'SettingsController@update_place_ids')->name('settings.update_place_ids');

Route::resources([
    'place'         => 'PlaceController',
    'journey'       => 'JourneyController',
    'user_category' => 'UserCategoryController',
    'filter'        => 'FilterController',
    'journey_entry' => 'JourneyEntryController',
    'visit'         => 'VisitController',
    'track'         => 'TrackController',
]);

Route::get('/kml', 'PlaceController@kml')->name('place.kml');
Route::get('/tags', 'PlaceController@tags')->name('tags.autocomplete');
Route::get('/map/{filter}', 'FilterController@map')->name('filter.map');

Route::get('/shared/map/{uuid}', 'FilterController@sharedmap')->name('filter.sahredmap');

Route::get('/shared/journey/{uuid}', 'SharedController@journey')->name('shared_journey.show');
Route::get('/shared/journey/{uuid}/gpx', 'SharedController@journey_gpx')->name('shared_journey.gpx');


Route::get('/journey/{journey}/gpx', 'JourneyController@gpx')->name('journey.gpx');
