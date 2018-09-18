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

Route::get('/to-do-list', 'ToDoListController@tasks');
Route::post('/to-do-create', 'ToDoListController@create'); //ajax for to-do-list
Route::post('/to-do-delete', 'ToDoListController@delete'); //ajax for to-do-list
Route::post('/to-do-done', 'ToDoListController@done'); //ajax for to-do-list


