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

//Route::resource('users','UserController');

Route::get('/users', 'UserController@index')
    ->name('users.index');

Route::get('/users/{user}', 'UserController@show')
    ->where('user', '[0-9]+')
    ->name('users.show');

Route::get('/users/nuevo', 'UserController@create')->name('users.create');

Route::post('/users', 'UserController@store');

Route::get('/users/{user}/editar', 'UserController@edit')->name('users.edit');

Route::put('/users/{user}', 'UserController@update');

Route::patch('/users/{user}/papelera', 'UserController@trash')->name('users.trash');

Route::get('/users/{id}/restore', 'UserController@restore')->name('users.restore');

Route::get('/users/papelera', 'UserController@trashed')->name('users.trashed');

Route::delete('/users/{id}', 'UserController@destroy')->name('users.destroy');

//----

Route::resource('professions','ProfessionController'); 

//----
Route::resource('skills','SkillController'); 



