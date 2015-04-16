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

class BOMController extends Controller
{

    public function listBOM()
    {
        $part_id = Request::segment(2);
        $route_name = Request::segment(3);
        return View::make("BOM.listBOM", ['page_title' => 'List BOM'])
                        ->with("part_id", $part_id)
                        ->with("route_name", $route_name);
    }

    public function addBOM()
    {
        $part_id = Request::segment(2);
        $route_name = Request::segment(4);
        if (Request::isMethod('post')) {
            $post = Input::all();
            unset($post['_token']);
            unset($post['skuDescripton']);
            unset($post['selectedRawMaterial']);
            unset($post['descritpion']);
            unset($post['bom_cost']);
            unset($post['unit']);
            $bom_Insert_id = DB::table('bom')->insertGetId($post);
            if ($bom_Insert_id > 0) {
                Session::flash('message', "BOM Added Sucessfully.");
                Session::flash('status', 'success');
                return redirect('/part/' . $part_id . '/bom');
            }
        }

        $part_data = DB::table('part_number')->get();
        return view('BOM.addBOM', ['page_title' => 'Add BOM'])
                        ->with("part_data", $part_data)
                        ->with("route_name", $route_name)
                        ->with("part_id", $part_id);
    }

    public function editBOM()
    {

        $part_id = Request::segment(2);
        $id = Request::segment(5);

//        echo $id;exit;
        $post = Input::all();
        if (Request::isMethod('post')) {

            unset($post['_token']);
            unset($post['skuDescripton']);
            unset($post['selectedRawMaterial']);
            unset($post['descritpion']);
            unset($post['bom_cost']);
            unset($post['unit']);

            if (isset($post['id']) && $post['id'] != null) {
                $rules = array(
                    'id' => 'required',
                    'part_id' => 'required',
                    'raw_material' => 'required',
                    'scrap_rate' => 'required',
                    'yield' => 'required');

                $validator = Validator::make(Input::all(), $rules);

                if ($validator->fails()) {
                    // $messages = $validator->messages();

                    return redirect('/part/' . $part_id . '/bom/edit/' . $post['id'])
                                    ->withErrors($validator);
                } else {

                    DB::table('bom')
                            ->where('id', $post['id'])
                            ->update($post);
                    Session::flash('message', 'BOM Update Successfully!!');
                    Session::flash('status', 'success');
                    return redirect('/part/' . $part_id . '/bom');
                }
            } else if (isset($id) && $id != null) {
                $bom = DB::table('bom')->where('id', $id)->first();
                //if(!isset($post['id'])){
                return redirect('/part/' . $id . '/bom/edit/' . $post['id'])->with('bom', $bom);
                // } // return View::make('BOM.addBOM')->with('bom', $bom);
            } else {

                $bomlist = DB::table('bom')->get();
                return view('BOM.bom')->with('bomlist', $bomlist);
            }

            $part_data = DB::table('part_number')->get();
            return view('BOM.addBOM', ['page_title' => 'Edit BOM'])
                            ->with("part_data", $part_data)
                            ->with("part_id", $part_id);
        }

        $part_data = DB::table('part_number')->get();
        $bom = DB::table('bom')->where('id', $id)->first();
        return view('BOM.addBOM', ['page_title' => 'Edit BOM'])
                        ->with("id", $id)
                        ->with("part_data", $part_data)
                        ->with("bom", $bom)
                        ->with("part_id", $part_id);
    }

    public function deleteBOM($id = null)
    {
        $part_id = Request::segment(2);
        $id = Request::segment(5);
        $check_route = Request::segment(6);

        $status = DB::table('bom')->where('id', $id)->update(array('is_deleted' => '1'));
        if ($status) {
            Session::flash('message', 'BOM delete Successfully.');
            Session::flash('status', 'success');
        } else {
            Session::flash('message', "BOM delete Unsucessfully.");
            Session::flash('status', 'error');
        }
        if ($check_route == 'add') {
            return redirect('/part/' . $part_id . '/bom/add');
        } else if ($check_route == 'edit') {
            return redirect('/part/' . $part_id . '/bom/edit/' . $id);
        } else {
            return redirect('/part/' . $part_id . '/bom');
        }
    }

    public function getBOMData()
    {
        exit("getData");
    }

    public function getSKUDescription()
    {
        $id = Input::get('skuId');
        $sku_description = DB::table('part_number')
                ->where('id', $id)
                ->first();
        return Response(json_encode($sku_description));
    }

    public function getRawMaterial()
    {
        $material_name = Request::segment(4);
        $data = DB::table('rawmaterial')->select('id', 'partnumber')
                ->where('partnumber', 'like', $material_name . '%')
                ->orWhere('id', 'like', $material_name . '%')
                ->get();

        return Response(json_encode($data));
    }

    public function getRawMaterialDescription()
    {

        $raw_material_id = Input::get('rawMaterialId');
        $raw_material_data = DB::table('rawmaterial')
                ->where('id', $raw_material_id)
                ->first();
        return Response(json_encode($raw_material_data));
    }

    public function getBomList($iidd, $route_name)
    {
        $bomlist = DB::table('bom')
                ->leftJoin('part_number', 'part_number.id', '=', 'bom.part_id')
                ->leftJoin('rawmaterial', 'rawmaterial.id', '=', 'bom.raw_material')
                ->leftJoin('unit', 'unit.id', '=', 'rawmaterial.unit')
                ->select(array('part_number.SKU', 'rawmaterial.description', 'part_number.cost', 'unit.name', 'bom.yield', 'bom.total', 'bom.id'))
                ->where('bom.part_id', '=', $iidd)
                ->where('bom.is_deleted', '=', '0');

        return Datatables::of($bomlist)
                        ->editColumn("id", '<a href="/part/' . $iidd . '/bom/delete/{{ $id }}/' . $route_name . '" class="btn btn-danger" onClick = "return confirmDelete({{ $id }})" id="btnDelete">'
                                . '<span class="fa fa-trash-o"></span></a>'
                                . '&nbsp<a href="/part/' . $iidd . '/bom/edit/{{ $id }}" class="btn btn-primary" onClick = "return confirmEdit({{ $id }})" id="btnEdit">'
                                . '<span class="fa fa-pencil"></span></a>')
                        ->make();

        return View::make("BOM.listBOM", ['page_title' => 'List BOM'])
                        ->with("part_id", $part_id);
    }

}
