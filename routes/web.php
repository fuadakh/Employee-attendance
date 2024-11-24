<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth
Route::get('/register', 'App\Http\Controllers\AuthController@register_page')->name('register_page');
Route::get('/login', 'App\Http\Controllers\AuthController@login_page')->name('login_page');
Route::post('/register', 'App\Http\Controllers\AuthController@register')->name('register');
Route::post('/login', 'App\Http\Controllers\AuthController@login')->name('login');

Route::get('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

Route::name('attendance')
    ->middleware('auth.api')
    ->group(
        function () {
            // Dashboard
            Route::get('/', 'App\Http\Controllers\EmployeeController@index')->name('dashboard');

            // Employee
            Route::group(['prefix' => 'employee'], function () {
                Route::get('/', 'App\Http\Controllers\EmployeeController@index')->name('employee-view');
                Route::get('/add', 'App\Http\Controllers\EmployeeController@add')->name('employee-add');
                Route::post('/proccessadd', 'App\Http\Controllers\EmployeeController@proccessadd')->name('employee-proccessadd');
                Route::get('/{employee}', 'App\Http\Controllers\EmployeeController@edit')->name('employee-edit');
                Route::post('/proccessedit/{employee}', 'App\Http\Controllers\EmployeeController@proccessedit')->name('employee-proccessedit');
                Route::get('/delete/{employee}', 'App\Http\Controllers\EmployeeController@delete')->name('employee-delete');
            });
            
            // User
            Route::group(['prefix' => 'user'], function () {
                Route::get('/', 'App\Http\Controllers\UserController@index')->name('user-view');
                Route::get('/{employee}', 'App\Http\Controllers\UserController@edit')->name('user-edit');
                Route::post('/proccessedit/{employee}', 'App\Http\Controllers\UserController@proccessedit')->name('user-proccessedit');
                Route::get('/status/{user}/{status}', 'App\Http\Controllers\UserController@updateStatus')->name('user-status');
            });
        }
    );