<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');
// Login
Route::post('/login', 'LoginController@login');
//logout
Route::get('logout','LoginController@logout');
//get list of avilable part
Route::get('/part', 'PartController@partList');
//get part data
Route::get('/partdata', 'PartController@getPartData');
//edit part
Route::get('/part/edit/{var?}', 'PartController@editPart');
//add part
Route::get('/part/add', 'PartController@addPart');
//save edit part
Route::post('/part/edit', 'PartController@editPart');
//save add part
Route::post('/part/add', 'PartController@addPart');
//edit part
Route::get('/part/delete/{var?}', 'PartController@deletePart');
//Add Customer
Route::get('/customer/add', 'CustomerController@addCust');
//List Customer
Route::get('/customer/list', 'CustomerController@listCust');
// Invoice
Route::get('/invoice/add', 'InvoiceController@addInvoice');
Route::get('/invoice', 'InvoiceController@listInvoice');
// Purchase Order Customer
Route::get('/po/add', 'PurchaseOrderCustomerController@addPurchaseOrder');
Route::get('/po', 'PurchaseOrderCustomerController@listPurchaseOrder');
// Blog Art
Route::get('/blogArt', 'BlogartController@viewBlog');
// Payment
Route::get('/payment', 'PaymentController@listPayment');
Route::get('/payment/add', 'PaymentController@addPayment');
Route::get('/payment/view', 'PaymentController@viewPayment');
// Manage User
Route::get('/userList', 'ManageUserController@userList');
Route::post('/userList', 'ManageUserController@addUser');
Route::get('/userProfile', 'ManageUserController@userProfile');
//get edit User data
Route::get('/userProfile/edit/{var?}', 'ManageUserController@editUser');
//save edit User
Route::post('/userProfile/edit', 'ManageUserController@editUser');
// Delete User
Route::get('/userProfile/delete/{var?}', 'ManageUserController@deleteUser');
//View Order Status Report
Route::get('/PLReport/view', 'OrderStatusReportController@viewReport');
/* Route::get('/customer/add', array('prefix' => 'customer','as' => 'customer.add',
  'uses' => 'Customer\customerController@addCustomer'));
 * 
 */

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

