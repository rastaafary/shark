<?php

namespace App\Http\Controllers;

use File;
use Session;
use Input;
use DB;
use View;
use Validator;
use Datatables;
use Auth;
use Response;
use Request;
//use Illuminate\Http\Request;
use App\Http\Controllers\Image;
use Illuminate\Database\Query\Builder;

class PaymentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addPayment()
    {
        $uid = Auth::user()->id;
        if (isset($uid) && $uid != null) {
            $invoice_data = DB::table('invoice')->groupBy('invoice_no')->get();
            return View::make("payment.addPayment", ['page_title' => 'Add Payment'])->with("invoice", $invoice_data);
        }
        // return view('payment.addPayment', ['page_title' => 'Add Payment']);
    }

    public function listPayment()
    {
        return view('payment.listPayment', ['page_title' => 'Payment']);
    }

    public function viewPayment()
    {
        return view('payment.viewPayment', ['page_title' => 'View Payment']);
    }

    public function searchCustomer()
    {
        $c_name = Request::segment(4);
        $data = DB::table('customers')->select('contact_name')
                ->where('contact_name', 'like', $c_name . '%')
                ->get();
        return Response(json_encode($data));
    }

    public function getCustInvoice()
    {
       /* $custData = Input::get('custData');

        $c_name = Request::segment(4);
        $data = DB::table('customers')->select('contact_name')
                ->where('contact_name', 'like', $c_name . '%')
                ->get();
        return Response(json_encode($data));*/
    }

}
