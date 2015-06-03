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

    public function __construct() {
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
    public function partList() {
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

    public function editPart($id = null) {
        $post = Input::all();

        if (isset($post['_token']))
            unset($post['_token']);
//             $size = $post['labels'];
//            unset($post['labels']);

        if (isset($post['id']) && $post['id'] != null) {
            $rules = array(
                'id' => 'required',
               // 'SKU' => 'required|Min:6|alpha_num|unique:part_number'.$post['id'],
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

//                var_dump($post);
//                exit("in");
                $labels = $post['labels'];
                $label = $post['label'];
//                $partid = $post['id'];
//                $sizeData = $post['labels'];
                unset($post['labels']);
                unset($post['label']);
                if (isset($post['ai'])) {

//                    if (!empty($purchaseOrder->ai)) {
//                        @unlink('files/' . $purchaseOrder->ai);
//                    }

                    $aiName = $post['ai']->getClientOriginalName();
                    $file = Input::file('ai');
                    $destinationPath = 'files';
                    $aiFilename = $aiName;
                    Input::file('ai')->move($destinationPath, $aiFilename);
                    $post['ai'] = $aiFilename;
                } else {
                    $post['ai'] = '';
                }

                $part_data = DB::table('part_number')
                        //->Join('labels', 'part_number.id', '=', 'size_data.part_id')
                        ->where('id', $post['id'])
                        ->update($post);

                if (isset($labels)) {
                    DB::table('size_data')
                            ->where('part_id', '=', $post['id'])
                            ->delete();

                    foreach ($labels as $s) {
                        $si['part_id'] = $post['id'];
                        $si['size_id'] = $s;
                        $sizeId = DB::table('size_data')->insert(
                                $si
                        );
                    }
                }
                if (isset($label)) {
                    DB::table('components_data')
                            ->where('part_id', '=', $post['id'])
                            ->delete();

                    foreach ($label as $s) {
                        $sid['part_id'] = $post['id'];
                        $sid['components_id'] = $s;
                        $sizeIds = DB::table('components_data')->insert(
                                $sid
                        );
                    }
                }




//                $postSize = array();
//                $postSize['part_id'] = $id;
//                $sizeData = DB::table('size_data')->select('id')->where('part_id', ' = ', $partid)->get();
//                 
//                foreach ($sizeData as $size) {
//                    $postSize['part_id'] = $size;
//                    $postSize['size_id'] = $size;
//                    echo '<pre>';
//                        print_r($postSize);exit;
//                    if(isset($sizeData)){
//                        DB::table('size_data')->where('id', ' = ', $sizeData->id)->update($postSize);
//                    }
//                }

                Session::flash('message ', 'Part Update Successfully!!');
                Session::flash('status ', 'success');
                return redirect('/part');
            }
        } else if (isset($id) && $id != null) {

            $part = DB::table('part_number')
                            ->where('id', $id)->first();

            $size = DB::table('size_data')
                    ->leftJoin('size', 'size.id', '=', 'size_data.size_id')
                    ->select('size.id')
                    ->where('size_data.part_id', '=', $id)
                    ->lists('size.id');

            $comp = DB::table('components_data')
                    ->leftJoin('components', 'components.id', '=', 'components_data.components_id')
                    ->select('components.id')
                    ->where('components_data.part_id', '=', $id)
                    ->lists('components.id');

            $size_list = DB::table('size')->select('labels', 'id')->lists('labels', 'id');
            $components_list = DB::table('components')->select('label', 'id')->lists('label', 'id');
            return View::make('Part.Partadd')->with(array('part' => $part, 'sizelist' => $size_list, 'componentslist' => $components_list, 'size' => $size, 'comp' => $comp));
        } else {
            $partlist = DB::table('part_number')->get();
            $sizelist = DB::table('size_data')->get();
            $componentslist = DB::table('components_data')->select('label ', 'id')->lists('label ', 'id');
            return view('Part.Part')->with(array('partlist' => $partlist, 'sizelist' => $sizelist, 'componentslist' => $componentslist));
        }
        return view('Part.Part', ['page_title' => 'Edit Part Number']);
    }

    /*
     * Add part
     */

    public function addPart() {
        $post = Input::all();

        if (isset($post['_token'])) {
            unset($post['_token']);

            $size = $post['labels'];
            unset($post['labels']);

            $components = $post['label'];
            unset($post['label']);

            //if (isset($post['SKU']) && $post['SKU'] != null) {
            $rules = array(
                'SKU' => 'required|Min:6|alpha_num|unique:part_number'.$post['id'],
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
            if (isset($post['ai'])) {
                $aiName = $post['ai']->getClientOriginalName();
                $file = Input::file('ai');
                $destinationPath = 'files';
                $aiFilename = $aiName;
                Input::file('ai')->move($destinationPath, $aiFilename);
                $post['ai'] = $aiFilename;
            } else {
                $post['ai'] = '';
            }
            $part = DB::table('part_number')->insertGetId(
                    $post
            );
            //for Size Table
            foreach ($size as $s) {
                $si['part_id'] = $part;
                $si['size_id'] = $s;
                $sizeId = DB::table('size_data')->insert(
                        $si
                );
            }

            //for Component Table
            foreach ($components as $c) {

                $sid['part_id'] = $part;

                $sid['components_id'] = $c;

                $componentsId = DB::table('components_data')->insert(
                        $sid
                );
            }

            Session::flash('message', 'Part Added Successfully!!');
            Session::flash('status', 'success');
            return redirect('/part');
        }

        $size_list = DB::table('size')->select('labels', 'id')->lists('labels', 'id');
        $components_list = DB::table('components')->select('label', 'id')->lists('label', 'id');

        return view('Part.Partadd', ['page_title' => 'Add Part Number'])->with(array('sizelist' => $size_list, 'componentslist' => $components_list));
    }

    /*
     *  Add part
     */

    public function partAdddata() {
        return view('Part.Partadd');
    }

    /*
     * delete part 
     */

    public function deletePart($id = null) {
        //DB::table('part_number')->where('id', $id)->delete();
        DB::table('part_number')
                ->where('id', $id)
                ->update(array('is_deleted' => '1'));
        DB::table('size_data')
                            ->where('part_id', '=',$id )
                            ->delete();
        DB::table('components_data')
                            ->where('part_id', '=', $id)
                            ->delete();
        Session::flash('message', 'Part delete Successfully!!');
        Session::flash('alert-success', 'success');
        return redirect('/part');
    }

//For size
    public function getSizeData() {
        
        $size = DB::table('size_data')
                        ->leftjoin('size', 'size.id', ' = ', 'size_data.size_id')
                        ->select('size_id')
                        ->where('part_id', ' = ', $id)->get();
        return Response(json_encode($size));
    }

    /*
     * get all part listing
     */

    public function getPartData() {
        $partlist = DB::table('part_number')
                ->leftJoin('bom', 'bom.part_id', ' = ', 'part_number.id')
                ->select(array('part_number.SKU', 'part_number.description', 'part_number.cost', DB::raw('ROUND(SUM(bom.total), 2) as bomTotal'), 'part_number.id'))
                ->where('part_number.is_deleted', ' = ', '0')
                ->groupBy('part_number.id');
        return Datatables::of($partlist)
                        ->editColumn("id", '<a href = "{{url("/")}}/part/{{ $id }}/bom" class = "btn btn-info" id = "btnBom">BOM</a>&nbsp;
        '
                                . '<a href = "{{url("/")}}/part/delete/{{ $id }}" class = "btn btn-danger" onClick = "return confirmDelete({{ $id }})" id = "btnDelete">'
                                . '<span class = "fa fa-trash-o"></span></a>'
                                . '&nbsp<a href = "{{url("/")}}/part/edit/{{ $id }}" class = "btn btn-primary" onClick = "return confirmEdit({{ $id }})" id = "btnEdit">'
                                . '<span class = "fa fa-pencil"></span></a>



        ')
                        ->make();
    }

}
