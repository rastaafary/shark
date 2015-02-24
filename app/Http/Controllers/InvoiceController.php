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
use Symfony\Component\HttpFoundation\File\UploadedFile;

class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addInvoice()
    {
        $post = Input::all();
        if (isset($post['_token'])) {
            unset($post['_token']);

            $rules = array(
                'comp_name' => 'required',                
                'building_no' => 'required',
                'street_addrs' => 'required',               
                'interior_no' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zipcode' => 'required',
                'phone_no' => 'required',
                'shpcomp_name' => 'required',
                'shpbuilding_no' => 'required',
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return redirect('/invoice/add')
                                ->withErrors($validator)
                                ->withInput(Input::all());
                //->with(array("shipping" => $shipping, $validator));
            }
        }
        $uid = Auth::user()->id;
        if (isset($uid) && $uid != null) {
            $PO = DB::table('purchase_order')->get();
            return View::make("invoice.addInvoice", ['page_title' => 'Add Invoice'])->with("po", $PO);
        }
    }

    public function listShipingInfo()
    {
        $id = Input::get('id');
        $cust_data = DB::table('purchase_order')
                ->select('customer_id')
                ->where('id', $id)
                ->first();

        $shipping_data = DB::table('shipping_info')
                ->select('identifier')
                ->where('customer_id', $cust_data->customer_id)
                ->get();
        return Response(json_encode($shipping_data));
    }

    public function listInvoice()
    {
        return view('invoice.listInvoice', ['page_title' => 'Invoice']);
    }

}
