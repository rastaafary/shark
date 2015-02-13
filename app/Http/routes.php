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
Route::get('/invoice/view', 'InvoiceController@viewInvoice');
// Purchase Order Customer
Route::get('/po/add', 'PurchaseOrderCustomerController@addPurchaseOrder');
Route::get('/po', 'PurchaseOrderCustomerController@listPurchaseOrder');
Route::get('/po/view', 'PurchaseOrderCustomerController@viewPurchaseOrder');
/*Route::get('/customer/add', array('prefix' => 'customer','as' => 'customer.add',
    'uses' => 'Customer\customerController@addCustomer'));
 * 
 */
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

