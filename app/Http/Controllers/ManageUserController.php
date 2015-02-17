<?php

namespace App\Http\Controllers;

use DB;
use View;
use Input;
use Session;
use Validator;
use Datatables;

class ManageUserController extends Controller
{
    /*
     * List of Users
     */

    public function userList()
    {
        $userlist = DB::table('user')->get();
        return view('manageUser.userList', ['page_title' => 'Manage User'])->with('userlist', $userlist);
        //return view('manageUser.userList', ['page_title' => 'Manage User']);
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
            }

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
        // echo '<pre>';print_r($post);exit;
        if (isset($post['_token']))
            unset($post['_token']);
        if (isset($post['id']) && $post['id'] != null) {
            $rules = array(
                'name' => 'required|Alpha|Min:5',
                'email' => 'required|Email',
                'mobileno' => 'required|Size:10',
                'position' => 'required',
                //'password' => 'confirmed',
                'reTypePassword' => 'same:password|required_with:password,value',
            );
            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                //exit('fail');
                $messages = $validator->messages();

                if (!empty($messages)) {
                    foreach ($messages->all() as $error) {
                        Session::flash('message', $error);
                        Session::flash('alert-class', 'alert-danger');
                        return redirect('/userList');
                    }
                }
            } else {
                //exit('call');
                
                if ($post['password'] == null && $post['reTypePassword']==null) {
                    unset($post['reTypePassword']);
                    $myquery = DB::table('user')->select('password')->where('id', $post['id'])->first();
                    $post['password'] = $myquery->password;
                }
                unset($post['reTypePassword']);
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

}
