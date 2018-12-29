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
Route::post('/change-password','LoginController@changePassword');

// administrator routes
Route::get('/admin', 'AdminController@showDashboard');
Route::post('/admin/user/add', 'AdminController@addUser');
Route::get('/admin/user/{id}',  'AdminController@viewUser');
Route::post('/admin/user/edit/{id}', 'AdminController@editUser');
Route::post('/admin/user/reset/{id}', 'AdminController@resetPassword');

// inside sales routes
Route::get('/inside-sales', 'InsideSalesController@showDashboard');
Route::get('/inside-sales/people/{id?}','InsideSalesController@showPeople');
Route::get('/inside-sales/project/{id}','InsideSalesController@showProject');

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
Route::post('/project/edit/product-sales', 'ProjectController@editProductSales');
Route::post('/project/edit/inside-sales', 'ProjectController@editInsideSales');
Route::post('/project/edit/amount', 'ProjectController@editAmount');
Route::post('/project/edit/apc-opp-id', 'ProjectController@editApcOppId');
Route::post('/project/edit/quote', 'ProjectController@editQuote');
Route::post('/project/edit/engineer', 'ProjectController@editEngineer');
Route::post('/project/edit/contractor', 'ProjectController@editContractor');

// note routes
Route::post('/note/add/{project_id}', 'NoteController@addNote');
Route::post('/note/edit/{id}', 'NoteController@editNote');
Route::get('/note/delete/{id}', 'NoteController@deleteNote');

// user routes
Route::post('/user/edit/name', 'UserController@editName');
Route::post('/user/edit/username', 'UserController@editUsername');
Route::post('/user/edit/roles', 'UserController@editRoles');
