<?php

namespace App\Http\Controllers;

use DB;
use Input;
use View;
use Validator;
use Session;
use Datatables;
use Auth;

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

    public function editRawMaterial($id = null)
    {
        $post = Input::all();

        if (isset($post['_token']))
            unset($post['_token']);

        if (isset($post['id']) && $post['id'] != null) {
            $rules = array(
                
                'id' => 'required',
                'description' => 'required',
                'purchasingcost' => 'required',
                'unit' => 'required',
                'equivalency' => 'required',
                'stockunit' => 'required',
                'bomcost' => 'required');

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                // $messages = $validator->messages();
                return redirect('/RawMaterial/edit/' . $post['id'])
                                ->withErrors($validator);
               
            } else {
                DB::table('rawmaterial')
                        ->where('id', $post['id'])
                        ->update($post);
                Session::flash('message', 'Raw Material Update Successfully!!');
                Session::flash('status', 'success');
                return redirect('/RawMaterial');
            }
        } else if (isset($id) && $id != null) {
            $rawmaterial = DB::table('rawmaterial')->where('id', $id)->first();
            return View::make('RawMaterial.addRawMaterial')->with('rawmaterial', $rawmaterial);
        } else {
            $rawmateriallist = DB::table('rawmaterial')->get();
            return view('RawMaterial.rawmaterial')->with('rawmateriallist', $rawmateriallist);
        }
        return view('RawMaterial.rawmaterial', ['page_title' => 'Edit Raw Material']);
    }

    public function listRawMaterial()
    {

        return view('RawMaterial.listRawMaterial', ['page_title' => 'Raw Material']);
    }

    public function getRawMaterialData()
    {
        $rawMateriallist = DB::table('rawmaterial')
                ->select(array('partnumber', 'description', 'purchasingcost', 'unit', 'equivalency', 'stockunit', 'bomcost', 'id'));
        return Datatables::of($rawMateriallist)
                        ->editColumn("id", '<a href="RawMaterial/edit/{{ $id }}" class="btn btn-primary" onClick = "return confirmEdit({{ $id }})" id="btnEdit">'
                                . '<span class="fa fa-pencil"></span></a>')
                        ->make();
    }

}
