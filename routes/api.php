<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your Module. These routes
| are loaded by the module's RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['api'], 'namespace' => 'DevForIslam\QuranApi\Http\Controllers', 'prefix' => 'api'], function() {
    Route::get('surah', 'SurahController@index');
    Route::get('surah/all', 'SurahController@all');
    Route::get('surah/{surah}', 'SurahController@show');
    Route::get('language', 'LanguageController@index');
    Route::get('pdf/{file}', 'QuranController@index');
    Route::get('tags', 'TagController@index');
    Route::post('tag-item', 'TagController@add');
    Route::post('untag-item', 'TagController@remove');
    Route::get('favorites', 'FavoriteController@index')->middleware('auth:api');
    Route::post('favorites', 'FavoriteController@store')->middleware('auth:api');

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('login', 'ApiLoginController@login');
    Route::post('register-user', 'ApiLoginController@register');
    
});