<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

Route::get('/home', 'HomeController@index');

Route::get('/import', 'ImportExportController@import');

//BLADES
Route::get('/content', 'BladesController@contentIndex');

Route::get('/discussion', 'BladesController@discussion');

Route::get('/newSession', 'NewSessionController@index');

//NEW SESSION
Route::get('/lastSession', 'NewSessionController@lastSession');

Route::post('/startSession', 'NewSessionController@startSession');

Route::post('/curSession/{idSession}/', 'NewSessionController@newExercise');

Route::post('/endSession/{idSession}/', 'NewSessionController@endSession');

Route::get('/endSession_nov/{idSession}/', 'NewSessionController@end_session_no_view');
//SIMULATION

Route::get('/exercise_progress/{idExercise}','SimulationController@live_info');

Route::get('/script/{idExercise}&{sim}','SimulationController@script');

//SESSIONS

Route::get('/history/sessions', 'SessionsController@auth_sessions');

Route::get('/history/{idSession}/session', 'SessionsController@session');

Route::get('/students/{idUser}/sessions', 'SessionsController@sessions')->middleware('teacher');

Route::get('/students/{idSession}/session', 'SessionsController@session')->middleware('teacher');

Route::get('/progress/{idSession}', 'SessionsController@progress');

Route::get('/exercises/{id}', 'SessionsController@userExercises');

Route::get('/exercise_results/{id}', 'SessionsController@exercise');

//COMMENTS

Route::get('/comments', 'CommentsController@comments');

//TURMAS

Route::get('/turmas', 'TurmasController@turmas')->middleware('teacher');

Route::get('/turma/{idTurma}', 'TurmasController@studentsIndex')->middleware('teacher');

//OTHERS

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
