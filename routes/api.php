<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();
});

Route::prefix('v1')->namespace('App\\Http\\Controllers\\Api')->group(function () {

    Route::name('login.')->namespace('Auth')->group(function () {

        Route::post('login', 'LoginJwtController@login')->name('login.login');
        Route::get('logout', 'LoginJwtController@logout')->name('login.logout');
        Route::get('refresh', 'LoginJwtController@refresh')->name('login.refresh');
    });

    Route::get('search', 'RealStateSearchController@index')->name('search');

    Route::get('search/{real_state_id}', 'RealStateSearchController@show')->name('search_single');

    Route::group(['middleware' => 'jwt.auth'], function () {
        
        Route::name('real_states.')->group(function () {

            Route::resource('real-states', 'RealStateController');
        });
    
        Route::name('users.')->group(function () {
    
            Route::resource('users', 'UserController');
        });
    
        Route::name('categories.')->group(function () {
    
            Route::resource('categories', 'CategoryController');
            Route::get('categories/{category}/real-states ', 'CategoryController@realState')->name('categories.real-state');
        });
    
        Route::name('photos.')->prefix('photos')->group(function () {
    
            Route::delete('/{photoId}', 'RealStatePhotoController@remove')->name('photos.delete');
            Route::put('/set-thumb/{photoId}/{realStateId}', 'RealStatePhotoController@setThumb')->name('photos.set-thumb');
        });
    });
});
