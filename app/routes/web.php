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
Route::get('/administrator', 'AdminController@showDashboard');
Route::post('/administrator/user/add', 'AdminController@addUser');
Route::get('/administrator/user/{id}',  'AdminController@viewUser');
Route::post('/administrator/user/edit/{id}', 'AdminController@editUser');
Route::get('/administrator/user/reset/{id}', 'AdminController@resetPassword');

// sales routes
Route::get('/sales', 'SalesController@showDashboard');
Route::post('/sales/project/add', 'SalesController@addProject');

// executive routes
Route::get('/executive', 'ExecController@showDashboard');
