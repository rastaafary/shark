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
use PDF;

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
            unset($post['raw_material']);
            unset($post['descritpion']);
            unset($post['bom_cost']);
            unset($post['unit']);
            unset($post['BOM_list_length']);

            $rules = array(
                'part_id' => 'required',
                'skuDescripton' => 'required',
                'raw_material' => 'required'
            );

            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                return redirect('/part/' . $part_id . '/bom/add/')
                                ->withErrors($validator)
                                ->withInput(Input::all());
            } else {
                if (array_key_exists('orders', $post)) {
                    $orders = json_decode($post['orders'], true);
                    $deleteOrderIds = explode(',', $post['deleteOrder']);

                    if (count($deleteOrderIds) > 0) {
                        foreach ($deleteOrderIds as $deleteOrder) {
                            DB::table('bom')->where('id', $deleteOrder)->update(array('is_deleted' => '1'));
                        }
                    }
                    foreach ($orders as $orderlist) {
                        $orderId = $orderlist['orderId'];
                        unset($orderlist['orderId']);
                        unset($orderlist['selectedRawMaterial']);
                        unset($orderlist['descritpion']);

                        if ($orderId == 0) {
                            $orderlist['part_id'] = $post['part_id'];
                            DB::table('bom')->insertGetId($orderlist);
                        }
                    }
                } else {
                    Session::flash('message', 'Something Went Wrong..!!');
                    Session::flash('status', 'error');
                    return redirect('/part/' . $part_id . '/bom');
                }
            }
            Session::flash('message', "BOM Added Sucessfully.");
            Session::flash('status', 'success');
            return redirect('/part/' . $part_id . '/bom');
        }
        $bomlist = DB::table('bom')
                        ->leftJoin('part_number', 'part_number.id', '=', 'bom.part_id')
                        ->leftJoin('rawmaterial', 'rawmaterial.id', '=', 'bom.raw_material')
                        ->leftJoin('unit', 'unit.id', '=', 'rawmaterial.unit')
                        ->select(array('rawmaterial.partnumber', 'rawmaterial.id as rowId', 'rawmaterial.description', 'rawmaterial.bomcost', 'bom.scrap_rate', 'unit.name', 'bom.yield', 'bom.total', 'bom.id'))
                        ->where('bom.part_id', '=', $part_id)
                        ->where('bom.is_deleted', '=', '0')->get();

        $part_data = DB::table('part_number')->where("is_deleted", 0)->get();
        return view('BOM.addBOM', ['page_title' => 'Add BOM'])
                        ->with("part_data", $part_data)
                        ->with("SKU", $part_data)
                        ->with("bomList", $bomlist)
                        ->with("route_name", $route_name)
                        ->with("part_id", $part_id)
                        ->with("SKU", $part_id);
    }

    public function editBOM()
    {
        $part_id = Request::segment(2);
        $route_name = Request::segment(4);
        $id = Request::segment(5);

        if (Request::isMethod('post')) {
            $post = Input::all();
            unset($post['_token']);
            unset($post['skuDescripton']);
            unset($post['selectedRawMaterial']);
            unset($post['descritpion']);
            unset($post['bom_cost']);
            unset($post['unit']);
            unset($post['BOM_list_length']);

            if (isset($post['id']) && $post['id'] != null) {
                $rules = array(
                    'id' => 'required',
                    'part_id' => 'required',
                    'skuDescripton' => 'required',
                );

                $validator = Validator::make(Input::all(), $rules);

                if ($validator->fails()) {
                    return redirect('/part/' . $part_id . '/bom/edit/' . $post['id'])
                                    ->withErrors($validator)
                                    ->withInput(Input::all());
                } else {
                    if (array_key_exists('orders', $post)) {
                        $orders = json_decode($post['orders'], true);
                        $deleteOrderIds = explode(',', $post['deleteOrder']);

                        if (count($deleteOrderIds) > 0) {
                            foreach ($deleteOrderIds as $deleteOrder) {
                                DB::table('bom')->where('id', $deleteOrder)->update(array('is_deleted' => '1'));
                            }
                        }
                        foreach ($orders as $orderlist) {
                            $orderlist['part_id'] = $post['part_id'];
                            if ($orderlist['part_id'] > 0) {
                                $orderId = $orderlist['orderId'];

                                unset($orderlist['orderId']);
                                unset($orderlist['selectedRawMaterial']);
                                unset($orderlist['descritpion']);

                                if ($orderId > 0) {
                                    DB::table('bom')
                                            ->where('id', $orderId)
                                            ->update($orderlist);
                                } else {

                                    DB::table('bom')->insert($orderlist);
                                }
                            }
                        }
                        Session::flash('message', 'BOM Update Successfully!!');
                        Session::flash('status', 'success');
                        return redirect('/part/' . $part_id . '/bom');
                    }
                }
            }
            Session::flash('message', 'Something Went Wrong..!!');
            Session::flash('status', 'error');
            return redirect('/part/' . $part_id . '/bom');
        }

        $part_data = DB::table('part_number')->get();
        $bom = DB::table('bom')->where('id', $id)->first();
        $bomlist = DB::table('bom')
                        ->leftJoin('part_number', 'part_number.id', '=', 'bom.part_id')
                        ->leftJoin('rawmaterial', 'rawmaterial.id', '=', 'bom.raw_material')
                        ->leftJoin('unit', 'unit.id', '=', 'rawmaterial.unit')
                        ->select(array('rawmaterial.partnumber', 'rawmaterial.id as rowId', 'rawmaterial.description', 'rawmaterial.bomcost', 'bom.scrap_rate', 'unit.name', 'bom.yield', 'bom.total', 'bom.id'))
                        ->where('bom.part_id', '=', $part_id)
                        ->where('bom.is_deleted', '=', '0')->get();

        return view('BOM.addBOM', ['page_title' => 'Edit BOM'])
                        ->with("id", $id)
                        ->with("part_data", $part_data)
                        ->with("bom", $bom)
                        ->with("route_name", $route_name)
                        ->with("bomList", $bomlist)
                        ->with("part_id", $part_id)
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

    //demo of BOM page

    public function addOrder()
    {
        $part_id = Request::segment(2);
        $route_name = Request::segment(4);
        $post = Input::all();

        unset($post['_token']);
        unset($post['skuDescripton']);
        unset($post['selectedRawMaterial']);

        unset($post['descritpion']);
        unset($post['bom_cost']);
        unset($post['unit']);
        unset($post['BOM_list_length']);
        unset($post['part_id']);

        $bom = DB::table('bom')->insertGetId($post);
    }

    public function getorderlist($iidd, $route_name)
    {
        $bomlist = DB::table('bom')
                ->leftJoin('part_number', 'part_number.id', '=', 'bom.part_id')
                ->leftJoin('rawmaterial', 'rawmaterial.id', '=', 'bom.raw_material')
                ->leftJoin('unit', 'unit.id', '=', 'rawmaterial.unit')
                ->select(array('rawmaterial.partnumber', 'rawmaterial.description', 'part_number.cost', 'bom.scrap_rate', 'bom.yield', 'bom.total', 'unit.name', 'bom.id'))
                ->where('bom.part_id', '=', $iidd)
                ->where('bom.is_deleted', '=', '0');

        return Datatables::of($bomlist)
                        ->editColumn("id", '<a href="{{url("/")}}/part/' . $iidd . '/bom/delete/{{ $id }}/' . $route_name . '" class="btn btn-danger" onClick = "return confirmDelete({{ $id }})" id="btnDelete">'
                                . '<span class="fa fa-trash-o"></span></a>'
                                . '&nbsp<a href="{{url("/")}}/part/' . $iidd . '/bom/edit/{{ $id }}" class="btn btn-primary" onClick = "return confirmEdit({{ $id }})" id="btnEdit">'
                                . '<span class="fa fa-pencil"></span></a>')
                        ->editColumn("partnumber", function($row)
                        {
                            $part_no = substr($row->partnumber, 0, 3) . "-";
                            $part_no .= substr($row->partnumber, 3, 3) . "-";
                            $part_no .= substr($row->partnumber, 6, 4);

                            $row->partnumber = $part_no;
                            return $row->partnumber;
                        })
                        ->make();

        return View::make("BOM.listBOM", ['page_title' => 'List BOM'])
                        ->with("part_id", $part_id);
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
                ->leftJoin('unit', 'unit.id', '=', 'rawmaterial.unit')
                ->select(array('rawmaterial.id', 'rawmaterial.partnumber', 'rawmaterial.description', 'unit.name as unit', 'rawmaterial.bomcost'))
                ->where('rawmaterial.id', $raw_material_id)
                ->first();
        return Response(json_encode($raw_material_data));
    }

    public function getBomList($iidd, $route_name)
    {
        $bomlist = DB::table('bom')
                ->leftJoin('part_number', 'part_number.id', '=', 'bom.part_id')
                ->leftJoin('rawmaterial', 'rawmaterial.id', '=', 'bom.raw_material')
                ->leftJoin('unit', 'unit.id', '=', 'rawmaterial.unit')
                ->select(array('rawmaterial.partnumber', 'rawmaterial.description', 'rawmaterial.bomcost', 'unit.name', 'bom.yield', 'bom.total', 'bom.id'))
                ->where('bom.part_id', '=', $iidd)
                ->where('bom.is_deleted', '=', '0');

        return Datatables::of($bomlist)
                        ->editColumn("id", '<a href="{{url("/")}}/part/' . $iidd . '/bom/delete/{{ $id }}/' . $route_name . '" class="btn btn-danger" onClick = "return confirmDelete({{ $id }})" id="btnDelete">'
                                . '<span class="fa fa-trash-o"></span></a>'
                                . '&nbsp<a href="{{url("/")}}/part/' . $iidd . '/bom/edit/{{ $id }}" class="btn btn-primary" onClick = "return confirmEdit({{ $id }})" id="btnEdit">'
                                . '<span class="fa fa-pencil"></span></a>')
                        ->editColumn("partnumber", function($row)
                        {
                            $part_no = substr($row->partnumber, 0, 3) . "-";
                            $part_no .= substr($row->partnumber, 3, 3) . "-";
                            $part_no .= substr($row->partnumber, 6, 4);

                            $row->partnumber = $part_no;
                            return $row->partnumber;
                        })
                        ->make();

        return View::make("BOM.listBOM", ['page_title' => 'List BOM'])
                        ->with("part_id", $part_id);
    }

    public function getBomData()
    {
        $partId = Input::get('partId');
        $bomData = DB::table('bom')
                        ->leftJoin('rawmaterial', 'rawmaterial.id', '=', 'bom.raw_material')
                        ->leftJoin('unit', 'unit.id', '=', 'rawmaterial.unit')
                        ->select(array('rawmaterial.partnumber', 'rawmaterial.description', 'rawmaterial.bomcost', 'bom.scrap_rate', 'bom.yield', 'bom.total', 'unit.name', 'bom.id'))
                        ->where('bom.part_id', '=', $partId)->get();
        return Response(json_encode($bomData));
    }

    public function printBOMList($id)
    {
        $bomlist = DB::table('bom')
                ->leftJoin('part_number', 'part_number.id', '=', 'bom.part_id')
                ->leftJoin('rawmaterial', 'rawmaterial.id', '=', 'bom.raw_material')
                ->leftJoin('unit', 'unit.id', '=', 'rawmaterial.unit')
                ->select(array('rawmaterial.partnumber', 'rawmaterial.description', 'rawmaterial.bomcost', 'unit.name', 'bom.yield', 'bom.total', 'bom.id'))
                ->where('bom.part_id', '=', $id)
                ->where('bom.is_deleted', '=', '0')
                ->get();
        $total = 0;
        foreach ($bomlist as $boms) {
            $total = $total + $boms->total;
        }
        $partinfo = DB::table('part_number')
                ->select('SKU', 'description', 'cost')
                ->where('id', $id)
                ->get();

        $pdf = PDF::loadView('BOM.printBOM', array('bomlist' => $bomlist, 'partinfo' => $partinfo, 'total' => $total));
        return $pdf->download("bom_$id.pdf");
        //return $pdf->stream('contract.pdf');
        // return PDF::loadView('BOM.printBOM',$data)->save('/my_stored_file.pdf')->stream('download.pdf');
    }

}
