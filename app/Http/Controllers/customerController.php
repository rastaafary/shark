<?php
//namespace App\Http\Controllers\Customer;
namespace App\Http\Controllers;

class customerController extends Controller
{

    public function addCust()
    {
        return view('customer.addCustomer');
    }

}
