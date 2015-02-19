<?php

namespace App\Http\Controllers;

use DB;
use Input;
use View;
use Validator;
use Session;
use Datatables;

class PartController extends Controller
{
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
                'SKU' => 'required|alpha_num|unique:part_number,SKU,' . $post['id'],
                'description' => 'required',
                'cost' => 'required|numeric',
                'currency_id' => 'required');

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->messages();

                if (!empty($messages)) {
                    foreach ($messages->all() as $error) {
                        return redirect('/part/edit/' . $post['id'])
                                        ->withErrors($validator)
                                        ->withInput(Input::except('password'));
                        //return redirect('/userProfile/edit/' . $post['id']);
                    }
                }
            } else {
                DB::table('part_number')
                        ->where('id', $post['id'])
                        ->update($post);
                Session::flash('message', 'Part Update Successfully!!');
                /* Session::flash('alert-warning', 'warning');
                 * Session::flash('alert-info', 'info'); */
                Session::flash('alert-success', 'success');
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
                'SKU' => 'required|alpha_num|unique:part_number,SKU,' . $post['id'],
                'description' => 'required',
                'cost' => 'required|numeric',
                'currency_id' => 'required'
            );

            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                $messages = $validator->messages();

                if (!empty($messages)) {
                    foreach ($messages->all() as $error) {
                        return redirect('/part/add')
                                        ->withErrors($validator)
                                        ->withInput(Input::except('password'));
                        //return redirect('/userProfile/edit/' . $post['id']);
                    }
                }
            }
            DB::table('part_number')->insert(
                    array($post)
            );
            Session::flash('message', 'Part Added Successfully!!');
            Session::flash('alert-success', 'success');
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
                ->select(array('SKU', 'description', 'cost', 'id'))
                ->where('is_deleted', ' !=', '1');
        return Datatables::of($partlist)
                        ->editColumn("id", '<a href="part/delete/{{ $id }}" class="btn btn-danger" onClick = "return confirmDelete({{ $id }})" id="btnDelete">'
                                . '<span class="fa fa-trash-o"></span></a>'
                                . '&nbsp<a href="part/edit/{{ $id }}" class="btn btn-primary" onClick = "return confirmEdit({{ $id }})" id="btnEdit">'
                                . '<span class="fa fa-pencil"></span></a>')
                        ->make();
    }

}
