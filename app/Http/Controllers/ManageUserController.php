<?php

namespace App\Http\Controllers;

use File;
use Hash;
use DB;
use View;
use Input;
use Session;
use Validator;
use Datatables;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Image;
use Illuminate\Database\Query\Builder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ManageUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * List of Users
     */

    public function userList()
    {
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
            $my_date = date('m/d/Y', strtotime($dt));
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

            //Upload the image
            if (isset($post['image'])) {
                $file = Input::file('image');
                $destinationPath = 'images/user';
                $filename = str_replace(' ', '', $post['name']) . time() . '_' . $post['image']->getClientOriginalName();
                Input::file('image')->move($destinationPath, $filename);
                $post['image'] = $filename;
            }
            DB::table('user')->insert(
                    array($post)
            );
            Session::flash('message', 'User Added Successfully!!');
            Session::flash('status', 'success');
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
                'email' => 'required|Email|unique:user,email,' . $emailId,
                'mobileno' => 'required',
                'position' => 'required',
                'birthdate' => 'required',
                //'image'=>'image|mimes:jpeg,jpg,png',
                'reTypePassword' => 'same:password|required_with:password,value',
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                $messages = $validator->messages();
                if (!empty($messages)) {
                    foreach ($messages->all() as $error) {
                        return redirect('/userProfile/edit/' . $post['id'])
                                        ->withErrors($validator)
                                        ->withInput(Input::except('password'));
                        //return redirect('/userProfile/edit/' . $post['id']);
                    }
                }
            } else {
                // check the passowrd and reTypePassword is not blank
                if ($post['password'] == null && $post['reTypePassword'] == null) {
                    unset($post['reTypePassword']);
                    $myquery = DB::table('user')->select('password')->where('id', $post['id'])->first();
                    $post['password'] = $myquery->password;
                } else {
                    $post['password'] = Hash::make($post['password']);
                }
                unset($post['reTypePassword']);

                //Upload the image
                $file = Input::file('image');
                $destinationPath = 'images/user';
                //delete old image
                if (isset($post['image'])) {
                    $myimage = DB::table('user')->select('image')->where('id', $post['id'])->first();
                    File::delete('images/user/' . $myimage->image);
                    $filename = str_replace(' ', '', $post['name']) . time() . '_' . $post['image']->getClientOriginalName();
                    Input::file('image')->move($destinationPath, $filename);
                    $post['image'] = $filename;
                } else {
                    unset($post['image']);
                }
                unset($post['reTypePassword']);

                $dt = $post['birthdate'];
                $my_date = date('m/d/Y', strtotime($dt));
                $time = strtotime($my_date);
                $date = date('Y/m/d', $time);
                $post['birthdate'] = $date;
                DB::table('user')
                        ->where('id', $post['id'])
                        ->update($post);

                Session::flash('message', 'Profile Update Successfully!!');
                Session::flash('status', 'success');
                if (Auth::User()->role == 1) {
                    return redirect('/userList');
                } else {
                    return redirect('/po');
                }
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
        //DB::table('user')->where('id', $id)->delete();
        DB::table('user')
                ->where('id', $id)
                ->update(array('is_deleted' => '1'));

        Session::flash('message', 'User Delete Successfully!!');
        Session::flash('status', 'success');
        return redirect('/userList');
    }

    public function getUserData()
    {
        $userlist = DB::table('user')
                ->select(array('name', 'email', 'id'))
                ->where('role', '!=', '3')
                ->where('is_deleted', '!=', '1');
        /* $queries = DB::getQueryLog();
          $last_query = end($queries); */

        return Datatables::of($userlist)
                        ->editColumn("id", '<a href="/userList/delete/{{ $id }}" class="btn btn-danger" onClick = "return confirmDelete({{ $id }})" id="btnDelete"><span class="fa fa-trash-o"></span></a>&nbsp<a href="/userList/edit/{{ $id }}" class="btn btn-primary" onClick = "return confirmEdit({{ $id }})" id="btnEdit"><span class="fa fa-pencil"></span></a>')
                        ->make();
    }

}
