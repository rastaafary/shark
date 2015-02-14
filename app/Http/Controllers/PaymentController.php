<?php

namespace App\Http\Controllers;

class PaymentController extends Controller
{

    public function addPayment()
    {
        return view('payment.addPayment');
    }

    public function listPayment()
    {
        return view('payment.listPayment');
    }

}
