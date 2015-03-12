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

    /**
     * View Pl's report list
     * 
     * @return type
     */
    public function viewReport()
    {
        // Render view page
        return view('OrderStatusReport.OrderStatusReport', ['page_title' => "PL's"]);
    }

    /**
     * List of Pl's report for datatable
     * 
     * @return type
     */
    public function orderList()
    {
        // Get listing
        $skuData = DB::table('order_list')
                ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
                ->leftJoin('pcs_made', 'pcs_made.orderlist_id', '=', 'order_list.id')
                ->select('order_list.id as seqNo', 'purchase_order.po_number', 'part_number.SKU', 'purchase_order.require_date', DB::raw("IF(order_list.ESDate IS NULL or order_list.ESDate = '','',order_list.ESDate) as estDate"), 'order_list.qty', DB::raw("IF(SUM(pcs_made.qty) IS NULL or SUM(pcs_made.qty) = '', '0', SUM(pcs_made.qty)) as pcsMade"), 'order_list.amount', 'order_list.pl_status')
                ->groupBy('order_list.id');

        // Return datatable
        $statusStr = '<select id="plStatusChange" class="form-control" olId="{{$seqNo}}"><option value="0">Open</option><option value="1">Closed</option></select>';
        return Datatables::of($skuData)
                        ->editColumn("seqNo", '0')
                        ->editColumn("pcsMade", '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" onclick="getpcsDetails(\'{{$seqNo}}\',\'{{$po_number}}\',\'{{$SKU}}\',\'{{$amount}}\')">{{$pcsMade}}</button>')
                        ->editColumn("estDate", '<input id="ESDate" type="text" olId="{{$seqNo}}" value="{{$estDate}}" size="12" class="form-control default-date-picker ESDate" placeholder="YYYY-MM-DD">')
                        ->editColumn("pl_status", $statusStr)
                        ->make();
    }

    /**
     * Change PlValues as paramerter fields
     * 
     * @return type
     */
    public function changePlValues()
    {
        // Update Details
        $olId = Input::get('olId');
        $status = DB::table('order_list')
                ->where('id', $olId)
                ->update(array(Input::get('fieldName') => Input::get('fieldValue')));

        // Return
        return Response(json_encode(array('status' => $status)));
    }

    /**
     * Add/update pcs made
     * 
     * @return type
     */
    public function addPcsMade()
    {
        $pcsMadeId = Input::get('pcsMadeId');
        $pcsMadeQty = Input::get('pcsMadeQty');
        $pcsMadeQty_old = Input::get('pcsMadeQty_old');
        $orderlist_id = Input::get('orderlist_id');
        $status = 0;
        $msg = 'No changes found for update.';

        if (empty(Input::get('pcsMadeDate'))) {
            $msg = 'Please select date.';
        } else {
            if ($pcsMadeId > 0) {   // For update
                $totalQty = $totalMadeQty = 0;
                // Count total Qty
                $ollistQty = DB::table('order_list')
                        ->select('qty as totalQty')
                        ->where('id', $orderlist_id)
                        ->get();
                if (isset($ollistQty[0])) {
                    $totalQty = $ollistQty[0]->totalQty;
                }

                // Count total Made pcs Qty
                $pcsQty = DB::table('pcs_made')
                        ->select(DB::raw('SUM(qty) as madeQty'))
                        ->where('orderlist_id', $orderlist_id)
                        ->get();
                if (isset($pcsQty[0])) {
                    $totalMadeQty = $pcsQty[0]->madeQty;
                }

                if ($pcsMadeQty > 0 && ($pcsMadeQty < $pcsMadeQty_old || ($totalMadeQty + ($pcsMadeQty - $pcsMadeQty_old) <= $totalQty ))) {   // If valid then conti..
                    $status = DB::table('pcs_made')
                            ->where('id', $pcsMadeId)
                            ->update(
                            array('date' => Input::get('pcsMadeDate'),
                                'qty' => $pcsMadeQty)
                    );

                    if ($status) {
                        // Set Success
                        Session::flash('message', "Pcs update successfully.");
                        Session::flash('status', 'success');
                    }
                } else {
                    $msg = 'Invalid Quantity.';
                }
            } else {    // For Insert
                if ($this->IsValidQtyForPcs($pcsMadeQty, $orderlist_id)) { // If valid then conti..
                    $status = DB::table('pcs_made')->insertGetId(
                            array('orderlist_id' => $orderlist_id,
                                'date' => Input::get('pcsMadeDate'),
                                'qty' => $pcsMadeQty)
                    );

                    if ($status) {
                        // Set Success
                        Session::flash('message', "Pcs add successfully.");
                        Session::flash('status', 'success');
                    }
                } else {
                    $msg = 'Invalid Quantity.';
                }
            }
        }

        // Return
        return Response(json_encode(array('status' => $status, 'msg' => $msg)));
    }

    /**
     * Check is valid qty for Pcs
     * 
     * @param type $qty
     * @param type $olId
     * @return boolean
     */
    public function IsValidQtyForPcs($qty, $olId)
    {
        if ($qty != '' && $qty > 0) {
            $ollistQty = DB::table('order_list')
                    ->select('qty as totalQty')
                    ->where('id', $olId)
                    ->get();

            $pcsQty = DB::table('pcs_made')
                    ->select(DB::raw('SUM(qty) as madeQty'))
                    ->where('orderlist_id', $olId)
                    ->get();

            if (isset($ollistQty[0]) && isset($pcsQty[0]) && $qty <= $ollistQty[0]->totalQty - $pcsQty[0]->madeQty) {
                // If valid then true
                return true;
            }
        }

        // return false
        return false;
    }

    /**
     * Get Pcs made details
     * 
     * @return type
     */
    public function getPcsMadeDetails()
    {
        // Get param data
        $orderListId = Input::get('orderListId');

        // Fetch Pcs details by orderList
        $PcsDetails = DB::table('pcs_made')
                ->where('orderlist_id', $orderListId)
                ->get();

        // Return
        return Response(json_encode($PcsDetails));
    }

    /**
     * Delete Pcs made
     * 
     * @return type
     */
    public function deletePcsMade()
    {
        // Get param data
        $pcsMadeId = Input::get('pcsMadeId');

        // Detele Pcs made
        $status = DB::table('pcs_made')
                ->where('id', $pcsMadeId)
                ->delete();

        if ($status) {
            // Set Success
            Session::flash('message', "Pcs deleted successfully.");
            Session::flash('status', 'success');
        }

        // Return
        return Response(json_encode(array('status' => $status)));
    }

}
