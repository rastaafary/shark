<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\model\ProductionSequence;
use Auth;
use DB;
use Input;
use Redirect;
use Request;
use Response;
use Session;
use Validator;
use URL;
use yajra\Datatables\Datatables;

class ProductionSequenceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listSequence()
    {
        return view('Sequence.index', ['page_title' => 'Sequence List']);
    }

    public function add()
    {
        $id = Request::segment(3);
        $obj = null;
        if (Request::isMethod('post')) {
            if (!empty(Input::get('id'))) {
                $obj = ProductionSequence::find(Input::get('id'));
                ProductionSequence::where('id', '=', Input::get('id'))->update(['title' => Input::get('title')]);
                Session::flash('success', 'Successfully update.');
                return Redirect::back();
            }
            else {
                $validator = Validator::make(Input::except('_token'), [
                            'title' => 'required|unique:production_sequences,title'
                                ]
                );
                if ($validator->fails()) {
                    return Redirect::back()
                                    ->withErrors($validator)
                                    ->withInput();
                }
                $maxNum = ProductionSequence::select([DB::raw('max(id) as max_num')])->first();
                $obj = new ProductionSequence(Input::except('_token'));
                $obj->seqId = !is_null($maxNum->max_num) ? $maxNum->max_num + 1 : 1;
                $obj->save();
                Session::flash('success', 'Successfully added.');
                return Redirect::to('/sequence/add');
            }
        }
        else if (!is_null($id)) {
            $obj = ProductionSequence::find($id);
            return Redirect::to('/sequence/add')->withInput($obj->toArray());
        }


        return view('Sequence.add', ['page_title' => 'Add Sequence']);
    }

    public function delete($id = null)
    {
        $id = Request::segment(3);
        ProductionSequence::where('id', '=', $id)->update(['isDelete' => true]);
        Session::flash('success', 'Successfully deleted.');
        return Redirect::to('/sequence');
    }

    public function getList()
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager')) {
            $data = ProductionSequence::orderBy('seqId', 'ASC')
                    ->select(['id', 'title', 'created_at', 'seqId'])
                    ->where('isDelete', '!=', 1)
                    ->orWhereNull('isDelete');
            $action = '<a type="button" class="btn btn-success btn-sm" onclick="javascript:window.location=\'' . URL::to('/sequence/add') . '/{{$id}}\'"><i class="fa fa-edit"></i></a>&nbsp;<a type="button" class="btn btn-danger btn-sm" onclick="javascript:window.location=\'' . URL::to('/sequence/delete') . '/{{$id}}\'"><i class="fa fa-trash-o"></i></a>';
            return Datatables::of($data)
                            ->editColumn("created_at", $action)
                            ->make();
        }
        return Response::json([]);
    }

    public function order()
    {
        $data = Input::except('_token');
        $data['oldSeq'] = $data['seqId'];
        sort($data['oldSeq']);
        foreach ($data['oldSeq'] as $key => $val) {
            if ($data['seqId'][$key] != $data['oldSeq'][$key])
                ProductionSequence::where('id', '=', $data['seqId'][$key])->update(['seqId' => $data['oldSeq'][$key]]);
        };

        return Response::json(['status' => 'success']);
    }

}
