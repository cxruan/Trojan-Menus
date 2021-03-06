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
// Route::get('/test','MainController@test');

Route::get('/projects/trojan-menus','MainController@index');

Route::post('/projects/trojan-menus/search_by_name','MainController@json_search_by_name')->name("search_by_name");

Route::post('/projects/trojan-menus/search_by_tags','MainController@json_search_by_tags')->name("search_by_tags");
