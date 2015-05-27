<?php

//namespace App\Http\Controllers\Customer;

namespace App\Http\Controllers;

use File;
use DB;
use View;
use Input;
use Session;
use Validator;
use Datatables;
use Hash;
use Auth;
use Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Image;
use Illuminate\Database\Query\Builder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use app\library\myFunctions;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listCust()
    {
        return view('customer.listCustomer', ['page_title' => 'Customer List']);
    }

    public function addCust()
    {
        $post = Input::all();
        if (isset($post['_token'])) {
            unset($post['_token']);

            $rules = array(
                'comp_name' => 'required',
                'zipcode' => 'required',
                'building_no' => 'required',
                'street_addrs' => 'required',
                'phone_no' => 'required',
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

            $dt = $post['contact_birthdate'];
            $my_date = date('m/d/Y', strtotime($dt));
            $time = strtotime($my_date);
            $date = date('Y/m/d', $time);

            //Upload the image
            if (isset($post['image'])) {
                $imageName = $post['image']->getClientOriginalName();

                $file = Input::file('image');
                $destinationPath = 'images/user';
                $filename = str_replace(' ', '', $post['contact_name']) . time() . '_' . $imageName;
                Input::file('image')->move($destinationPath, $filename);
                $post['image'] = $filename;
            }

            $userInsert = DB::table('user')->insertGetId(
                    array('role' => '3', 'email' => $post['contact_email'], 'password' => Hash::make($post['password']), 'name' => $post['contact_name'], 'birthdate' => $date, 'mobileno' => $post['contact_mobile'], 'image' => isset($post['image']) ? $post['image'] : '')
            );
            //$last_id = DB::table('user')->orderBy('id', 'desc')->first();

            $custInsert = DB::table('customers')->insertGetId(
                    array('user_id' => $userInsert, 'customer_image' => isset($post['image']) ? $post['image'] : '', 'comp_name' => $post['comp_name'], 'zipcode' => $post['zipcode'], 'building_no' => $post['building_no'], 'country' => $post['country'], 'street_addrs' => $post['street_addrs'], 'phone_no' => $post['phone_no'], 'interior_no' => $post['interior_no'], 'fax_number' => $post['fax_number'], 'city' => $post['city'], 'website' => $post['website'], 'state' => $post['state'], 'contact_name' => $post['contact_name'], 'position' => $post['position'], 'contact_email' => $post['contact_email'], 'contact_mobile' => $post['contact_mobile'], 'contact_birthdate' => $date)
            );
            $shippingInsert = DB::table('shipping_info')->insertGetId(
                    array('customer_id' => $custInsert, 'comp_name' => $post['comp_name'], 'zipcode' => $post['zipcode'], 'building_no' => $post['building_no'], 'country' => $post['country'], 'street_addrs' => $post['street_addrs'], 'phone_no' => $post['phone_no'], 'interior_no' => $post['interior_no'], 'city' => $post['city'], 'state' => $post['state'], 'identifier' => 'My Deafult Address')
            );

            // Email 
            if (isset($userInsert) && isset($custInsert) && isset($shippingInsert)) {
                $name = $post['contact_name'];
                $username = $post['contact_email'];
                $password = $post['password'];
                $subject = 'New Registration';

                $message = '<html>
                                <head>
                                    <meta charset="utf-8">
                                </head>
                                <body>
                                    <h2>New Customer Registration</h2>

                                    <div>
                                        Dear ' . $name . ', Your login credentials are : <br>
                                            Username : ' . $username . ' <BR>
                                            Password : ' . $password . '
                                    </div>
                                </body>
                            </html>';
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                $mail_status = mail($username, $subject, $message, $headers);
            }
            Session::flash('message', 'Customer Added Successfully!!');
            Session::flash('status', 'success');
            return redirect('/customer');
        }
        
        return view('customer.addCustomer', ['page_title' => 'Add Customers']);
    }

    public function editCust($id = null)
    {
        $isSetNewPass = 0;
        $post = Input::all();
        if (isset($post['_token']))
            unset($post['_token']);

        if (isset($post['comp_name'])) {
            $emailId = $post['id'];

            $rules = array(
                'comp_name' => 'required',
                'zipcode' => 'required',
                'building_no' => 'required',
                'street_addrs' => 'required',
                'phone_no' => 'required',
                'city' => 'required',
                'state' => 'required',
                'contact_name' => 'required',
                'position' => 'required',
                'contact_email' => 'required|Email|unique:user,email,' . $emailId,
                'contact_mobile' => 'required',
                'contact_birthdate' => 'required',
            );

            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                // $messages = $validator->messages();
                return Redirect::to('customer/edit/' . $post['id'])
                                ->withErrors($validator)
                                ->withInput(Input::except('password'));

                /*   if (!empty($messages)) {
                  foreach ($messages->all() as $error) {
                  return Redirect::to('customer/edit/' . $id)
                  ->withInput(Input::except('password'));
                  Session::flash('message', $error);
                  Session::flash('alert-class', 'alert-danger');
                  // return View::make('customer.addCustomer', ['page_title' => 'Edit Customer', 'id' => $id])->with('post', $post);
                  ;
                  }
                  } */
            }

            $dt = $post['contact_birthdate'];
            $my_date = date('m/d/Y', strtotime($dt));
            $time = strtotime($my_date);
            $date = date('Y/m/d', $time);
            if ($post['password'] == '') {
                $myquery = DB::table('user')->select('password')->where('id', $post['id'])->first();
                $post['password'] = $myquery->password;
            } else {
                $newUpdatedPassword = $post['password'];
                $post['password'] = Hash::make($post['password']);
                $isSetNewPass = 1;
            }

            //Upload the image
            $file = Input::file('image');
            $destinationPath = 'images/user';

            //delete old image
            if (isset($post['image'])) {
                $imageName = $post['image']->getClientOriginalName();
                $myimage = DB::table('customers')->select('customer_image')->where('user_id', $post['id'])->first();
                File::delete('images/user/' . $myimage->customer_image);
                $filename = str_replace(' ', '', $post['contact_name']) . time() . '_' . $imageName;
                Input::file('image')->move($destinationPath, $filename);
                $post['image'] = $filename;
            } else {
                $myimage = DB::table('customers')->select('customer_image')->where('user_id', $post['id'])->first();
                $post['image'] = $myimage->customer_image;
            }
            DB::table('user')
                    ->leftJoin('customers', 'customers.user_id', '=', 'user.id')
                    ->leftJoin('shipping_info', 'shipping_info.customer_id', '=', 'customers.id')
                    ->where('user.id', $post['id'])
                    ->update(array('user.email' => $post['contact_email'], 'user.name' => $post['contact_name'], 'user.birthdate' => $date, 'user.mobileno' => $post['contact_mobile'], 'user.password' => $post['password'], 'user.image' => $post['image'], 'customers.comp_name' => $post['comp_name'], 'customers.zipcode' => $post['zipcode'], 'customers.building_no' => $post['building_no'], 'customers.country' => $post['country'], 'customers.street_addrs' => $post['street_addrs'], 'customers.phone_no' => $post['phone_no'], 'customers.interior_no' => $post['interior_no'], 'customers.fax_number' => $post['fax_number'], 'customers.city' => $post['city'], 'customers.website' => $post['website'], 'customers.state' => $post['state'], 'customers.contact_name' => $post['contact_name'], 'customers.position' => $post['position'], 'customers.contact_email' => $post['contact_email'], 'customers.contact_mobile' => $post['contact_mobile'], 'customers.contact_birthdate' => $date, 'customers.customer_image' => $post['image'], 'shipping_info.comp_name' => $post['comp_name'], 'shipping_info.zipcode' => $post['zipcode'], 'shipping_info.building_no' => $post['building_no'], 'shipping_info.country' => $post['country'], 'shipping_info.street_addrs' => $post['street_addrs'], 'shipping_info.phone_no' => $post['phone_no'], 'shipping_info.interior_no' => $post['interior_no'], 'shipping_info.city' => $post['city'], 'shipping_info.state' => $post['state']));

            // Email
            if ($isSetNewPass == 1) {
                $name = $post['contact_name'];
                $username = $post['contact_email'];
                $password = $newUpdatedPassword;
                $subject = 'Your updated login credentials';
                $message = '<html>
                                <head>
                                    <meta charset="utf-8">
                                </head>
                                <body>
                                    <h2>New updated login credentials</h2>

                                    <div>
                                        Dear ' . $name . ', Your new updated login credentials are : <br>
                                            Username : ' . $username . ' <BR>
                                            Password : ' . $password . '
                                    </div>
                                </body>
                            </html>';

                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                $mail_status = mail($username, $subject, $message, $headers);
            }
            /*  DB::table('customers')
              ->where('user_id', $post['id'])
              ->update(array('comp_name' => $post['comp_name'], 'zipcode' => $post['zipcode'], 'building_no' => $post['building_no'], 'country' => $post['country'], 'street_addrs' => $post['street_addrs'], 'phone_no' => $post['phone_no'], 'interior_no' => $post['interior_no'], 'fax_number' => $post['fax_number'], 'city' => $post['city'], 'website' => $post['website'], 'state' => $post['state'], 'contact_name' => $post['contact_name'], 'position' => $post['position'], 'contact_email' => $post['contact_email'], 'contact_mobile' => $post['contact_mobile'], 'contact_birthdate' => $date, 'customer_image' => $post['image'])
              );

              DB::table('shipping_info')
              ->leftJoin('shipping_info', 'shipping_info.id', '=', 'purchase_order.shipping_id')
              ->where('customer_id', $post['id'])
              ->where('identifire', 'My Deafult Address')
              ->update(array('comp_name' => $post['comp_name'], 'zipcode' => $post['zipcode'], 'building_no' => $post['building_no'], 'country' => $post['country'], 'street_addrs' => $post['street_addrs'], 'phone_no' => $post['phone_no'], 'interior_no' => $post['interior_no'], 'city' => $post['city'], 'state' => $post['state'], 'identifire' => 'My Deafult Address')
              ); */

            Session::flash('message', 'Customer Updated Successfully!!');
            Session::flash('status', 'success');
            return redirect('/customer');
        } else if (isset($id)) {
            $cust = DB::table('customers')->where('user_id', $id)->first();
            return View::make('customer.addCustomer', ['page_title' => 'Edit Customer', 'id' => $id])->with('cust', $cust);
        }
        return view('customer.addCustomer', ['page_title' => 'List Customer']);
    }

    public function deleteCust($id = null)
    {
        //  DB::table('customers')->where('user_id', $id)->delete();
        DB::table('customers')
                ->where('user_id', $id)
                ->update(array('is_deleted' => '1'));

        Session::flash('message', 'Customer Deleted Successfully!!');
        Session::flash('status', 'success');
        return redirect('/customer');
    }

    public function getCustData()
    {

        /* $FmyFunctions1 = new \App\library\myFunctions;
          $is_ok = ($FmyFunctions1->is_ok());
          var_dump($is_ok);
          exit("sdhfk"); */

        $custlist = DB::table('customers')
                ->select(array('id', 'comp_name', 'building_no', 'street_addrs', 'interior_no', 'city', 'state', 'zipcode', 'country', 'phone_no', 'user_id', 'contact_name'))
                ->where('is_deleted', '!=', '1');
        return Datatables::of($custlist)
                        ->editColumn("user_id", '<a href="{{url("/")}}/customer/delete/{{ $user_id }}" class="btn btn-danger" onClick = "return confirmDelete({{ $id }})" id="btnDelete"><span class="fa fa-trash-o" ></span></a><a href="/customer/edit/{{ $user_id }}" class="btn btn-primary" id="btnEdit"><span class="fa fa-pencil"></span></a>')
                        ->make();
    }

}
