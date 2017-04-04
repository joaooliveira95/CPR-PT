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


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index');



Route::get('/newSession', 'NewSessionController@index');

Route::get('/newSession/{id}/', 'NewSessionController@newExercise');

//BLADES
Route::get('/content', 'BladesController@contentIndex');

Route::get('/history', 'BladesController@historyIndex');

Route::get('/students', 'BladesController@studentsIndex')->middleware('teacher');


//SESSIONS CONTROLLER
Route::get('/history/{id}/session', 'SessionsController@session');

Route::get('/students/{id}/sessions', 'SessionsController@sessions')->middleware('teacher');

Route::get('/students/{id}/session', 'SessionsController@session')->middleware('teacher');