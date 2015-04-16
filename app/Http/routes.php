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

Route::filter('invoice', function() {
    //var_dump(!Entrust::can('list-invoice', 'add-invoice'));
    if (!Entrust::can(array('list-invoice', 'add-invoice', 'edit-invoice', 'delete-invoice'))) {
        return view('accessDenied');
    }
});
Route::filter('payment', function() {
    if (!Entrust::can(array('list-payment', 'add-payment', 'edit-payment', 'delete-payment', 'view-payment'))) {
        return view('accessDenied');
    }
});
Route::filter('pl', function() {
    if (!Entrust::can(array('list-pl', 'add-pl', 'edit-pl', 'delete-pl'))) {
        return view('accessDenied');
    }
});
Route::filter('user', function() {
    if (!Entrust::can(array('list-user', 'add-user', 'edit-user', 'delete-user'))) {
        return view('accessDenied');
    }
});
Route::filter('part', function() {
    if (!Entrust::can(array('list-partNumber', 'add-partNumber', 'edit-partNumber', 'delete-partNumber'))) {
        return view('accessDenied');
    }
});
Route::filter('customer', function() {
    if (!Entrust::can(array('list-customer', 'add-customer', 'edit-customer', 'delete-customer'))) {
        return view('accessDenied');
    }
});

//Roles
Route::get('permissionCreate', 'PermissionController@createPermission');
Route::when('userList*', 'user');
Route::when('part*', 'part');
Route::when('customer*', 'customer');
Route::when('invoice*', 'invoice');
Route::when('payment*', 'payment');
Route::when('PLReport*', 'pl');
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
// BOM
Route::get('/part/{var?}/bom', 'BOMController@listBOM');
Route::get('/part/{var?}/bom/add', 'BOMController@addBOM');
Route::post('/part/{var?}/bom/add', 'BOMController@addBOM');
Route::get('/part/{var?}/edit/{var1?}', 'BOMController@editBOM');
Route::post('/part/{var?}/edit/{var1?}', 'BOMController@editBOM');
Route::get('/part/{var?}/delete/{var1?}', 'BOMController@deleteBOM');
Route::get('/part/getskudescription', 'BOMController@getSKUDescription');
Route::get('/partbomdata', 'BOMController@getBOMData');
Route::get('/part/bom/searchRawMaterial/{var?}', 'BOMController@getRawMaterial');
Route::get('/part/bom/rawMaterialDescription', 'BOMController@getRawMaterialDescription');

// Invoice
Route::get('/invoice/add', 'InvoiceController@addInvoice');
Route::post('/invoice/add', 'InvoiceController@addInvoice');

Route::get('/invoice/delete/{var?}', 'InvoiceController@deleteInvoice');

Route::get('/invoice/edit/{var?}', 'InvoiceController@editInvoice');
Route::post('/invoice/edit/{var?}', 'InvoiceController@editInvoice');

Route::get('/invoice', 'InvoiceController@listInvoice');
Route::get('/invoice/listShipingInfo', 'InvoiceController@listShipingInfo');
Route::get('/invoice/listSKU', 'InvoiceController@listSKU');
Route::get('/invoice/paymentTerm', 'InvoiceController@paymentTerm');
Route::get('/invoice/dispSKUdata', 'InvoiceController@dispSKUdata');
Route::get('/invoice/getInvoiceList', 'InvoiceController@getInvoiceList');
//BOM
Route::get('/part/{var?}/bom', 'BOMController@listBOM');
Route::get('/part/{var?}/bom/add', 'BOMController@addBOM');
Route::post('/part/{var?}/bom/add', 'BOMController@addBOM');
Route::get('/part/{var?}/bom/bomData', 'PartController@listBOM');
Route::get('/part/{var?}/bom/edit/{var1?}', 'BOMController@editBOM');
Route::post('/part/{var?}/bom/edit/{var1?}', 'BOMController@editBOM');
Route::get('/part/{var?}/bom/delete/{var1?}', 'BOMController@deleteBOM');
Route::get('/getBomList/{var?}', 'BOMController@getBomList');
Route::get('/part/getskudescription', 'BOMController@getSKUDescription');
Route::get('/part/bom/searchRawMaterial/{var?}', 'BOMController@getRawMaterial');
Route::get('/part/bom/rawMaterialDescription', 'BOMController@getRawMaterialDescription');

// Purchase Order Customer
Route::get('/po/add', 'PurchaseOrderCustomerController@addPurchaseOrder');
Route::post('/po/add', 'PurchaseOrderCustomerController@addPurchaseOrder');
Route::get('/po', 'PurchaseOrderCustomerController@listPurchaseOrder');


Route::post('/po/edit/{var?}', 'PurchaseOrderCustomerController@editPurchaseOrder');
Route::get('/po/edit/{var?}', 'PurchaseOrderCustomerController@editPurchaseOrder');
Route::get('/po/add/searchSKU/{var?}', 'PurchaseOrderCustomerController@searchSKU');
Route::get('/po/getDescription', 'PurchaseOrderCustomerController@getDescription');
Route::get('/po/add/searchDiscription/{var?}', 'PurchaseOrderCustomerController@searchDiscription');
Route::post('/po/add/order', 'PurchaseOrderCustomerController@addOrder');
//when Customer Login
Route::get('/po/add/{var?}', 'PurchaseOrderCustomerController@userDetails');
Route::get('/po/getorderlist', 'PurchaseOrderCustomerController@getorderlist');
Route::get('/po/geteditorderlist', 'PurchaseOrderCustomerController@geteditorderlist');
Route::post('/po/editorder', 'PurchaseOrderCustomerController@editpoCustomer');
Route::get('/po/deletepoCustomer/{var?}', 'PurchaseOrderCustomerController@deletepoCustomer');
Route::get('/po/getPoCustomerlist', 'PurchaseOrderCustomerController@getPoCustomerlist');
Route::get('/po/getIdentifireList', 'PurchaseOrderCustomerController@getIdentifireList');
// Blog Art
Route::get('/blogArt/{var?}', 'BlogartController@index');
Route::post('/blogArt/{var?}', 'BlogartController@index');
// Payment
Route::get('/payment', 'PaymentController@listPayment');
Route::get('/payment/add', 'PaymentController@addPayment');
Route::post('/payment/add', 'PaymentController@addPayment');
Route::get('/payment/view/{var?}', 'PaymentController@viewPayment');
Route::post('/payment/view/{var?}', 'PaymentController@viewPayment');
Route::get('/payment/searchCustomer/{var?}', 'PaymentController@searchCustomer');
Route::get('/payment/getCustInvoice', 'PaymentController@getCustInvoice');
Route::get('/payment/getInvoicePaymentDetails', 'PaymentController@getInvoicePaymentDetails');
Route::get('/payment/getPaymentList', 'PaymentController@getPaymentList');
Route::get('/payment/delete/{var?}', 'PaymentController@deletePayment');
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
Route::get('/PLReport/orderlist/{var?}', 'OrderStatusReportController@orderList');
Route::get('/PLReport/changePlValues', 'OrderStatusReportController@changePlValues');
//changeSequence
Route::get('/PLReport/changeSequence', 'OrderStatusReportController@changeSequence');
Route::get('/PLReport/addPcsMade', 'OrderStatusReportController@addPcsMade');
Route::get('/PLReport/getPcsMadeDetails', 'OrderStatusReportController@getPcsMadeDetails');
Route::get('/PLReport/deletePcsMade', 'OrderStatusReportController@deletePcsMade');
Route::get('/PLReport/reOrderData', 'OrderStatusReportController@reOrderData');

//raw material
Route::get('/RawMaterial/add', 'RawMaterialController@addRawMaterial');
Route::post('/RawMaterial/add', 'RawMaterialController@addRawMaterial');
Route::get('/RawMaterial', 'RawMaterialController@listRawMaterial');

//edit raw material
Route::get('/RawMaterial/edit/{var?}', 'RawMaterialController@editRawMaterial');
Route::post('/RawMaterial/edit/{var?}', 'RawMaterialController@editRawMaterial');

//get part data
Route::get('/RawMaterialdata', 'RawMaterialController@getRawMaterialData');


/* Route::get('/customer/add', array('prefix' => 'customer','as' => 'customer.add',
  'uses' => 'Customer\customerController@addCustomer'));
 * 
 */


Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

