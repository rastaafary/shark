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

public function listBOM() {
$part_id = Request::segment(2);
        return View::make("BOM.listBOM", ['page_title' => 'List BOM'])
                        ->with("part_id", $part_id);

        // return view('BOM.listBOM', ['page_title' => 'BOM']);
    }

    public function addBOM() {
        $part_id = Request::segment(2);
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
                        ->with("part_id", $part_id);
    }

    public function editBOM() {
        exit("edit");
    }

    public function deleteBOM() {
        exit("delete");
    }

    public function getBOMData() {
        exit("getData");
    }

    public function getSKUDescription() {
        $id = Input::get('skuId');
        $sku_description = DB::table('part_number')
                ->where('id', $id)
                ->first();
        return Response(json_encode($sku_description));
    }

    public function getRawMaterial() {
        $material_name = Request::segment(4);
        $data = DB::table('rawmaterial')->select('id', 'partnumber')
                ->where('partnumber', 'like', $material_name . '%')
                ->orWhere('id', 'like', $material_name . '%')
                ->get();

        return Response(json_encode($data));
    }

    public function getRawMaterialDescription() {

        $raw_material_id = Input::get('rawMaterialId');
        $raw_material_data = DB::table('rawmaterial')
                ->where('id', $raw_material_id)
                ->first();
        return Response(json_encode($raw_material_data));
    }

    public function getBomList($iidd)
    {
         
         //$part_id = Request::segment(2);
        
         $bomlist = DB::table('bom')
                 ->leftJoin('part_number', 'part_number.id', '=', 'bom.part_id')
                ->leftJoin('rawmaterial', 'rawmaterial.id', '=', 'bom.raw_material')
                 ->leftJoin('unit', 'unit.id', '=', 'rawmaterial.unit')
                ->select(array('part_number.SKU', 'rawmaterial.description','part_number.cost', 'unit.name', 'bom.yield', 'bom.total', 'bom.id'))
                ->where('bom.part_id', '=', $iidd)
                 ->where('bom.is_deleted', '=', '0');
                
        return Datatables::of($bomlist)
                        ->editColumn("id",'<a href="#" class="btn btn-danger" onClick = "return confirmDelete({{ $id }})" id="btnDelete">'
                                . '<span class="fa fa-trash-o"></span></a>'
                                . '&nbsp<a href="#" class="btn btn-primary" onClick = "return confirmEdit({{ $id }})" id="btnEdit">'
                                . '<span class="fa fa-pencil"></span></a>')
                        ->make();

          return View::make("BOM.listBOM", ['page_title' => 'List BOM'])
                        ->with("part_id", $part_id);
    }

}
