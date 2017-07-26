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

Route::get('/import', 'ImportExportController@import');

//BLADES
Route::get('/home', 'BladesController@homeIndex');

Route::get('/content', 'MediaController@contentIndex');

Route::get('contentInfo', 'MediaController@contentInfo');


Route::get('/discussion', 'BladesController@discussionIndex');

Route::get('/newSession', 'BladesController@createSessionIndex');

Route::get('/history/{idUser}', 'BladesController@historyIndex');

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
Route::get('/progress/{idSession}', 'SessionsController@progress');

Route::get('/sessions/{idUser}', 'SessionsController@sessions');

Route::get('/sessions/session/{idSession}', 'SessionsController@session');


Route::get('/exercises/{id}', 'SessionsController@userExercises');

Route::get('/exercise_results/{id}', 'SessionsController@exercise');

//COMMENTS

//Route::get('/comments', 'CommentsController@comments');

//TURMAS

Route::get('/turmas', 'TurmasController@turmas')->middleware('teacher');

Route::get('/turma/{idTurma}', 'TurmasController@studentsIndex')->middleware('teacher');

//OTHERS

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');
