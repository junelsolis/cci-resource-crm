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

// inside sales routes
Route::get('/inside-sales', 'InsideSalesController@showDashboard');

// product sales routes
Route::get('/product-sales', 'ProductSalesController@showDashboard');
Route::post('/product-sales/project/add', 'ProductSalesController@addProject');

// executive routes
Route::get('/executive', 'ExecController@showDashboard');

// project routes
Route::post('/project/add', 'ProjectController@addProject');
Route::post('/project/edit/name', 'ProjectController@editName');
Route::post('/project/edit/status', 'ProjectController@editStatus');
Route::post('/project/edit/bid-date', 'ProjectController@editBidDate');
Route::post('/project/edit/manufacturer', 'ProjectController@editManufacturer');
Route::post('/project/edit/product', 'ProjectController@editProduct');
Route::post('/project/edit/inside-sales', 'ProjectController@editInsideSales');
Route::post('/project/edit/amount', 'ProjectController@editAmount');
Route::post('/project/edit/apc-opp-id', 'ProjectController@editApcOppId');
Route::post('/project/edit/quote', 'ProjectController@editQuote');
Route::post('/project/edit/engineer', 'ProjectController@editEngineer');
Route::post('/project/edit/contractor', 'ProjectController@editContractor');

// note routes
Route::post('/note/add/{project_id}', 'NoteController@addNote');
