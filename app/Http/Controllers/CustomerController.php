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

class CustomerController extends Controller
{

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

            $dt = $post['contact_birthdate'];
            $my_date = date('m/d/Y', strtotime($dt));
            $time = strtotime($my_date);
            $date = date('Y/m/d', $time);

            //Upload the image
            if (isset($post['image'])) {
                $imageName = $post['image']->getClientOriginalName();

                $file = Input::file('image');
                $destinationPath = 'images/customer';
                $filename = str_replace(' ', '', $post['contact_name']) . time() . '_' . $imageName;
                Input::file('image')->move($destinationPath, $filename);
                $post['image'] = $filename;
            }

            DB::table('user')->insert(
                    array('role' => '3', 'email' => $post['contact_email'], 'password' => Hash::make($post['password']), 'name' => $post['contact_name'], 'birthdate' => $date, 'mobileno' => $post['contact_mobile'], 'image' => $post['image'])
            );
            $last_id = DB::table('user')->orderBy('id', 'desc')->first();

            DB::table('customers')->insert(
                    array('user_id' => $last_id->id, 'customer_image' => $post['image'], 'comp_name' => $post['comp_name'], 'zipcode' => $post['zipcode'], 'building_no' => $post['building_no'], 'country' => $post['country'], 'street_addrs' => $post['street_addrs'], 'phone_no' => $post['phone_no'], 'interior_no' => $post['interior_no'], 'fax_number' => $post['fax_number'], 'city' => $post['city'], 'website' => $post['website'], 'state' => $post['state'], 'contact_name' => $post['contact_name'], 'position' => $post['position'], 'contact_email' => $post['contact_email'], 'contact_mobile' => $post['contact_mobile'], 'contact_birthdate' => $date)
            );
            Session::flash('alert-success', 'success');
            Session::flash('message', 'Customer Added Successfully!!');
            return redirect('/customer');
        }
        return view('customer.addCustomer', ['page_title' => 'Add Customers']);
    }

    public function editCust($id = null)
    {
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
                'interior_no' => 'required',
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

                if (!empty($messages)) {
                    foreach ($messages->all() as $error) {
                        return Redirect::to('customer/edit/' . $id)
                                        ->withInput(Input::except('password'));
                        Session::flash('message', $error);
                        Session::flash('alert-class', 'alert-danger');
                        // return View::make('customer.addCustomer', ['page_title' => 'Edit Customer', 'id' => $id])->with('post', $post);
                        ;
                    }
                }
            }

            $dt = $post['contact_birthdate'];
            $my_date = date('m/d/Y', strtotime($dt));
            $time = strtotime($my_date);
            $date = date('Y/m/d', $time);
           
            if (isset($post['password'])) {           
                $myquery = DB::table('user')->select('password')->where('id', $post['id'])->first();
                $post['password'] = $myquery->password;
            } else {
                $post['password'] = Hash::make($post['password']);
            }

            //Upload the image
            $file = Input::file('image');
            $destinationPath = 'images/customer';
            $imageName = $post['image']->getClientOriginalName();
            //delete old image
            if (isset($post['image'])) {
                $myimage = DB::table('customers')->select('customer_image')->where('user_id', $post['id'])->first();
                File::delete('images/customer/' . $myimage->customer_image);
            }
            $filename = str_replace(' ', '', $post['contact_name']) . time() . '_' . $imageName;
            Input::file('image')->move($destinationPath, $filename);
            $post['image'] = $filename;

            DB::table('user')
                    ->where('id', $post['id'])
                    ->update(array('email' => $post['contact_email'], 'name' => $post['contact_name'], 'birthdate' => $date, 'mobileno' => $post['contact_mobile'], 'password' => $post['password'], 'image' => $post['image']));

            DB::table('customers')
                    ->where('user_id', $post['id'])
                    ->update(array('comp_name' => $post['comp_name'], 'zipcode' => $post['zipcode'], 'building_no' => $post['building_no'], 'country' => $post['country'], 'street_addrs' => $post['street_addrs'], 'phone_no' => $post['phone_no'], 'interior_no' => $post['interior_no'], 'fax_number' => $post['fax_number'], 'city' => $post['city'], 'website' => $post['website'], 'state' => $post['state'], 'contact_name' => $post['contact_name'], 'position' => $post['position'], 'contact_email' => $post['contact_email'], 'contact_mobile' => $post['contact_mobile'], 'contact_birthdate' => $date, 'customer_image' => $post['image'])
            );

            Session::flash('message', 'Customer Updated Successfully!!');
            Session::flash('alert-success', 'success');
            return redirect('/customer');
        } else if (isset($id)) {
            $cust = DB::table('customers')->where('user_id', $id)->first();
            return View::make('customer.addCustomer', ['page_title' => 'Edit Customer', 'id' => $id])->with('cust', $cust);
        }
        return view('customer.addCustomer', ['page_title' => 'List Customer']);
    }

    public function deleteCust($id = null)
    {
        DB::table('customers')->where('user_id', $id)->delete();

        Session::flash('message', 'Customer Deleted Successfully!!');
        Session::flash('alert-success', 'success');
        return redirect('/customer');
    }

    public function getCustData()
    {
        $custlist = DB::table('customers')->select(array('id', 'comp_name', 'building_no', 'street_addrs', 'interior_no', 'city', 'state', 'zipcode', 'country', 'phone_no', 'user_id'));
        return Datatables::of($custlist)
                        ->editColumn("user_id", '<a href="/customer/delete/{{ $user_id }}" class="btn btn-danger"><span class="fa fa-trash-o" onClick = "return confirmDelete({{ $id }})" id="btnDelete"></span></a><a href="/customer/edit/{{ $user_id }}" class="btn btn-primary" onClick = "return confirmEdit({{ $id }})" id="btnEdit"><span class="fa fa-pencil"></span></a>')
                        ->make();
    }

}
