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

    public function editUser($id = null)
    {

        $post = Input::all();

        if (isset($post['_token']))
            unset($post['_token']);
        if (isset($post['id']) && $post['id'] != null) {
            DB::table('user')
                    ->where('id', $post['id'])
                    ->update($post);
            Session::flash('message', 'Part Update Successfully!!');
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

}
