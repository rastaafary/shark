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

    /**
     * Add payment
     * 
     * @return type
     */
    public function addPayment()
    {
        $uid = Auth::user()->id;
        if (isset($uid) && $uid != null) {
            // $invoice_data = DB::table('invoice')->groupBy('invoice_no')->get();
            //check Is post
            if (Request::isMethod('post')) {
                // Get post data
                $post = Input::all();
                unset($post['_token']);
                //print_r($post);exit;
                // Validate the data
                $rules = array(
                    'paymentDate' => 'required',
                    'txtAmount' => 'required',
                    'invoiceSelect' => 'required',
                );
                $validator = Validator::make(Input::all(), $rules);
                if ($validator->fails()) {
                    return redirect('/payment/add')
                                    ->withErrors($validator)
                                    ->withInput(Input::all());
                }

                // Insert payment record
                $paymentId = DB::table('payment')->insertGetId(
                        array('invoice_id' => $post['invoiceSelect'],
                            'paid' => $post['txtAmount'],
                            'date' => $post['paymentDate'],
                            'payment_ref_no' => $post['paymentRefNo'])
                );

                // Set success and return
                Session::flash('message', "Payment Added Sucessfully.");
                Session::flash('status', 'success');
                return redirect('/payment');
            }

            // Render View page
            return View::make("payment.addPayment", ['page_title' => 'Add Payment']); //->with("invoice", $invoice_data);
        }
    }

    public function listPayment()
    {
        $paymentDetails = DB::table('payment')->get();
        //var_dump($paymentDetails);exit;
        return view('payment.listPayment', ['page_title' => 'Payment'])->with("paymentDetails", $paymentDetails);
    }

    public function viewPayment()
    {
        return view('payment.viewPayment', ['page_title' => 'View Payment']);
    }

    /**
     * Search customer By id OR name.
     * 
     * @return type
     */
    public function searchCustomer()
    {
        $c_name = Request::segment(3);
        $data = DB::table('customers')->select('id', 'contact_name')
                ->where('contact_name', 'like', $c_name . '%')
                ->orWhere('id', 'like', $c_name . '%')
                ->get();

        // Return
        return Response(json_encode($data));
    }

    /**
     * Get invoice list from customerId
     * 
     * @return type
     */
    public function getCustInvoice()
    {
        $invoiceList = DB::table('invoice')
                ->leftJoin('purchase_order', 'purchase_order.id', '=', 'invoice.po_id')
                ->select('invoice.id', 'invoice.invoice_no')
                ->where('purchase_order.customer_id', Input::get('custId'))
                ->get();

        // Return
        return Response(json_encode($invoiceList));
    }

    /**
     * Get invoice details for payment by InvoiceId
     * 
     * @return type
     */
    public function getInvoicePaymentDetails()
    {
        $invoiceId = Input::get('invoiceId');

        // For Invoice
        $invoice = DB::table('invoice_order_list')
                ->select('invoice_id', DB::raw('SUM(amount) as total'))
                ->where('invoice_id', $invoiceId)
                ->get();

        // For invoice payment history
        $invoiceDetails = array();

        // Return
        return Response(json_encode(array('invoice' => $invoice, 'invoiceDetails' => $invoiceDetails)));
    }

}
