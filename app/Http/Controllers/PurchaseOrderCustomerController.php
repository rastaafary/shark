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
use Illuminate\Http\Request;
use App\Http\Controllers\Image;
use Illuminate\Database\Query\Builder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PurchaseOrderCustomerController extends Controller
{

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

            if (isset($post['addNew'])) {

                $dt = $post['require_date'];
                $my_date = date('m/d/Y', strtotime($dt));
                $time = strtotime($my_date);
                $date = date('Y/m/d', $time);

                //Get Customer ID
                $customer = DB::table('customers')->where('user_id', $post['id'])->first();

                // Add New Shipping Information
                DB::table('shipping_info')->insert(
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
                            'date' => $date,
                ));
            } else {

                //Get Customer ID
                $customer = DB::table('customers')->where('user_id', $post['id'])->first();

                // Add Old Shipping Information
                DB::table('shipping_info')->insert(
                        array('customer_id' => $customer->id,
                            'comp_name' => $customer->comp_name,
                            'building_no' => $customer->building_no,
                            'street_addrs' => $customer->street_addrs,
                            'interior_no' => $customer->interior_no,
                            'city' => $customer->city,
                            'state' => $customer->state,
                            'zipcode' => $customer->zipcode,
                            'country' => $customer->country,
                            'phone_no' => $customer->phone_no,
                            'identifier' => 'idef',
                            'type' => $post['shippingMethod'],
                            'date' => $date,
                ));
            }

            /*
              $rules = array(
              'comp_name' => 'required',
              'zipcode' => 'required',
              'building_no' => 'required',
              'street_addrs' => 'required',
              'phone_no' => 'required',
              'interior_no' => 'required',
              'city' => 'required',
              'state' => 'required',
              'contact_name' => 'required',
              'position' => 'required',
              'contact_email' => 'required|Email|unique:user,email',
              'password' => 'required',
              'contact_mobile' => 'required',
              'contact_birthdate' => 'required',
              );

              $validator = Validator::make(Input::all(), $rules);
              if ($validator->fails()) {
              return Redirect::to('customer/add')
              ->withErrors($validator)
              ->withInput(Input::except('password'));
              }
             */
            /*   $dt = $post['require_date'];
              $my_date = date('m/d/Y', strtotime($dt));
              $time = strtotime($my_date);
              $date = date('Y/m/d', $time);

              //Get the Customer Details
              $customer = DB::table('customers')->where('user_id', $id)->first();

              $blogfiles = '';
              //Upload the PDF
              if (isset($post['PDF'])) {
              $imageName = $post['PDF']->getClientOriginalName();

              $file = Input::file('PDF');
              $destinationPath = 'images/Blog_art';
              $filename = str_replace(' ', '', $customer->comp_name) . time() . '_' . $imageName;
              Input::file('PDF')->move($destinationPath, $filename);
              //$post['PDF'] = $filename;
              $blogfiles = $blogfiles . ' ' . $filename;
              }

              //Upload the Ai
              if (isset($post['Ai'])) {
              $imageName = $post['Ai']->getClientOriginalName();

              $file = Input::file('Ai');
              $destinationPath = 'images/Blog_art';
              $filename = str_replace(' ', '', $customer->comp_name) . time() . '_' . $imageName;
              Input::file('Ai')->move($destinationPath, $filename);
              //$post['Ai'] = $filename;
              $blogfiles = $blogfiles . ' ' . $filename;
              }

              // Add Shipping Information
              DB::table('shipping_info')->insert(
              array('customer_id' => $customer->id,
              'comp_name' => $customer->comp_name,
              'building_no' => $customer->building_no,
              'street_addrs' => $customer->street_addrs,
              'interior_no' => $customer->interior_no,
              'city' => $customer->city,
              'state' => $customer->state,
              'zipcode' => $customer->zipcode,
              'country' => $customer->country,
              'phone_no' => $customer->phone_no,
              'identifier' => 'idef',
              'type' => $post['shippingMethod'],
              'date' => $date,
              )
              );

              // Get Shipping Id
              $shipping = DB::table('shipping_info')->where('customer_id', $id)->last();

              //Add Purchase Order
              $po = DB::table('purchase_order')->insert(
              array('customer_id' => $customer->id,
              'shipping_id' => $customer->comp_name,
              'building_no' => $customer->building_no,
              )
              );

              //Add Blog Art Data
              DB::table('blog_art_file')->insert(
              array('po_id' => $po->id,
              'customer_id' => $customer->id,
              'name' => $customer->$blogfiles)
              );
             */
            //$last_id = DB::table('user')->orderBy('id', 'desc')->first();

            /* DB::table('customers')->insert(
              array('user_id' => $last_id->id, 'customer_image' => $post['image'], 'comp_name' => $post['comp_name'], 'zipcode' => $post['zipcode'], 'building_no' => $post['building_no'], 'country' => $post['country'], 'street_addrs' => $post['street_addrs'], 'phone_no' => $post['phone_no'], 'interior_no' => $post['interior_no'], 'fax_number' => $post['fax_number'], 'city' => $post['city'], 'website' => $post['website'], 'state' => $post['state'], 'contact_name' => $post['contact_name'], 'position' => $post['position'], 'contact_email' => $post['contact_email'], 'contact_mobile' => $post['contact_mobile'], 'contact_birthdate' => $date)
              );
              Session::flash('alert-success', 'success');
              Session::flash('message', 'Customer Added Successfully!!');
              return redirect('/customer'); */
        }
        //$shipping = DB::table('shipping_info')->where('customer_id', $id)->fisrt();
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

}
