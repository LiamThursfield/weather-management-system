<?php

use App\Http\Controllers\Api\CitiesController;
use App\Http\Controllers\Api\CMS\PageController;
use App\Http\Controllers\Api\CRM\FormSubmissionController;
use App\Http\Controllers\Api\WeatherByCityNameController;
use App\Http\Controllers\Api\WeatherByLatLonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


/**
 * API routes we want to restrict to our domain(s)
 * e.g. calls to paid for services
 */
Route::group([
     'middleware' => 'restrict-by-domain',
], function() {
    Route::group([
        'prefix' => 'weather',
        'as' => 'weather.',
    ], function() {
        Route::get('/by-lat-lon', WeatherByLatLonController::class)->name('by-lat-lon');
        Route::get('/by-city-name', WeatherByCityNameController::class)->name('by-city-name');
    });

    Route::group([
        'prefix' => 'cities',
        'as' => 'cities.',
    ], function() {
        Route::get('/', CitiesController::class)->name('invoke');
    });
});