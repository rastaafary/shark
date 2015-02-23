<?php

namespace App\Http\Controllers;

class OrderStatusReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewReport()
    {
        return view('OrderStatusReport.OrderStatusReport', ['page_title' => "PL's"]);
    }

}
