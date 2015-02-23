<?php
//namespace App\Http\Controllers\Customer;
namespace App\Http\Controllers;

class InvoiceController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function addInvoice()
    {
        return view('invoice.addInvoice',['page_title'=>'Add Invoice']);
    }
    
    public function listInvoice()
    {
        return view('invoice.listInvoice',['page_title'=>'Invoice']);
    }    
}