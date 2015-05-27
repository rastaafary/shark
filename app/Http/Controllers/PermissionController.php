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
use App\model\Role;
use App\model\Permission;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createPermission()
    {
//        // Admin
//        $listUser = new Permission();
//        $listUser->name = 'list-user';
//        $listUser->display_name = 'List User';
//        $listUser->description = 'List All User';
//        $listUser->save();
//
//        // Admin
//        $addUser = new Permission();
//        $addUser->name = 'add-user';
//        $addUser->display_name = 'Add User';
//        $addUser->description = 'Add User';
//        $addUser->save();
//
//        // Admin
//        $editUser = new Permission();
//        $editUser->name = 'edit-user';
//        $editUser->display_name = 'Edit User';
//        $editUser->description = 'Edit User';
//        $editUser->save();
//
//        // Admin
//        $deleteUser = new Permission();
//        $deleteUser->name = 'delete-user';
//        $deleteUser->display_name = 'Delete User';
//        $deleteUser->description = 'Delete User';
//        $deleteUser->save();
//
//        // Admin Manager Customer
//        $editProfile = new Permission();
//        $editProfile->name = 'edit-profile';
//        $editProfile->display_name = 'Edit Profile';
//        $editProfile->description = 'Edit Profile';
//        $editProfile->save();
//        
//        // Admin Manager
//        $listPartNumber = new Permission();
//        $listPartNumber->name = 'list-partNumber';
//        $listPartNumber->display_name = 'List Part Number';
//        $listPartNumber->description = 'List All Part Number';
//        $listPartNumber->save();
//
//        // Admin Manager
//        $addPartNumber = new Permission();
//        $addPartNumber->name = 'add-partNumber';
//        $addPartNumber->display_name = 'Add Part Number';
//        $addPartNumber->description = 'Add Part Number';
//        $addPartNumber->save();
//
//        // Admin Manager
//        $editPartNumber = new Permission();
//        $editPartNumber->name = 'edit-partNumber';
//        $editPartNumber->display_name = 'Edit Part Number';
//        $editPartNumber->description = 'Edit Part Number';
//        $editPartNumber->save();
//
//        // Admin Manager
//        $deletePartNumber = new Permission();
//        $deletePartNumber->name = 'delete-partNumber';
//        $deletePartNumber->display_name = 'Delete Part Number';
//        $deletePartNumber->description = 'Delete Part Number';
//        $deletePartNumber->save();
//        
//        // Admin Manager
//        $listInvoice = new Permission();
//        $listInvoice->name = 'list-invoice';
//        $listInvoice->display_name = 'List Invoice';
//        $listInvoice->description = 'List All Invoice';
//        $listInvoice->save();
//
//        // Admin Manager
//        $addInvoice = new Permission();
//        $addInvoice->name = 'add-invoice';
//        $addInvoice->display_name = 'Add Invoice';
//        $addInvoice->description = 'Add Invoice';
//        $addInvoice->save();
//
//        // Admin Manager
//        $editInvoice = new Permission();
//        $editInvoice->name = 'edit-invoice';
//        $editInvoice->display_name = 'Edit Invoice';
//        $editInvoice->description = 'Edit Invoice';
//        $editInvoice->save();
//
//        // Admin Manager
//        $deleteInvoice = new Permission();
//        $deleteInvoice->name = 'delete-invoice';
//        $deleteInvoice->display_name = 'Delete Invoice';
//        $deleteInvoice->description = 'Delete Invoice';
//        $deleteInvoice->save();
//        
//        // Admin Manager
//        $listPayment = new Permission();
//        $listPayment->name = 'list-payment';
//        $listPayment->display_name = 'List Payment';
//        $listPayment->description = 'List All Payment';
//        $listPayment->save();
//
//        // Admin Manager
//        $addPayment = new Permission();
//        $addPayment->name = 'add-payment';
//        $addPayment->display_name = 'Add Payment';
//        $addPayment->description = 'Add Payment';
//        $addPayment->save();
//
//        // Admin Manager
//        $editPayment = new Permission();
//        $editPayment->name = 'edit-payment';
//        $editPayment->display_name = 'Edit Payment';
//        $editPayment->description = 'Edit Payment';
//        $editPayment->save();
//
//        // Admin Manager
//        $deletePayment = new Permission();
//        $deletePayment->name = 'delete-payment';
//        $deletePayment->display_name = 'Delete Payment';
//        $deletePayment->description = 'Delete Payment';
//        $deletePayment->save();
//        
//        // Admin Manager
//        $viewPayment = new Permission();
//        $viewPayment->name = 'view-payment';
//        $viewPayment->display_name = 'View Payment';
//        $viewPayment->description = 'View Payment';
//        $viewPayment->save();
//        
//        // Admin Manager
//        $listPL = new Permission();
//        $listPL->name = 'list-pl';
//        $listPL->display_name = 'List PL';
//        $listPL->description = 'List All PL';
//        $listPL->save();
//
//        // Admin Manager
//        $addPL = new Permission();
//        $addPL->name = 'add-pl';
//        $addPL->display_name = 'Add PL';
//        $addPL->description = 'Add PL';
//        $addPL->save();
//
//        // Admin Manager
//        $editPL = new Permission();
//        $editPL->name = 'edit-pl';
//        $editPL->display_name = 'Edit PL';
//        $editPL->description = 'Edit PL';
//        $editPL->save();
//
//        // Admin Manager
//        $deletePL = new Permission();
//        $deletePL->name = 'delete-pl';
//        $deletePL->display_name = 'Delete PL';
//        $deletePL->description = 'Delete PL';
//        $deletePL->save();
//        
//         // Admin Manager Customer
//        $listPOCustomer = new Permission();
//        $listPOCustomer->name = 'list-poCustomer';
//        $listPOCustomer->display_name = 'List PO Customer';
//        $listPOCustomer->description = 'List All PO Customer';
//        $listPOCustomer->save();
//
//        // Admin Manager Customer
//        $addPOCustomer = new Permission();
//        $addPOCustomer->name = 'add-poCustomer';
//        $addPOCustomer->display_name = 'Add PO Customer';
//        $addPOCustomer->description = 'Add PO Customer';
//        $addPOCustomer->save();
//
//        // Admin Manager Customer
//        $editPOCustomer = new Permission();
//        $editPOCustomer->name = 'edit-poCustomer';
//        $editPOCustomer->display_name = 'Edit PO Customer';
//        $editPOCustomer->description = 'Edit PO Customer';
//        $editPOCustomer->save();
//
//        // Admin Manager Customer
//        $deletePOCustomer = new Permission();
//        $deletePOCustomer->name = 'delete-poCustomer';
//        $deletePOCustomer->display_name = 'Delete PO Customer';
//        $deletePOCustomer->description = 'Delete PO Customer';
//        $deletePOCustomer->save();
//        
//        // Admin Manager
//        $listCustomer = new Permission();
//        $listCustomer->name = 'list-customer';
//        $listCustomer->display_name = 'List Customer';
//        $listCustomer->description = 'List All Customer';
//        $listCustomer->save();
//
//        // Admin Manager
//        $addCustomer = new Permission();
//        $addCustomer->name = 'add-customer';
//        $addCustomer->display_name = 'Add Customer';
//        $addCustomer->description = 'Add Customer';
//        $addCustomer->save();
//
//        // Admin Manager
//        $editCustomer = new Permission();
//        $editCustomer->name = 'edit-customer';
//        $editCustomer->display_name = 'Edit Customer';
//        $editCustomer->description = 'Edit Customer';
//        $editCustomer->save();
//
//        // Admin Manager
//        $deleteCustomer = new Permission();
//        $deleteCustomer->name = 'delete-customer';
//        $deleteCustomer->display_name = 'Delete Customer';
//        $deleteCustomer->description = 'Delete Customer';
//        $deleteCustomer->save();  

 /*       $admin = Role::find(1);
        $manager = Role::find(2);
        $customer = Role::find(3);

        $permission = Permission::all();

        foreach ($permission as $per) {
            if ($per->name == 'add-user' || $per->name == 'edit-user' || $per->name == 'delete-user' || $per->name == 'list-user') {
                $admin->attachPermission($per->id);
            } else if ($per->name == 'edit-profile') {
                $manager->attachPermission($per->id);
                $admin->attachPermission($per->id);
                $customer->attachPermission($per->id);
            } else if ($per->name == 'add-poCustomer' || $per->name == 'edit-poCustomer' || $per->name == 'delete-poCustomer' || $per->name == 'list-poCustomer') {
                $manager->attachPermission($per->id);
                $admin->attachPermission($per->id);
                $customer->attachPermission($per->id);
            } else{
                $manager->attachPermission($per->id);
                $admin->attachPermission($per->id);
            }
        }
        return Redirect::intended('/part'); */
    }

}
