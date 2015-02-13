<?php
//namespace App\Http\Controllers\Customer;
namespace App\Http\Controllers;

class InvoiceController extends Controller
{

    public function addInvoice()
    {
        return view('invoice.addInvoice');
    }
    
    public function listInvoice()
    {
        return view('invoice.listInvoice');
    }
    
    public function viewInvoice()
    {
        return view('invoice.viewInvoice');
    }

}