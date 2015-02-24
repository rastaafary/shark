<?php

//namespace App\Http\Controllers\Customer;

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

class PurchaseOrderCustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userDetails()
    {
        $post = Input::all();
        if (isset($post['_token']))
            unset($post['_token']);
        if (isset($id)) {
            $cust = DB::table('customers')->where('user_id', $id)->first();
            return View::make('PurchaseOrderCustomer.addPurchaseOrder', ['page_title' => 'Add Purchase Order', 'id' => $id])->with('cust', $cust);
        }
        return view('PurchaseOrderCustomer.addPurchaseOrder', ['page_title' => 'Add Purchase Order']);
    }

    public function addPurchaseOrder($id = null)
    {
        $post = Input::all();
        if (isset($post['_token'])) {
            unset($post['_token']);

            $rules = array(
                'orderDate' => 'required',
                'shippingMethod' => 'required',
                'payment_terms' => 'required',
                'require_date' => 'required',
                'PDF' => 'mimes:pdf|max:1024',
                'Ai' => 'mimes:pdf|max:1024'
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return redirect('/po/add')
                                ->withErrors($validator)
                                ->withInput(Input::all());
                //->with(array("shipping" => $shipping, $validator));
            }

            $dt = $post['require_date'];
            $my_date = date('m/d/Y', strtotime($dt));
            $time = strtotime($my_date);
            $reqDate = date('Y/m/d', $time);

            $dt = $post['orderDate'];
            $my_date = date('m/d/Y', strtotime($dt));
            $time = strtotime($my_date);
            $ordDate = date('Y/m/d', $time);

            if (isset($post['addNew'])) {

                // Server side Validations

                /*    $rules = array(
                  'comp_name' => 'required',
                  'building_no' => 'required',
                  'street_addrs' => 'required',
                  'interior_no' => 'required',
                  'city' => 'required',
                  'state' => 'required',
                  'zipcode' => 'required',
                  'country' => 'required',
                  'phone_no' => 'required',
                  'identifer' => 'required',
                  );
                  $validator = Validator::make(Input::all(), $rules);
                  if ($validator->fails()) {
                  $uid = Auth::user()->id;
                  $cust = DB::table('customers')->where('user_id', $uid)->first();
                  $cust_id = $cust->id;
                  $shipping = DB::table('shipping_info')->where('customer_id', $cust_id)->get();

                  return redirect('/po/add')
                  ->withErrors($validator)
                  ->withInput(Input::all());
                  //->with(array("shipping" => $shipping, $validator));
                  } */

                //Get Customer ID
                $customer = DB::table('customers')->where('user_id', $post['id'])->first();

                // Add New Shipping Information
                $shp_info = DB::table('shipping_info')->insert(
                        array('customer_id' => $customer->id,
                            'comp_name' => $post['comp_name'],
                            'building_no' => $post['building_no'],
                            'street_addrs' => $post['street_addrs'],
                            'interior_no' => $post['interior_no'],
                            'city' => $post['city'],
                            'state' => $post['state'],
                            'zipcode' => $post['zipcode'],
                            'country' => $post['country'],
                            'phone_no' => $post['phone_no'],
                            'identifier' => $post['identifer'],
                            'type' => $post['shippingMethod'],
                            'date' => $ordDate,
                            'invoice_id' => '',
                ));
            } else {
                //Get Customer ID
                $customer_data = DB::table('customers')->where('user_id', $post['id'])->first();
                $customer = DB::table('shipping_info')
                        ->where('customer_id', $customer_data->id)
                        ->where('identifier', $post['oldIdentifire'])
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
                            'identifier' => $post['oldIdentifire'],
                            'type' => $post['shippingMethod'],
                            'date' => $ordDate,
                            'invoice_id' => '',
                ));
            }

            //Get the Customer Details
            // $customer = DB::table('customers')->where('user_id', $id)->first();
            $customer = DB::table('customers')->where('user_id', $post['id'])->first();

            //$blogfiles = '';
            //Upload the PDF
            if (isset($post['PDF'])) {
                $pdfName = $post['PDF']->getClientOriginalName();
                $file = Input::file('PDF');
                $destinationPath = 'images/Blog_art';
                $pdfFilename = str_replace(' ', '', $customer->comp_name) . time() . '_' . $pdfName;
                Input::file('PDF')->move($destinationPath, $pdfFilename);
                $post['PDF'] = $pdfFilename;
                //$blogfiles = $blogfiles . ' ' . $filename;
            }

            //Upload the Ai
            if (isset($post['Ai'])) {
                $aiName = $post['Ai']->getClientOriginalName();
                $file = Input::file('Ai');
                $destinationPath = 'images/Blog_art';
                $aiFilename = str_replace(' ', '', $customer->comp_name) . time() . '_' . $aiName;
                Input::file('Ai')->move($destinationPath, $aiFilename);
                $post['Ai'] = $aiFilename;
                //$aiFile = $blogfiles . ' ' . $filename;
            }

            // Get Shipping Id
            //$shipping = DB::table('shipping_info')->where('customer_id', $id)->last();
            $shipping = DB::table('shipping_info')->orderBy('id', 'desc')->first();

            //Add Purchase Order
            $po = DB::table('purchase_order')->insert(
                    array('customer_id' => $customer->id,
                        'shipping_id' => $shipping->id,
                        'date' => $ordDate,
                        'payment_terms' => $post['payment_terms'],
                        'require_date' => $reqDate,
                        'comments' => $post['comments']
                    )
            );
            $last_PO_id = DB::table('purchase_order')->orderBy('id', 'desc')->first();

            //Add Blog Art Data
            $blog_art = DB::table('blog_art_file')->insert(
                    array('po_id' => $last_PO_id->id,
                        'customer_id' => $customer->id,
                        'name' => '',
                        'pdf' => $pdfFilename,
                        'ai' => $aiFilename)
            );

            Session::flash('message', "PO Customer Added Sucessfully.");
            Session::flash('alert-class', 'alert-danger');
            return View::make('PurchaseOrderCustomer.listPurchaseOrder');
            //$last_id = DB::table('user')->orderBy('id', 'desc')->first();
        }
        //return redirect('/userList/add')->with('identifier', $shipping->identifier);
        $uid = Auth::user()->id;

        if (isset($uid) && $uid != null) {
            $cust = DB::table('customers')->where('user_id', $uid)->first();
            $cust_id = $cust->id;
            $shipping = DB::table('shipping_info')->where('customer_id', $cust_id)->get();

            return View::make("PurchaseOrderCustomer.addPurchaseOrder", ['page_title' => 'Add Purchase Order'])
                            ->with("shipping", $shipping);
        }
    }

    public function listPurchaseOrder()
    {

        return view('PurchaseOrderCustomer.listPurchaseOrder', ['page_title' => 'Purchase Order']);
    }

    public function searchSKU()
    {
        $sku = Request::segment(4);
        $data = DB::table('part_number')->select('SKU')->where('SKU', 'like', '%' . $sku . '%')->get();
        return Response(json_encode($data));
    }
    
    /**
     * get description by sku
     */

    public function getDescription()
    {
        $sku = Input::get('description');
        $data = DB::table('part_number')->select('SKU','description','cost')->where('SKU', $sku)
                ->orWhere('description', $sku)
                ->get();
        return Response(json_encode($data));
    }
    
     public function searchDiscription()
    {
        $sku = Request::segment(4);
        $data = DB::table('part_number')->select('description')->where('description', 'like', '%' . $sku . '%')->get();
        return Response(json_encode($data));
    }
    
    /**
     * 
     */
    public function addOrder()
    {
        exit("hi");
       /* $last_PO_id = DB::table('purchase_order')->orderBy('id', 'desc')->first();
        $customer = DB::table('customers')->where('user_id', $post['id'])->first();
        $SKU = DB::table('part_number')
                ->where('SKU', $post['searchSKU'])
                ->get();
        if (!empty($SKU)) {
            $add_Order = DB::table('order_list')->insert(
                    array('part_id' => $SKU->id,
                        'description' => $SKU->description,
                        'qty' => $post['Qty'],
                        'amount' => $post['Amount'],
                        'po_id' => $last_PO_id->id,
                        'customer_id' => $customer->id
                    )
            );
        } */
    }
}
