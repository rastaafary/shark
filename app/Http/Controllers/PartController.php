<?php

namespace App\Http\Controllers;

use DB;
use Input;
use View;
use Validator;
use Session;
use Datatables;
use Auth;

class PartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
      |--------------------------------------------------------------------------
      | Home Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders your application's "dashboard" for users that
      | are authenticated. Of course, you are free to change or remove the
      | controller as you wish. It is just here to get your app started!
      |
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function partList()
    {
        //$path = base_path();
        //echo $path;exit;
//        if(Auth::User()->hasRole('customer'))
//        {
//            exit('call');
//        }else if(Auth::User()->hasRole('admin')){
//            exit('admin');
//        }
        return view('Part.Parteditlist', ['page_title' => 'Part Number']);
    }

    /*
     * Edit part 
     */

    public function editPart($id = null)
    {
        $post = Input::all();

        if (isset($post['_token']))
            unset($post['_token']);

        if (isset($post['id']) && $post['id'] != null) {
            $rules = array(
                'id' => 'required',
                'SKU' => 'required|Min:6|alpha_num|unique:part_number,SKU,' . $post['id'],
                'description' => 'required',
                'cost' => 'required|numeric',
                'currency_id' => 'required');

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                // $messages = $validator->messages();
                return redirect('/part/edit/' . $post['id'])
                                ->withErrors($validator);
                /*   if (!empty($messages)) {
                  foreach ($messages->all() as $error) {

                  //return redirect('/userProfile/edit/' . $post['id']);
                  }
                  } */
            } else {
                DB::table('part_number')
                        ->where('id', $post['id'])
                        ->update($post);
                Session::flash('message', 'Part Update Successfully!!');
                Session::flash('status', 'success');
                return redirect('/part');
            }
        } else if (isset($id) && $id != null) {
            $part = DB::table('part_number')->where('id', $id)->first();
            return View::make('Part.Partadd')->with('part', $part);
        } else {
            $partlist = DB::table('part_number')->get();
            return view('Part.Part')->with('partlist', $partlist);
        }
        return view('Part.Part', ['page_title' => 'Edit Part Number']);
    }

    /*
     * Add part
     */

    public function addPart()
    {
        $post = Input::all();
        if (isset($post['_token'])) {
            unset($post['_token']);
            //if (isset($post['SKU']) && $post['SKU'] != null) {
            $rules = array(
                'SKU' => 'required|Min:6|alpha_num|unique:part_number,SKU,' . $post['id'],
                'description' => 'required',
                'cost' => 'required|numeric',
                'currency_id' => 'required'
            );

            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return redirect('/part/add')
                                ->withErrors($validator)
                                ->withInput(Input::all());
            }
            DB::table('part_number')->insert(
                    array($post)
            );
            Session::flash('message', 'Part Added Successfully!!');
            Session::flash('status', 'success');
            return redirect('/part');
        }
        return view('Part.Partadd', ['page_title' => 'Add Part Number']);
    }

    /*
     *  Add part
     */

    public function partAdddata()
    {
        return view('Part.Partadd');
    }

    /*
     * delete part 
     */

    public function deletePart($id = null)
    {
        //DB::table('part_number')->where('id', $id)->delete();
        DB::table('part_number')
                ->where('id', $id)
                ->update(array('is_deleted' => '1'));
        Session::flash('message', 'Part delete Successfully!!');
        Session::flash('alert-success', 'success');
        return redirect('/part');
    }

    /*
     * get all part listing
     */

    public function getPartData()
    {
        $partlist = DB::table('part_number')
                ->leftJoin('bom', 'bom.part_id', '=', 'part_number.id')
                ->select(array('part_number.SKU', 'part_number.description', 'part_number.cost', DB::raw('ROUND(SUM(bom.total),2) as bomTotal'), 'part_number.id'))
                ->where('bom.is_deleted', ' !=', '1')
                ->groupBy('part_number.id');
        return Datatables::of($partlist)
                        ->editColumn("id", '<a href="{{url("/")}}/part/{{ $id }}/bom" class="btn btn-info" id="btnBom">BOM</a>&nbsp;'
                                . '<a href="{{url("/")}}/part/delete/{{ $id }}" class="btn btn-danger" onClick = "return confirmDelete({{ $id }})" id="btnDelete">'
                                . '<span class="fa fa-trash-o"></span></a>'
                                . '&nbsp<a href="{{url("/")}}/part/edit/{{ $id }}" class="btn btn-primary" onClick = "return confirmEdit({{ $id }})" id="btnEdit">'
                                . '<span class="fa fa-pencil"></span></a>')
                        ->make();
    }

}
