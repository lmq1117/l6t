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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/age','UserController@test');
Route::get('/redis/set/{key}/{value}','UserController@redisSet');
Route::get('/redis/get/{key}','UserController@redisGet');
Route::get('/queue','UserController@queue');
Route::get('/app/pipeline','UserController@pipeline');
Route::get('/user/page','UserController@page');
