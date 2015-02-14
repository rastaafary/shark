<?php

namespace App\Http\Controllers;

class OrderStatusReportController extends Controller
{

    public function viewReport()
    {
        return view('OrderStatusReport.OrderStatusReport');
    }
}
