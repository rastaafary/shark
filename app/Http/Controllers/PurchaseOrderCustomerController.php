<?php

//namespace App\Http\Controllers\Customer;

namespace App\Http\Controllers;

use Input;
use DB;
use View;

class PurchaseOrderCustomerController extends Controller
{

    public function userDetails($id = null)
    {
        $post = Input::all();
        if (isset($post['_token']))
            unset($post['_token']);
        if (isset($id)) {
            $cust = DB::table('customers')->where('user_id', $id)->first();
            return View::make('PurchaseOrderCustomer.addPurchaseOrder', ['page_title' => 'Add Purchase Order', 'id' => $id])->with('cust', $cust);
        }
        return view('PurchaseOrderCustomer.addPurchaseOrder', ['page_title' => 'Add Purchase Order']);
    }

    public function addPurchaseOrder()
    {
        return view('PurchaseOrderCustomer.addPurchaseOrder', ['page_title' => 'Add Purchase Order']);
    }

    public function listPurchaseOrder()
    {

        return view('PurchaseOrderCustomer.listPurchaseOrder', ['page_title' => 'Purchase Order']);
    }

}
