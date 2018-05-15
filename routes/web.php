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
})->name('welcome');

Route::get('/register', 'RegistrationController@index')->name('register');
Route::post('/register', 'RegistrationController@store');

Route::get('/login', 'SessionsController@index')->name('login');
Route::post('/login', 'SessionsController@store');

Route::get('/logout', 'SessionsController@destroy')->name('logout');

Route::get('/home', 'DashboardController@index')->name('home');

Route::get('/download', 'DashboardController@download')->name('download');

Route::get('/programs/{program_id}', 'ProgramController@index');
Route::post('/programs/create', 'ProgramController@store');
Route::post('/programs/{program_id}/license/create', 'LicenseController@store');
Route::post('/programs/{program_id}/license/{license_id}/delete', 'LicenseController@delete');
Route::post('/programs/{program_id}/users/{user_id}/delete', 'ProgramUserController@delete');
Route::post('/programs/users/transfer', 'ProgramController@transfer');
Route::post('/porgrams/{program_id}/suspend', 'ProgramController@suspend');

Route::get('/settings', 'SettingsController@index');
Route::post('/settings/save', 'SettingsController@update');

/* API ROUTES */
Route::post('/api/login', 'ApiController@login'); // Login WORKS
Route::post('/api/register', 'ApiController@register'); // Register 
Route::get('/api/user', 'ApiController@grabUser'); // Get user info WORKS
Route::get('/api/license/{license_id}', 'ApiController@grabLicense'); // Get license info such as used, program_id etc.
Route::get('/api/program/{program_id}', 'ApiController@grabProgram'); // Get program info UNRELEASED
Route::post('/api/authenticate', 'ApiController@authenticate'); // Authenticate a token WORKS
Route::post('/api/checksession', 'ApiController@check'); // Authenticate a token WORKS
Route::get('/api/user/{user_id}/fields', 'ApiController@getFields'); // Get a user field WORKS
Route::get('/api/user/{user_id}/field/{field_name}', 'ApiController@getField'); // Get a user field WORKS

