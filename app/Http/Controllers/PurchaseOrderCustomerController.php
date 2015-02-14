<?php
//namespace App\Http\Controllers\Customer;
namespace App\Http\Controllers;

class PurchaseOrderCustomerController extends Controller
{

    public function addPurchaseOrder()
    {
        return view('PurchaseOrderCustomer.addPurchaseOrder');
    }
    
    public function listPurchaseOrder()
    {
        return view('PurchaseOrderCustomer.listPurchaseOrder',['name'=>'Purchase Order']);
    }
   
}