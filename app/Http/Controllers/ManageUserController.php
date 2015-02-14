<?php

namespace App\Http\Controllers;

class ManageUserController extends Controller
{

    public function userList()
    {
        return view('manageUser.userList',['page_title'=>'Manage User']);
    } 
    
    public function userProfile()
    {
        return view('manageUser.userProfile',['page_title'=>'Manage User']);
    } 
}