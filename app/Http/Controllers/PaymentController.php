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
            //check Is post
            if (Request::isMethod('post')) {
                // Get post data
                $post = Input::all();
                unset($post['_token']);

                // Validate the data
                $rules = array(
                    'paymentDate' => 'required',
                    'txtAmount' => 'required',
                    'invoiceSelect' => 'required',
                );
                $validator = Validator::make(Input::all(), $rules);
                if ($validator->fails()) {
                    // Set error
                    Session::flash('message', "Please enter valid payment details.");
                    Session::flash('status', 'error');
                    return redirect('/payment/add')
                                    ->withErrors($validator)
                                    ->withInput(Input::all());
                }

                if ($this->IsValidAmountForPayment($post['invoiceSelect'], $post['txtAmount'])) {  // If valid amount then conti...
                    // Insert payment record
                    $paymentId = DB::table('payment')->insertGetId(
                            array('payment_id' => $this->generatePaymentNumber(),
                                'invoice_id' => $post['invoiceSelect'],
                                'paid' => $post['txtAmount'],
                                'date' => $post['paymentDate'],
                                'payment_ref_no' => $post['paymentRefNo'],
                                'comments' => $post['comments'])
                    );

                    // Set success and return
                    Session::flash('message', "Payment Added Sucessfully.");
                    Session::flash('status', 'success');
                    return redirect('/payment');
                } else {
                    // Set error
                    Session::flash('message', "Amount not valid.");
                    Session::flash('status', 'error');
                }
            }

            // Render View page
            return View::make("payment.addPayment", ['page_title' => 'Add Payment']);
        }
    }

    /**
     * View payment list
     * 
     * @return type
     */
    public function listPayment()
    {
        // Render view page
        return view('payment.listPayment', ['page_title' => 'Payment']);
    }

    /**
     * Get payment list for datatable
     * 
     * @return type
     */
    public function getPaymentList()
    {
        // Get payment data
        $paymentDetails = DB::table('payment')
                ->select(array('payment.payment_id', 'invoice.invoice_no', 'customers.contact_name', 'payment.paid', 'payment.invoice_id'))
                ->leftJoin('invoice', 'invoice.id', '=', 'payment.invoice_id')
                ->leftJoin('purchase_order', 'purchase_order.id', '=', 'invoice.po_id')
                ->leftJoin('customers', 'customers.id', '=', 'purchase_order.customer_id');

        // Return data for datatable
        return Datatables::of($paymentDetails)
                        ->editColumn("paid", '${{ $paid }}')
                        ->editColumn("invoice_id", '<a class="fa fa-bars btn btn-primary" href="{{url("/")}}/payment/view/{{ $invoice_id }}"> Details </a>')
                        ->make();
    }

    /**
     * View payment details
     * 
     * @return type
     */
    public function viewPayment()
    {
        // Get invoiceId
        $invoiceId = Request::segment(3);
        if (isset($invoiceId) && $invoiceId != 0) {
            // Get invoice details
            $invoiceDetails = DB::table('invoice')
                    ->select('invoice.id', 'invoice.invoice_no', DB::raw('SUM(amount) as total'))
                    ->leftJoin('invoice_order_list', 'invoice_order_list.invoice_id', '=', 'invoice.id')
                    ->where('invoice.id', $invoiceId)
                    ->get();
            if (isset($invoiceDetails[0]) && !empty($invoiceDetails[0]->id)) {
                // Get payment details
                $paymentDetails = DB::table('payment')
                        ->where('invoice_id', $invoiceId)
                        ->get();

                // Count total paid
                $totalPaid = 0;
                foreach ($paymentDetails as $payment) {
                    $totalPaid += $payment->paid;
                }

                //check Is post
                if (Request::isMethod('post')) {
                    // Get post data
                    $post = Input::all();
                    unset($post['_token']);

                    // Validate the data
                    $rules = array(
                        'p_date' => 'required',
                        'p_paid' => 'required',
                        'p_invoiceSelect' => 'required',
                    );
                    $validator = Validator::make(Input::all(), $rules);
                    if ($validator->fails()) {
                        // Set error
                        Session::flash('message', "Please enter valid payment details.");
                        Session::flash('status', 'error');
                        return redirect('/payment/view/' . $invoiceId)
                                        ->withErrors($validator)
                                        ->withInput(Input::all());
                    }


                    if (isset($post['p_id']) && $post['p_id'] > 0) {
                        if ($post['p_paid'] > 0 && ($post['p_paid'] < $post['p_old_paid'] || ($totalPaid + ($post['p_paid'] - $post['p_old_paid']) <= $invoiceDetails[0]->total))) {    // If valid amount then conti...
                            // Update payment record
                            $paymentId = DB::table('payment')
                                    ->where('id', $post['p_id'])
                                    ->update(
                                    array('paid' => $post['p_paid'],
                                        'date' => $post['p_date'],
                                        'payment_ref_no' => $post['p_refno'],
                                        'comments' => $post['p_comment'])
                            );

                            // Set success
                            Session::flash('message', "Payment Updated Sucessfully.");
                            Session::flash('status', 'success');
                        } else {
                            // Set error
                            Session::flash('message', "Amount not valid.");
                            Session::flash('status', 'error');
                        }
                    } else {
                        if ($this->IsValidAmountForPayment($invoiceId, $post['p_paid'])) {  // If valid amount then conti...
                            // Insert payment record
                            $paymentId = DB::table('payment')->insertGetId(
                                    array('payment_id' => $this->generatePaymentNumber(),
                                        'invoice_id' => $post['p_invoiceSelect'],
                                        'paid' => $post['p_paid'],
                                        'date' => $post['p_date'],
                                        'payment_ref_no' => $post['p_refno'],
                                        'comments' => $post['p_comment'])
                            );

                            // Set success
                            Session::flash('message', "Payment Added Sucessfully.");
                            Session::flash('status', 'success');
                        } else {
                            // Set error
                            Session::flash('message', "Amount not valid.");
                            Session::flash('status', 'error');
                        }
                    }

                    // Return
                    return redirect('/payment/view/' . $invoiceId);
                }

                // Render view page
                return view('payment.viewPayment', ['page_title' => 'View Payment'])->with(array("invoiceDetails" => $invoiceDetails, 'paymentDetails' => $paymentDetails, 'totalPaid' => $totalPaid));
            }
        }

        // Return to payment list page
        return redirect('/payment');
    }

    /**
     * Generate autom payment number for Payment new record
     * 
     * @return string
     */
    public function generatePaymentNumber()
    {
        // Get Last Payment ID
        $payment_data = DB::table('payment')->select('id')->orderBy('id', 'desc')->first();
        //Generate Payment number
        if ($payment_data == null) {
            $pay_ID = str_pad(1, 4, '0', STR_PAD_LEFT);
            $auto_payment_no = 'P' . $pay_ID;
        } else {
            $pay_ID = str_pad($payment_data->id + 1, 4, '0', STR_PAD_LEFT);
            $auto_payment_no = 'P' . $pay_ID;
        }

        // Return Auto payment number
        return $auto_payment_no;
    }

    /**
     * Check Isvalid amount for payment
     * 
     * @param type $invoiceId
     * @param type $amount
     * @return boolean
     */
    public function IsValidAmountForPayment($invoiceId, $amount)
    {
        // Get total amount
        $totalAmount = DB::table('invoice_order_list')
                ->select(DB::raw('SUM(amount) as totalAmount'))
                ->where('invoice_id', $invoiceId)
                ->get();
        // Get Paid amount
        $totalPaid = DB::table('payment')
                ->select(DB::raw('SUM(paid) as totalPaid'))
                ->where('invoice_id', $invoiceId)
                ->get();

        if (isset($totalAmount[0]) && isset($totalPaid[0]) && $amount > 0 && $amount <= $totalAmount[0]->totalAmount - $totalPaid[0]->totalPaid) {
            // Is valid then return true
            return true;
        }

        // return false
        return false;
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
        $invoice = DB::table('invoice')
                ->select('invoice.invoice_no', DB::raw('SUM(amount) as total'))
                ->leftJoin('invoice_order_list', 'invoice_order_list.invoice_id', '=', 'invoice.id')
                ->where('invoice.id', $invoiceId)
                ->get();

        // For invoice payment history
        $invoiceDetails = DB::table('payment')
                ->where('invoice_id', $invoiceId)
                ->get();

        // Return
        return Response(json_encode(array('invoice' => $invoice, 'invoiceDetails' => $invoiceDetails)));
    }

    /**
     * Delete payment
     * 
     * @return type
     */
    public function deletePayment()
    {
        // Check Is payment available.
        $paymentId = Request::segment(3);
        $paymentDetails = DB::table('payment')
                ->where('id', $paymentId)
                ->get();
        if (!empty($paymentDetails)) {  // If found then delete..
            $isdeleted = DB::table('payment')
                    ->where('id', $paymentId)
                    ->delete();
            if ($isdeleted) {
                // Set success
                Session::flash('message', "Payment deleted sucessfully.");
                Session::flash('status', 'success');
            } else {
                // Set Error
                Session::flash('message', "Something went to wrong. Try again!!!");
                Session::flash('status', 'error');
            }
        }

        // Return to payment list page
        return redirect('/payment');
    }

}
