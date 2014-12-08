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
Route::get('/admin/category', array('before' => 'auth','uses' => 'CategoryController@show'));
Route::post('/admin/category', array('before' => 'auth','uses' => 'CategoryController@save'));
Route::get('/admin/list', array('before' => 'auth','uses' => 'ListController@showList'));
Route::get('admin/poi', array('before' => 'auth', 'uses' => 'PointOfInterestController@showEdit'));
Route::get('admin/poi/{id}', array('before' => 'auth', 'uses' => 'PointOfInterestController@showEdit'));
Route::post('admin/poi/{id}', array('before' => 'auth', 'uses' => 'PointOfInterestController@save'));

Route::get('/login', array('uses' => 'LoginController@showLogin'));
Route::post('/login', array('uses' => 'LoginController@doLogin'));

Route::get('/logout', array('uses' => 'LoginController@doLogout'));