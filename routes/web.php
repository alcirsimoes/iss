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
    if (Auth::check())
        return redirect('home');

    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('user/set_admin/{user}', 'UserController@setAdmin')->name('user.setAdmin');
Route::get('user/unset_admin/{user}', 'UserController@unsetAdmin')->name('user.unsetAdmin');
Route::get('user/set_supervisor/{user}', 'UserController@setSupervisor')->name('user.setSupervisor');
Route::get('user/unset_supervisor/{user}', 'UserController@unsetSupervisor')->name('user.unsetSupervisor');

Route::resource('user', 'UserController');
Route::resource('survey', 'SurveyController');
Route::resource('sample', 'SampleController');
Route::resource('subject', 'SubjectController');
Route::resource('question', 'QuestionController');

Route::get('f/{token?}', 'FormController@login')->name('form.login');

Route::get('form/{survey}/{subject?}', 'FormController@index')->name('form.index');

Route::post('form/current', 'FormController@current')->name('form.current');
Route::post('form/next', 'FormController@next')->name('form.next');
Route::post('form/previous', 'FormController@next')->name('form.previous');

Route::get('form/{survey}/{subject}', 'FormController@index')->name('form.create');
Route::post('form/{survey}/{subject}', 'FormController@store')->name('form.store');

Route::get('monitoring/{survey}', 'ReportController@index')->name('report.index');
Route::get('monitoring/{survey}/{sample}', 'ReportController@list')->name('report.list');
Route::get('monitoring/{survey}/{sample}/{subject}', 'ReportController@view')->name('report.view');
