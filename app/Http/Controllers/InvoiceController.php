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
use App\Http\Controllers\Image;
use Illuminate\Database\Query\Builder;

//use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addInvoice()
    {
        // Get Last Invoice ID
        $invoice_data = DB::table('invoice')->select('id')->orderBy('id', 'desc')->first();

        //Generate Invoice_No
        if ($invoice_data == null) {
            $inv_ID = str_pad(1, 4, '0', STR_PAD_LEFT);
            $auto_invoice_no = 'IN' . $inv_ID;
        } else {
            $inv_ID = str_pad($invoice_data->id, 4, '0', STR_PAD_LEFT);
            $auto_invoice_no = 'IN' . $inv_ID;
        }

        //check Is post
        if (Request::isMethod('post')) {

            // Get All Post Data
            $post = Input::all();

            unset($post['_token']);

            // Server Side Validation
            $rules = array(
                'comp_name' => 'required',
                'building_no' => 'required',
                'street_addrs' => 'required',
                'interior_no' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zipcode' => 'required',
                'phone_no' => 'required'
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return redirect('/invoice/add')
                                ->withErrors($validator)
                                ->withInput(Input::all());
            }

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
                            'date' => date('Y/m/d', strtotime(date("Y/m/d"))),
                            'invoice_id' => '',
                            'created_by' => $post['user_id']
                ));
            } else {
                //Get Customer ID
                $customer_data = DB::table('purchase_order')->where('id', $post['selectPO'])->first();
                $shipping_data = DB::table('shipping_info')
                        ->where('customer_id', $customer_data->customer_id)
                        ->where('identifier', $post['oldShippingInfo'])
                        ->first();
            }

            $billing_info = DB::table('invoice')->insert(
                    array('invoice_no' => $auto_invoice_no,
                        'po_id' => $post['selectPO'],
                        'shipping_id' => $shipping_data->id,
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

            /* DB::table('invoice')
              ->where('po_id', $post['selectPO'])
              ->where('shipping_id', $shipping_data->id)
              ->update(array('invoice_no' => $invoice_no)); */
        }

        $uid = Auth::user()->id;

        if (isset($uid) && $uid != null) {
            $PO = DB::table('purchase_order')->get();
            return View::make("invoice.addInvoice", ['page_title' => 'Add Invoice'])
                            ->with("po", $PO)
                            ->with("auto_invoice_no", $auto_invoice_no);
        }
    }

    /**
     * Get Shippinh Info, Payment Term and Require Date
     */
    public function listShipingInfo()
    {
        $id = Input::get('id');
        $shipping_info = DB::table('purchase_order')
                ->leftJoin('shipping_info', 'shipping_info.customer_id', '=', 'purchase_order.customer_id')
                //->leftJoin('order_list', 'order_list.po_id', '=', 'purchase_order.id')
                //->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                ->select('purchase_order.payment_terms', 'purchase_order.require_date', 'shipping_info.identifier')//,'part_number.SKU')
                ->where('purchase_order.id', $id)
                ->distinct()
                ->get();
        return Response(json_encode($shipping_info));
    }

    /**
     * Get SKU Data by PO_Id
     */
    public function listSKU()
    {
        $skuData = DB::table('order_list')
                ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                ->select('part_number.id', 'part_number.SKU')
                ->where('order_list.po_id', Input::get('id'))
                ->get();
        return Response(json_encode($skuData));
    }

    /**
     * Get Description by SKU
     */
    public function dispSKUdata()
    {      
        $sku_data = DB::table('part_number')->select('description', 'cost')->where('id', Input::get('id'))->get();
        return Response(json_encode($sku_data));
    }

    public function listInvoice()
    {
        return view('invoice.listInvoice', ['page_title' => 'Invoice']);
    }

}
