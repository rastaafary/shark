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

    /**
     * Add New Invoice Order Details
     */
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
                $customer = DB::table('purchase_order')->where('id', $post['po_id'])->first();

                // Add New Shipping Information
                $shippingId = DB::table('shipping_info')->insertGetId(
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
                $customer_data = DB::table('purchase_order')->where('id', $post['po_id'])->first();
                $shipping_info = DB::table('shipping_info')
                        ->where('customer_id', $customer_data->customer_id)
                        ->where('id', $post['oldShippingInfo'])
                        ->first();
                $shippingId = $shipping_info->id;
            }

            // add invoice
            $invoiceId = DB::table('invoice')->insertGetId(
                    array('invoice_no' => $auto_invoice_no,
                        'po_id' => $post['po_id'],
                        'shipping_id' => $shippingId,
                        'comp_name' => $post['comp_name'],
                        'building_no' => $post['building_no'],
                        'street_addrs' => $post['street_addrs'],
                        'interior_no' => $post['interior_no'],
                        'city' => $post['city'],
                        'state' => $post['state'],
                        'zipcode' => $post['zipcode'],
                        'country' => $post['country'],
                        'phone_no' => $post['phone_no'],
                        'is_deleted' => 0
            ));
            
            // add invoice_order_list
            $orders = json_decode($post['orders'], true);
            
            foreach ($orders as $orderlist) {               
                if ($orderlist['part_id'] > 0) {
                    $orederData['invoice_id'] = $invoiceId;
                    $orederData['order_id'] = $orderlist['orderId'];
                    $orederData['qty'] = $orderlist['qty'];
                    $orederData['discount'] = $orderlist['discount'];
                    $orederData['amount'] = $orderlist['amount'];
                    $orderstatus = DB::table('invoice_order_list')->insertGetId($orederData);
                }
            } 
            
            Session::flash('message', "Invoice generated sucessfully.");
            Session::flash('status', 'success');
            return redirect('/invoice');
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
     * UpdateInvoice Order Details
     */
    public function editInvoice($id = null)
    {
        //check Poid Is empty
        if (!empty($id)) {
            //Get Logged User Deatils
            $user = Auth::user();
            //Get Custome Details
            $customer = DB::table('customers')->where('user_id', $user->id)->first();
            
            //Get data of invoice data
            $invoiceOrder = DB::table('invoice')
                    ->select(array('shipping_info.*', 'purchase_order.*', 'invoice.*'))
                    ->leftJoin('purchase_order', 'purchase_order.id', '=', 'invoice.po_id')
                    ->leftJoin('shipping_info', 'shipping_info.id', '=', 'purchase_order.shipping_id')
                    ->where('invoice.id', $id)
                    ->first();

            if (Request::isMethod('post')) {

                $post = Input::all();
                unset($post['_token']);
                
                // Server Side Validation
                $rules = array(
                    'comp_name' => 'required',
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
                    $customer = DB::table('purchase_order')->where('id', $post['po_id'])->first();

                    // Add New Shipping Information
                    $shippingId = DB::table('shipping_info')->insertGetId(
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
                    $shippingId = $post['oldShippingInfo'];
                }

                // add invoice
                $invoiceId = DB::table('invoice')
                        ->where('id', $id)
                        ->update(
                            array(  'shipping_id' => $shippingId,
                                    'comp_name' => $post['comp_name'],
                                    'building_no' => $post['building_no'],
                                    'street_addrs' => $post['street_addrs'],
                                    'interior_no' => $post['interior_no'],
                                    'city' => $post['city'],
                                    'state' => $post['state'],
                                    'zipcode' => $post['zipcode'],
                                    'country' => $post['country'],
                                    'phone_no' => $post['phone_no']
                            ));

                // add Or Update Invoice Order Data
                $orders = json_decode($post['orders'], true);
                $deleteOrderIds = explode(',', $post['deleteOrder']);

                if (count($deleteOrderIds) > 0) {
                    foreach ($deleteOrderIds as $deleteOrder) {
                        DB::table('invoice_order_list')->where('id', $deleteOrder)
                                ->delete();
                    }
                }
                
                foreach ($orders as $orderlist) {               
                    if ($orderlist['part_id'] > 0) {
                        $orederData['invoice_id'] = $id;
                        $orederData['order_id'] = $orderlist['orderId'];
                        $orederData['qty'] = $orderlist['qty'];
                        $orederData['discount'] = $orderlist['discount'];
                        $orederData['amount'] = $orderlist['amount'];
                        
                        if ($orderlist['invoiceOrderId'] > 0) {
                            //Update Order
                            DB::table('invoice_order_list')
                                ->where('id', $orderlist['invoiceOrderId'])
                                ->update($orederData);
                        } else {
                            //Add new Order Data
                            DB::table('invoice_order_list')
                                ->insertGetId($orederData);
                        }
                        
                    }
                }
                
                
                Session::flash('message', "Invoce Updated Sucessfully.");
                Session::flash('status', 'success');
                return redirect('/invoice');
            }

            //Get list of Parts order for Invoice
            $invoiceOrderList = DB::table('invoice_order_list')
                    ->select(array('invoice_order_list.*', 'part_number.*', 'invoice_order_list.id as invoiceOrderId'))
                        ->leftJoin('order_list', 'order_list.id', '=', 'invoice_order_list.order_id')
                        ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                        ->where('invoice_order_list.invoice_id', $id)
                        ->get();
            $PO = DB::table('purchase_order')->get();            
        } else {
            return redirect('/invoice/add');
        }
        
        return View::make("invoice.addInvoice", ['page_title' => 'Edit Invoice Order'], ['id' => $id])
                        ->with('cust', $customer)
                        ->with('invoiceOrder', $invoiceOrder)
                        ->with('invoiceSKUOrder', $invoiceOrderList)
                        ->with('auto_invoice_no', $invoiceOrder->invoice_no)
                        ->with('po',$PO);
    }
    
    /**
     * Get Shippinh Info, Payment Term and Require Date
     */
    public function listShipingInfo()
    {
        $id = Input::get('id');
        $shipping_info = DB::table('purchase_order')
                ->leftJoin('shipping_info', 'shipping_info.customer_id', '=', 'purchase_order.customer_id')
                ->leftJoin('customers', 'customers.id', '=', 'purchase_order.customer_id')
                //->leftJoin('order_list', 'order_list.po_id', '=', 'purchase_order.id')
                //->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                ->select('shipping_info.id','purchase_order.payment_terms', 'purchase_order.require_date', 'shipping_info.identifier', 'customers.comp_name', 'customers.building_no', 'customers.street_addrs', 'customers.interior_no', 'customers.city', 'customers.state', 'customers.zipcode', 'customers.country', 'customers.phone_no')//,'part_number.SKU')
                ->where('purchase_order.id', $id)
                ->get();
       // var_dump($shipping_info);
        return Response(json_encode($shipping_info));
    }

    /**
     * Get SKU Data by PO_Id
     */
    public function listSKU()
    {
        $skuData = DB::table('order_list')
                ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                ->select('part_number.id', 'part_number.SKU', 'order_list.qty' , 'order_list.id as orderId')
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
    
    /**
     * Get Invoice Order List
     */
    public function listInvoice()
    {   
        return view('invoice.listInvoice', ['page_title' => 'Invoice']);
    }
    
    /**
     * Get Invoice Order List
     */
    public function getInvoiceList()
    {
        // Get PO List
        $customer = DB::table('customers')->where('user_id', Auth::user()->id)->first();       
        $orderlist = DB::table('invoice')
                ->leftJoin('invoice_order_list', 'invoice_order_list.invoice_id', '=', 'invoice.id')
                ->leftJoin('purchase_order', 'purchase_order.id', '=', 'invoice.po_id')              
                ->select(array('invoice.invoice_no', DB::raw('SUM(invoice_order_list.amount) as amount'), DB::raw('SUM(invoice_order_list.discount) as discount'), DB::raw('SUM(invoice_order_list.invoice_id) as temp'), 'purchase_order.payment_terms','invoice.id','invoice.comp_name'))
                //->where('purchase_order.customer_id', '=',$customer->id )
                ->where('invoice.is_deleted','<>',1)
                ->groupBy('invoice.id');
        return Datatables::of($orderlist)
                        ->editColumn("amount", '${{ $amount }}')
                        ->editColumn("discount", '$0')
                        ->editColumn("temp", '${{ $amount }}')
                        ->editColumn("id", '<a href="/invoice/edit/{{ $id }}" class="btn btn-primary" id="btnEdit">'
                                . '<span class="fa fa-pencil"></span></a>&nbsp&nbsp'
                                . '<a href="/invoice/delete/{{ $id }}" class="btn btn-danger" onClick = "return confirmDelete({{ $id }})" id="btnDelete">'
                                . '<span class="fa fa-trash-o"></span></a>')
                        //->editColumn("id", '<a class="btn btn-primary" href="/invoice/edit/{{ $id }}"> Details </a>')
                        ->make();
    }
    
    /**
     * Delete Invoice Order
     */
    public function deleteInvoice($id = null)
    {
        /***********/
        //NEED TO CHACKE IF PAID VALUE IS 0 THEN USER CAN DELETE IT OTHER WISE NOTss
        /***********/
        $status = DB::table('invoice')->where('id', $id)->update(array('is_deleted' => 1));

        if ($status) {
            Session::flash('message', 'Invoice delete Successfully.');
            Session::flash('status', 'success');
        } else {
            Session::flash('message', "Invoice delete Unsucessfully.");
            Session::flash('status', 'error');
        }

        return redirect('/invoice');
    }
}
