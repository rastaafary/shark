<?php

namespace App\Http\Controllers;

use DB;
use View;
use Input;
use Session;

class ManageUserController extends Controller
{

    public function userList()
    {
        $userlist = DB::table('user')->get();
        return view('manageUser.userList',['page_title' => 'Manage User'])->with('userlist', $userlist);
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
            //if (isset($post['SKU']) && $post['SKU'] != null) {
            
            DB::table('user')->insert(
                    array($post)
            );
            Session::flash('message', 'User Added Successfully!!');
            Session::flash('alert-success', 'success');
            return redirect('/userList');
        }
        return view('manageUser.userList',['page_title'=>'User List']);
    }
            

    public function editUser($id = null)
    {

        $post = Input::all();

        if (isset($post['_token']))
            unset($post['_token']);
        if (isset($post['id']) && $post['id'] != null) {
            DB::table('user')
                    ->where('id', $post['id'])
                    ->update($post);
            Session::flash('message', 'Profile Update Successfully!!');
            /* Session::flash('alert-warning', 'warning');
             * Session::flash('alert-info', 'info'); */
            Session::flash('alert-success', 'success');
            return redirect('/userList');
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
