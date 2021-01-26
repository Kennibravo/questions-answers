<?php

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

Route::group(['prefix' => 'admin'], function () {
    Route::post('login', 'AdminController@login');

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::group(['prefix' => 'questions'], function () {
            Route::post('/store', 'QuestionController@store')->name('questions.store');
            Route::get('{id}', 'QuestionController@show')->name('questions.show');
            Route::put('{id}/update', 'QuestionController@update')->name('questions.update');
        });
    });
});
