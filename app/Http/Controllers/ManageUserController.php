<?php

namespace App\Http\Controllers;

use Hash;
use DB;
use View;
use Input;
use Session;
use Validator;
use Datatables;
use Auth;

class ManageUserController extends Controller
{
    /*
     * List of Users
     */

    public function userList()
    {
        //$userlist = DB::table('user')->get();
        //return view('manageUser.userList', ['page_title' => 'Manage User'])->with('userlist', $userlist);
        return view('manageUser.userList', ['page_title' => 'Manage User']);
    }

    public function userProfile()
    {
        return view('manageUser.userProfile', ['page_title' => 'Manage User']);
    }

    /*
     * Add User
     */

    public function addUser()
    {

        $post = Input::all();
        if (isset($post['_token'])) {
            unset($post['_token']);

            $rules = array(
                'email' => 'required|Email|unique:user,email',
                'password' => 'required',
                'name' => 'required',
                'birthdate' => 'required',
                'mobileno' => 'required',
                'position' => 'required',
                'role' => 'required',
            );
            $dt = $post['birthdate'];
            $my_date = date('m/d/y', strtotime($dt));
            $time = strtotime($my_date);
            $date = date('Y/m/d', $time);

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
            }
            $post['password'] = Hash::make($post['password']);
            $post['birthdate'] = $date;
            /*  DB::table('user')->insert(
              array($post)
              ); */
            DB::table('user')->insert(
                    array($post)
            );

            Session::flash('alert-success', 'success');
            Session::flash('message', 'User Added Successfully!!');
            // Session::flash('alert-success', 'success');
            return redirect('/userList');
        }
        return view('manageUser.addUser', ['page_title' => 'Add User']);
    }

    /*
     * Edit User
     */

    public function editUser($id = null)
    {
        $post = Input::all();
        if (isset($post['_token']))
            unset($post['_token']);
        if (isset($post['id']) && $post['id'] != null) {
            $emailId = $post['id'];
            $rules = array(
                'name' => 'required',
                'email' => 'required|Email|unique:user,email,'.$emailId,
                'mobileno' => 'required',
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
                        return redirect('/userList');
                    }
                }
            } else {
                // check the passowrd and reTypePassword is not blank
                if ($post['password'] == null && $post['reTypePassword'] == null) {
                    unset($post['reTypePassword']);
                    $myquery = DB::table('user')->select('password')->where('id', $post['id'])->first();
                    $post['password'] = $myquery->password;
                }
                unset($post['reTypePassword']);
                $post['password'] = Hash::make($post['password']);
                DB::table('user')
                        ->where('id', $post['id'])
                        ->update($post);
                Session::flash('message', 'Profile Update Successfully!!');
                /* Session::flash('alert-warning', 'warning');
                 * Session::flash('alert-info', 'info'); */
                Session::flash('alert-success', 'success');
                return redirect('/userList');
            }
        } else if (isset($id) && $id != null) {
            $user = DB::table('user')->where('id', $id)->first();
            return View::make('manageUser.userProfile', ['page_title' => 'Edit User'])->with('user', $user);
        }
        return view('manageUser.userProfile', ['page_title' => 'Edit User']);
    }

    /*
     * delete User
     */

    public function deleteUser($id = null)
    {
        DB::table('user')->where('id', $id)->delete();
        Session::flash('message', 'User Delete Successfully!!');
        Session::flash('alert-success', 'success');
        return redirect('/userList');
    }

    public function getUserData()
    {
        $userlist = DB::table('user')->select(array('name', 'email', 'id'))->where('role', '!=', '3');
        /* $queries = DB::getQueryLog();
        $last_query = end($queries); */

        return Datatables::of($userlist)
                        ->editColumn("id", '<a href="/userList/delete/{{ $id }}" class="btn btn-danger"><span class="fa fa-trash-o"></span></a>&nbsp<a href="/userList/edit/{{ $id }}" class="btn btn-primary"><span class="fa fa-pencil"></span></a>')
                        ->make();
    }

}
