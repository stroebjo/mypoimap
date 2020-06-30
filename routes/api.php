<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Get your access token
Route::post('/login', 'API\AuthController@login');

// remember to to set `Accept: application/json` header to actual get these routes.
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('places', 'API\PlaceController');
});


