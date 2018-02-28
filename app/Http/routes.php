<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::get('/', 'UserController@index');

Route::get('/{user}/notes', 'NoteController@index');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/{user}', 'UserController@update');
    Route::post('/users/{user}', 'UserController@destroy');

    Route::post('/{user}/notes', 'NoteController@store');

    Route::get('/{note}/edit', 'NoteController@edit');
    Route::post('/{note}/edit', 'NoteController@update');

    Route::post('/notes/{note}', 'NoteController@destroy');
});
