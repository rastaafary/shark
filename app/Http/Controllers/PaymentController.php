<?php

namespace App\Http\Controllers;

class PaymentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addPayment()
    {
        return view('payment.addPayment', ['page_title' => 'Add Payment']);
    }

    public function listPayment()
    {
        return view('payment.listPayment', ['page_title' => 'Payment']);
    }

    public function viewPayment()
    {
        return view('payment.viewPayment', ['page_title' => 'View Payment']);
    }

}
