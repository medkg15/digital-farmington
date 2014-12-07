<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'MapController@displayPublic');

Route::get('/admin', array('before' => 'auth','uses' => 'MapController@displayAdmin'));

Route::get('/login', array('uses' => 'LoginController@showLogin'));
Route::post('/login', array('uses' => 'LoginController@doLogin'));

Route::get('/logout', array('uses' => 'LoginController@doLogout'));