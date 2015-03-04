<?php

namespace App\Http\Controllers;

use Session;
use Input;
use DB;
use View;
use Datatables;
use Auth;
use Response;
use Request;
use Redirect;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cerateRole()
    {
//        $admin = new Role();
//        $admin->name = 'admin';
//        $admin->display_name = 'Administrator';
//        $admin->description = 'Administrator of the Company';
//        $admin->save();
//        
//        $manager = new Role();
//        $manager->name = 'manager';
//        $manager->display_name = 'Manager';
//        $manager->description = 'User is the Manager';
//        $manager->save();
//        
//        $customer = new Role();
//        $customer->name = 'customer';
//        $customer->display_name = 'Customer';
//        $customer->description = 'User is the Customer';
//        $customer->save();
    }
    
}
