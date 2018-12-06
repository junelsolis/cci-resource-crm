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

Route::get('/', 'LoginController@showLogin');
Route::post('/login', 'LoginController@login');
Route::get('/logout', 'LoginController@logout');
Route::get('/dashboard', 'DashboardController@selectUserRole');
Route::get('/dashboard/set-password', 'DashboardController@showSetPassword');
Route::post('/dashboard/set-password', 'DashboardController@setPassword');

// administrator routes
Route::get('/admin', 'AdminController@showDashboard');
Route::post('/admin/user/add', 'AdminController@addUser');
Route::get('/admin/user/{id}',  'AdminController@viewUser');
Route::post('/admin/user/edit/{id}', 'AdminController@editUser');
Route::get('/admin/user/reset/{id}', 'AdminController@resetPassword');

// sales routes
Route::get('/inside-sales', 'InsideSalesController@showDashboard');

// executive routes
Route::get('/executive', 'ExecController@showDashboard');
