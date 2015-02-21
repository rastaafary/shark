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
Route::group(['middleware' => 'auth'], function() {
    Route::get('/part', 'PartController@partList');
});
//logout
Route::get('logout', 'LoginController@logout');
Route::get('/forgotpassword', 'LoginController@forgotPassword');
Route::post('/forgotpassword', 'LoginController@forgotPassword');
Route::get('/resetpassword', 'LoginController@resetPassword');
Route::post('/resetpassword', 'LoginController@resetPassword');
//get list of avilable part
//Route::get('/part', 'PartController@partList');
//get part data
Route::get('/partdata', 'PartController@getPartData');
//edit part
Route::get('/part/edit/{var?}', 'PartController@editPart');
//add part
Route::get('/part/add', 'PartController@addPart');
//save edit part
Route::get('/part/edit/{var?}', 'PartController@editPart');
Route::post('/part/edit/{var?}', 'PartController@editPart');
//save add part
Route::post('/part/add', 'PartController@addPart');
//edit part
Route::get('/part/delete/{var?}', 'PartController@deletePart');
//Add Customer
Route::get('/customer', 'CustomerController@listCust');
Route::get('/customer/add', 'CustomerController@addCust');
Route::post('/customer/add', 'CustomerController@addCust');
Route::get('/customer/edit/{var?}', 'CustomerController@editCust');
Route::post('/customer/edit/{var?}', 'CustomerController@editCust');
Route::get('/customer/delete/{var?}', 'CustomerController@deleteCust');
Route::get('/customerdata', 'CustomerController@getCustData');
// Invoice
Route::get('/invoice/add', 'InvoiceController@addInvoice');
Route::get('/invoice', 'InvoiceController@listInvoice');
// Purchase Order Customer
Route::get('/po/add', 'PurchaseOrderCustomerController@addPurchaseOrder');
Route::get('/po', 'PurchaseOrderCustomerController@listPurchaseOrder');
Route::get('/po/add/{var?}', 'PurchaseOrderCustomerController@addPurchaseOrder');
Route::post('/po/add/{var?}', 'PurchaseOrderCustomerController@addPurchaseOrder');

//when Customer Login
Route::get('/po/add/{var?}', 'PurchaseOrderCustomerController@userDetails');

// Blog Art
Route::get('/blogArt', 'BlogartController@viewBlog');
// Payment
Route::get('/payment', 'PaymentController@listPayment');
Route::get('/payment/add', 'PaymentController@addPayment');
Route::get('/payment/view', 'PaymentController@viewPayment');
// Manage User
Route::get('/userList', 'ManageUserController@userList');
Route::get('/userList/add', 'ManageUserController@addUser');
Route::post('/userList/add', 'ManageUserController@addUser');
Route::get('/userList/delete/{var?}', 'ManageUserController@deleteUser');
Route::get('/userList/edit/{var?}', 'ManageUserController@editUser');
Route::post('/userList/edit/{var?}', 'ManageUserController@editUser');
Route::get('/userProfile', 'ManageUserController@userProfile');
//get edit User data
Route::get('/userProfile/edit/{var?}', 'ManageUserController@editUser');
//save edit User
Route::post('/userProfile/edit', 'ManageUserController@editUser');
Route::get('/userdata', 'ManageUserController@getUserData');
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

