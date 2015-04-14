<?php

namespace App\Http\Controllers;

use File;
use Session;
use Input;
use DB;
use View;
use Validator;
use Datatables;
use Auth;
use Response;
use Request;
use App\Http\Controllers\Image;
use Illuminate\Database\Query\Builder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\User;

class RawMaterialController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

//    public function userDetails()
//    {
//        $post = Input::all();
//        if (isset($post['_token']))
//            unset($post['_token']);
//        if (isset($id)) {
//            $cust = DB::table('customers')->where('user_id', $id)->first();
//            return View::make('PurchaseOrderCustomer.addPurchaseOrder', ['page_title' => 'Add Purchase Order', 'id' => $id])->with('cust', $cust);
//        }
//        return view('PurchaseOrderCustomer.addPurchaseOrder', ['page_title' => 'Add Purchase Order']);
//    }

    public function addRawMaterial()
    {
        $post = Input::all();
        if (isset($post['_token'])) {
            unset($post['_token']);
            //if (isset($post['SKU']) && $post['SKU'] != null) {
            $rules = array(
                'description' => 'required',
                'purchasingcost' => 'required',
                'unit' => 'required',
                'equivalency' => 'required',
                'stockunit' => 'required',
                'bomcost' => 'required'
            );

            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return redirect('/RawMaterial/add')
                                ->withErrors($validator)
                                ->withInput(Input::all());
            }
            //print_r($post);exit;
            DB::table('rawmaterial')->insert(array($post));
            Session::flash('message', 'RawMaterial Added Successfully!!');
            Session::flash('status', 'success');
            return redirect('/RawMaterial');
        }

        return view('RawMaterial.addRawMaterial', ['page_title' => 'Add Raw Material']);
    }

    public function listRawMaterial()
    {
        return view('RawMaterial.listRawMaterial', ['page_title' => 'Raw Material']);
    }

}
