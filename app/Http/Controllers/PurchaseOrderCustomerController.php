<?php
//namespace App\Http\Controllers\Customer;
namespace App\Http\Controllers;

class PurchaseOrderCustomerController extends Controller
{

    public function addPurchaseOrder()
    {
        return view('PurchaseOrderCustomer.addPurchaseOrder',['page_title'=>'Add Purchase Order']);
    }
    
    public function listPurchaseOrder()
    {

        return view('PurchaseOrderCustomer.listPurchaseOrder',['page_title'=>'Purchase Order']);

    }
   
}