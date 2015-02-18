<?php

//namespace App\Http\Controllers\Customer;

namespace App\Http\Controllers;

use DB;
use View;
use Input;
use Session;
use Validator;
use Datatables;
use Hash;
use Auth;

class CustomerController extends Controller
{

    public function listCust()
    {       
        header('Content-type: application/json');
        //$customerlist = DB::table('customers')->get();
      
       return view('customer.listCustomer', ['page_title' => 'Customer List']);//->with('customerlist', $customerlist);
    }

    public function addCust()
    {
        $post = Input::all();
        if (isset($post['_token'])) {
            unset($post['_token']);

            /* $rules = array(
              'email' => 'required|Email|unique:user,email',
              'password' => 'required',
              'name' => 'required|Alpha',
              'birthdate' => 'required',
              'mobileno' => 'required|Size:10',
              'position' => 'required',
              'role' => 'required',
              'image' => 'Image',
              );

              $validator = Validator::make(Input::all(), $rules);
              if ($validator->fails()) {
              $messages = $validator->messages();

              if (!empty($messages)) {
              foreach ($messages->all() as $error) {
              Session::flash('message', $error);
              Session::flash('alert-class', 'alert-danger');
              return View::make('manageUser.addUser')->with('post', $post);
              //  return redirect('/userList/add')->with('post', $post);
              }
              }
              } */
            $dt = $post['contact_birthdate'];
            $my_date = date('m/d/y', strtotime($dt));
            $time = strtotime($my_date);
            $date = date('Y/m/d', $time);

            DB::table('user')->insert(
                    array('role' => '1', 'email' => $post['contact_email'], 'password' => Hash::make($post['password']), 'name' => $post['contact_name'], 'birthdate' => $date, 'mobileno' => $post['contact_mobile'])
            );
            $last_id = DB::table('user')->orderBy('id', 'desc')->first();

            DB::table('customers')->insert(
                    array('user_id' => $last_id->id, 'comp_name' => $post['comp_name'], 'zipcode' => $post['zipcode'], 'building_no' => $post['building_no'], 'country' => $post['country'], 'street_addrs' => $post['street_addrs'], 'phone_no' => $post['phone_no'], 'interior_no' => $post['interior_no'], 'fax_number' => $post['fax_number'], 'city' => $post['city'], 'website' => $post['website'], 'state' => $post['state'], 'contact_name' => $post['contact_name'], 'position' => $post['position'], 'contact_email' => $post['contact_email'], 'contact_mobile' => $post['contact_mobile'], 'contact_birthdate' => $date)
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
        
           
        if (isset($post['id']) && $post['id'] != null) {
            /*     $rules = array(
              'name' => 'required|Alpha|Min:5',
              'email' => 'required|Email|unique:user,email,' . $post['id'],
              'mobileno' => 'required|size:10',
              'position' => 'required',
              'birthdate' => 'required',
              'reTypePassword' => 'same:password|required_with:password,value',
              );
              $validator = Validator::make(Input::all(), $rules);
              if ($validator->fails()) {
              $messages = $validator->messages();
              if (!empty($messages)) {
              foreach ($messages->all() as $error) {
              Session::flash('message', $error);
              Session::flash('alert-class', 'alert-danger');
              return redirect('/customer');
              }
              }
              } */

            var_dump($post['id']);
            exit("post id");
            DB::table('customers')
                    ->where('user_id', $post['id'])
                    ->update($post);

            Session::flash('message', 'Customer Updated Successfully!!');
            Session::flash('alert-success', 'success');
            return redirect('/customer');
        } else if (isset($id) && $id != null) {
            $cust = DB::table('customers')->where('user_id', $id)->first();
            return View::make('customer.addCustomer', ['page_title' => 'Edit Customer'])->with('cust', $cust);
        }
        return view('customer.addCustomer', ['page_title' => 'List Customer']);
    }

    public function deleteCust()
    {
        return view('customer.addCustomer', ['page_title' => 'Delete Customers']);
    }
    public function getcustomer()
    {
        header('Content-type: application/json');
         $partlist = DB::table('customers')->select('comp_name');
        return Datatables::of($partlist)
                        //->editColumn("id", '<a href="part/delete/{{ $id }}">delete</a>&nbsp<a href="part/edit/{{ $id }}">Update</a>')
                        ->make();
    }

}
