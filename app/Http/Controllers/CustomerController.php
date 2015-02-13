<?php

//namespace App\Http\Controllers\Customer;

namespace App\Http\Controllers;

class CustomerController extends Controller
{

    public function addCust()
    {
        return view('customer.addCustomer');
    }

    public function listCust()
    {
        return view('customer.listCustomer');
    }

}
