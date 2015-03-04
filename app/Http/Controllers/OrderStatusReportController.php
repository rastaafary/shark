<?php

namespace App\Http\Controllers;

use Session;
use Input;
use DB;
use View;
use Validator;
use Datatables;
use Auth;
use Response;
use Request;
use Illuminate\Database\Query\Builder;

class OrderStatusReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewReport()
    {
        return view('OrderStatusReport.OrderStatusReport', ['page_title' => "PL's"]);
    }

    public function orderList()
    {
        $skuData = DB::table('order_list')
                ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
                ->select('order_list.po_id', 'purchase_order.po_number', 'part_number.SKU', 'purchase_order.require_date', 'order_list.part_id as Date', 'order_list.qty');
        return Datatables::of($skuData)
                        ->editColumn("Date", '<input id="ESDate" type="text" value="" size="12" class="form-control default-date-picker ESDate">')
                        ->make();
    }

}
