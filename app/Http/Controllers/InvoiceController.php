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
             

            $dt = date('Y-m-d');
            $my_date = date('m/d/Y', strtotime($dt));
            $time = strtotime($my_date);
            $Date = date('Y/m/d', $time);

            // $data = concat(concat(lpad(Convert(purchase_order.customer_id,char(4)),4,'0'),'-'),lpad(Convert(purchase_order.id,char(5)),5,'0'));

            if (isset($post['addNew'])) {

                //Get Customer ID
                $customer = DB::table('purchase_order')->where('id', $post['selectPO'])->first();

                // Add New Shipping Information
                $shp_info = DB::table('shipping_info')->insert(
                        array('customer_id' => $customer->customer_id,
                            'comp_name' => $post['shpcomp_name'],
                            'building_no' => $post['shpbuilding_no'],
                            'street_addrs' => $post['shpstreet_addrs'],
                            'interior_no' => $post['shpinterior_no'],
                            'city' => $post['shpcity'],
                            'state' => $post['shpstate'],
                            'zipcode' => $post['shpzipcode'],
                            'country' => $post['shpcountry'],
                            'phone_no' => $post['shpphone_no'],
                            'identifier' => $post['shpidentifer'],
                            'type' => $post['shippingMethod'],
                            'date' => $Date,
                            'invoice_id' => '',
                            'created_by' => $post['user_id']
                ));
            } else {
                //Get Customer ID
                $customer_data = DB::table('purchase_order')->where('id', $post['selectPO'])->first();
                $customer = DB::table('shipping_info')
                        ->where('customer_id', $customer_data->customer_id)
                        ->where('identifier', $post['oldShippingInfo'])
                        ->first();

                // Add Old Shipping Information
                $shp_info = DB::table('shipping_info')->insert(
                        array('customer_id' => $customer->customer_id,
                            'comp_name' => $customer->comp_name,
                            'building_no' => $customer->building_no,
                            'street_addrs' => $customer->street_addrs,
                            'interior_no' => $customer->interior_no,
                            'city' => $customer->city,
                            'state' => $customer->state,
                            'zipcode' => $customer->zipcode,
                            'country' => $customer->country,
                            'phone_no' => $customer->phone_no,
                            'identifier' => $customer->identifier,
                            'type' => $post['shippingMethod'],
                            'date' => $Date,
                            'invoice_id' => '',
                            'created_by' => $post['user_id']
                ));
            }

            $customer = DB::table('purchase_order')->where('id', $post['selectPO'])->first();
            $last_Shp_id = DB::table('shipping_info')->where('customer_id', $customer->customer_id)->orderBy('id', 'desc')->first();

            $billing_info = DB::table('invoice')->insert(
                    array('invoice_no' => '',
                        'po_id' => $post['selectPO'],
                        'shipping_id' => $last_Shp_id->id,
                        'comp_name' => $post['shpcomp_name'],
                        'building_no' => $post['shpbuilding_no'],
                        'street_addrs' => $post['shpstreet_addrs'],
                        'interior_no' => $post['shpinterior_no'],
                        'city' => $post['shpcity'],
                        'state' => $post['shpstate'],
                        'zipcode' => $post['shpzipcode'],
                        'country' => $post['shpcountry'],
                        'phone_no' => $post['shpphone_no']                       
            ));
            $invoice_no = '';
            $inc_id = DB::table('invoice')->orderBy('id', 'desc')->first();
            if ($inc_id == null) {
                $inc_id = 1;
                $inv_ID = str_pad($inc_id, 4, '0', STR_PAD_LEFT);
                $invoice_no = 'IN' . $inv_ID;
            } else {
                $id = $inc_id->id;               
                $inv_ID = str_pad($id, 4, '0', STR_PAD_LEFT);
                $invoice_no = 'IN' . $inv_ID;
            }
            DB::table('invoice')
                    ->where('po_id', $post['selectPO'])
                    ->where('shipping_id', $last_Shp_id->id)
                    ->update(array('invoice_no' => $invoice_no));         
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
                ->groupBy('identifier')
                ->get();
        return Response(json_encode($shipping_data));
    }

    public function listSKU()
    {
        $id = Input::get('id');
        $cust_data = DB::table('purchase_order')
                ->select('customer_id')
                ->where('id', $id)
                ->first();
        $ord_data = DB::table('order_list')
                ->select('part_id')
                ->where('customer_id', $cust_data->customer_id)
                ->where('po_id', $id)
                ->get();

        $sku = [];
        foreach ($ord_data as $key => $value) {
            $sku_data = DB::table('part_number')
                    ->select('SKU')
                    ->where('id', $value->part_id)
                    ->get();

            $elem = $sku_data[0]->SKU;
            array_push($sku, $elem);
        }
        return $sku;
        //  return Response(json_encode($shipping_data));
    }

    public function paymentTerm()
    {
        $id = Input::get('id');
        $cust_data = DB::table('purchase_order')
                ->select('payment_terms')
                ->where('id', $id)
                ->first();
        return Response(json_encode($cust_data));
    }

    public function listInvoice()
    {
        return view('invoice.listInvoice', ['page_title' => 'Invoice']);
    }

}
