<?php

use App\Http\Controllers\PlaceController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\UserCategoryController;
use App\Http\Controllers\JourneyEntryController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\SharedController;

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

Route::get('/', [PlaceController::class, 'map'])->name('place.map');

Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::get('/settings/place_ids', [SettingsController::class, 'place_ids'])->name('settings.place_ids');
Route::post('/settings/place_ids', [SettingsController::class, 'update_place_ids'])->name('settings.update_place_ids');

Route::resources([
    'place'         => PlaceController::class,
    'journey'       => JourneyController::class,
    'user_category' => UserCategoryController::class,
    'filter'        => FilterController::class,
    'journey_entry' => JourneyEntryController::class,
    'visit'         => VisitController::class,
    'track'         => TrackController::class,
]);

Route::get('/kml', [PlaceController::class, 'kml'])->name('place.kml');
Route::get('/geojson', [PlaceController::class, 'geojson'])->name('place.geojson');
Route::get('/tags', [PlaceController::class, 'tags'])->name('tags.autocomplete');
Route::get('/map/{filter}', [FilterController::class, 'map'])->name('filter.map');

Route::get('/shared/map/{uuid}', [FilterController::class, 'sharedmap'])->name('filter.sahredmap');

Route::get('/shared/journey/{uuid}', [SharedController::class, 'journey'])->name('shared_journey.show');
Route::get('/shared/journey/{uuid}/gpx', [SharedController::class, 'journey_gpx'])->name('shared_journey.gpx');


Route::get('/journey/{journey}/gpx', [JourneyController::class, 'gpx'])->name('journey.gpx');
