<?php

namespace App\Http\Controllers;

use App;
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
use Form;
use App\model\ProductionSequence;
use Barryvdh\DomPDF\PDF;
use Maatwebsite\Excel\Excel;

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
    public function orderList($status)
    {
        $baseUrl = \URL::to('/');

        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager')) {
            $tempSequence = 1;
            // Get listing for Admin or Manager
            $skuData = DB::table('order_list')
                    ->leftJoin('pcs_made', 'pcs_made.orderlist_id', '=', 'order_list.id')
                    ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                    ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
                    ->leftJoin('po_images', 'po_images.order_id', '=', 'order_list.id')
                    ->leftJoin('customers', 'customers.id', '=', 'order_list.customer_id')
                    ->select(array('order_list.adminSequence', 'purchase_order.po_number', 'customers.comp_name', 'part_number.SKU', 'po_images.approved_image as fileName', 'order_list.size_qty', 'purchase_order.require_date', DB::raw("IF(order_list.ESDate IS NULL or order_list.ESDate = '','',order_list.ESDate) as estDate"), 'order_list.qty', DB::raw("IF(SUM(pcs_made.qty) IS NULL or SUM(pcs_made.qty) = '', '0', SUM(pcs_made.qty)) as pcsMade"), DB::raw("(order_list.qty - (IF(SUM(pcs_made.qty) IS NULL or SUM(pcs_made.qty) = '', '0', SUM(pcs_made.qty)))) as amount"), 'order_list.pl_status', 'order_list.production_status', 'order_list.id as orderId'))
                    ->where('purchase_order.is_deleted', '!=', 1)
                    ->where('order_list.pl_status', '=', $status)
                    ->groupBy('order_list.id')
                    ->orderBy('order_list.adminSequence', 'ASC');
            // Return datatable
            $statusStr = '<select id="plStatusChange" class="form-control" olId="{{$orderId}}"><option value="0" {{ $pl_status == 0 ? "selected" : "" }}>Open</option><option value="1" {{ $pl_status == 1 ? "selected" : "" }}>Closed</option></select>';


            return Datatables::of($skuData)
                            ->editColumn("adminSequence", '@if($pl_status) 0 @else {{$adminSequence}} @endif')
                            ->editColumn("fileName", '@if($fileName == NULL) <img height="32" class="img-rounded" src="' . $baseUrl . '/files/poMultiImage/noImage.png"></img> @else <img height="32" class="img-rounded" src="' . $baseUrl . '/images/blog/{{$fileName}}"></img> @endif')
                            ->editColumn("pcsMade", '<button type="button" class="btn btn-primary btn-sm btnPcsMade" data-toggle="modal" data-target="#myModal" onclick="getpcsDetails(\'{{$orderId}}\',\'{{$po_number}}\',\'{{$SKU}}\',\'{{$amount}}\')">{{$pcsMade}}</button>')
                            ->editColumn("estDate", '<input id="ESDate" type="text" olId="{{$orderId}}" value="{{$estDate}}" size="12" class="form-control default-date-picker ESDate" placeholder="YYYY-MM-DD">')
                            ->editColumn("pl_status", $statusStr)
                            ->editColumn("production_status", function($row)
                            {
                                $data = ProductionSequence::where('isDelete', '!=', 1)
                                        ->orWhere('id', '=', $row->production_status)
                                        ->orWhereNull('isDelete')
                                        ->lists('title', 'id');
                                return \Form::select('production_status', $data, $row->production_status, ['class' => 'production_status form-control', 'id' => $row->orderId]);
                            })
                            ->editColumn("size_qty", function($row)
                            {
                                $string = '';
                                $sizeArray = json_decode($row->size_qty, true);
                                if (count($sizeArray) > 0)
                                    foreach ($sizeArray as $size) {
                                        foreach ($size as $key => $val) {
                                            $string .= $key . ":" . $val . ",";
                                        }
                                    }
                                return trim($string, ",");
                            })
                            //->filter_column('pcsMade', 'having', 'pcsMade', DB::raw('SUM(pcs_made.qty)'))
                            //->filter_column('amount', 'having', 'amount', DB::raw('SUM(order_list.qty)'))
                            ->make();
        }
        else {
            // Get listing for Local user
            $customer = DB::table('customers')->where('user_id', Auth::user()->id)->first();

            $skuData = DB::table('order_list')
                    ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                    ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
                    ->leftJoin('pcs_made', 'pcs_made.orderlist_id', '=', 'order_list.id')
                    ->leftJoin('po_images', 'po_images.order_id', '=', 'order_list.id')
                    ->leftJoin('customers', 'customers.id', '=', 'order_list.customer_id')
                    ->select('order_list.localSequence', 'purchase_order.po_number', 'customers.comp_name', 'part_number.SKU', 'po_images.approved_image as fileName', 'order_list.size_qty', 'purchase_order.require_date', DB::raw("IF(order_list.ESDate IS NULL or order_list.ESDate = '','',order_list.ESDate) as estDate"), 'order_list.qty', DB::raw("IF(SUM(pcs_made.qty) IS NULL or SUM(pcs_made.qty) = '', '0', SUM(pcs_made.qty)) as pcsMade"), 'order_list.amount', 'order_list.pl_status', 'order_list.production_status', 'order_list.id as orderId')
                    ->where('order_list.customer_id', '=', $customer->id)
                    ->where('purchase_order.is_deleted', '!=', 1)
                    ->where('order_list.pl_status', '=', $status)
                    ->groupBy('order_list.id')
                    ->orderBy('order_list.localSequence', 'ASC');

            // Return datatable
            $statusStr = '{{ $pl_status == 0 ? "Open" : "Close" }}';
            return Datatables::of($skuData)
                            ->editColumn("localSequence", '@if($pl_status) 0 @else {{$localSequence}} @endif')
                            ->editColumn("fileName", '@if($fileName == NULL) <img height="32" class="img-rounded" src="' . $baseUrl . '/files/poMultiImage/noImage.png"></img> @else <img height="32" class="img-rounded" src="' . $baseUrl . '/images/blog/{{$fileName}}"></img> @endif')
                            ->editColumn("pcsMade", '<button type="button" class="btn btn-primary btn-sm">{{$pcsMade}}</button>')
                            ->editColumn("size_qty", function($row)
                            {
                                $string = '';
                                $sizeArray = json_decode($row->size_qty, true);
                                if (count($sizeArray) > 0)
                                    foreach ($sizeArray as $size) {
                                        foreach ($size as $key => $val) {
                                            $string .= $key . ":" . $val . ",";
                                        }
                                    }
                                return trim($string, ",");
                            })
                            ->editColumn("estDate", '{{$estDate}}')
                            ->editColumn("pl_status", $statusStr)
                            ->editColumn("production_status", function($row)
                            {

                                $data = ProductionSequence::where('isDelete', '!=', 1)
                                        ->orWhere('id', '=', $row->production_status)
                                        ->orWhereNull('isDelete')
                                        ->first();
                                return \Form::label('', !is_null($data) ? $data->title : '');
                            })
                            ->make();
        }
    }

    /**
     * List of Pl's report for datatable
     * 
     * @return type
     */
    public function reOrderData()
    {
        if (count(Input::get('orderId')) > 0) {
            //get Min value for child
            $getSequence = DB::table('order_list')
                    ->select('localSequence', 'adminSequence')
                    ->where('id', Input::get('orderId')[0])
                    ->first();

            $parentMin = Input::get('min');

            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager')) {
                $parentFieldName = 'order_list.adminSequence';
                $childFieldName = 'order_list.localSequence';
                $childMin = $getSequence->localSequence;

                foreach (Input::get('orderId') as $id) {
                    // update Sequence
                    DB::table('order_list')
                            ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
                            ->where('order_list.id', '=', $id)
                            ->where('purchase_order.is_deleted', '!=', 1)
                            ->update(array($parentFieldName => $parentMin++, $childFieldName => $childMin++));
                }
            }
            else {
                $parentFieldName = 'order_list.localSequence';
                $childFieldName = 'order_list.adminSequence';
                $childMin = $getSequence->adminSequence - 1;
                $customer = DB::table('customers')->where('user_id', Auth::user()->id)->first();

                foreach (Input::get('orderId') as $id) {
                    // update Sequence
                    DB::table('order_list')
                            ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
                            ->where('order_list.id', '=', $id)
                            ->where('purchase_order.is_deleted', '!=', 1)
                            ->where('order_list.customer_id', '=', $customer->id)
                            ->update(array($parentFieldName => $parentMin++, $childFieldName => $childMin++));
                }
            }

            //$max = Input::get('max');
        }
        // Return
        return Response(json_encode(array('status' => 'success')));
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
     * Change PlValues as paramerter fields
     * 
     * @return type
     */
    public function productionStatus()
    {
        // Update Details
        $id = Input::get('id');
        $status = DB::table('order_list')
                ->where('id', $id)
                ->update(['production_status' => Input::get('production_status')]);

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
        }
        else {
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
                }
                else {
                    $msg = 'Invalid Quantity.';
                }
            }
            else {    // For Insert
                if ($this->IsValidQtyForPcs($pcsMadeQty, $orderlist_id)) { // If valid then conti..
                    $pcsStatus = DB::table('order_list')
                            ->select('pl_status')
                            ->where('id', $orderlist_id)
                            ->first();
                    if ($pcsStatus->pl_status == 0) {
                        $status = DB::table('pcs_made')->insertGetId(
                                array('orderlist_id' => $orderlist_id,
                                    'date' => date('Y/m/d', strtotime(Input::get('pcsMadeDate'))),
                                    'qty' => $pcsMadeQty)
                        );
                    }
                    else {
                        $msg = 'Sorry, This Order is closed.';
                    }

                    if ($status) {
                        // Set Success
                        Session::flash('message', "Pcs add successfully.");
                        Session::flash('status', 'success');
                    }
                }
                else {
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

    public function printReport($type = 'pdf', $status = 0, $start = 0, $end = 10)
    {
        set_time_limit(0);
        $data = array();
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
            $data = DB::table('order_list')
                    ->leftJoin('pcs_made', 'pcs_made.orderlist_id', '=', 'order_list.id')
                    ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                    ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
                    ->leftJoin('po_images', 'po_images.order_id', '=', 'order_list.id')
                    ->leftJoin('customers', 'customers.id', '=', 'order_list.customer_id')
                    ->select(array('order_list.adminSequence as sequence', 'purchase_order.po_number', 'customers.comp_name', 'part_number.SKU', 'po_images.approved_image as fileName', 'order_list.size_qty', 'purchase_order.require_date', DB::raw("IF(order_list.ESDate IS NULL or order_list.ESDate = '','',order_list.ESDate) as estDate"), 'order_list.qty', DB::raw("IF(SUM(pcs_made.qty) IS NULL or SUM(pcs_made.qty) = '', '0', SUM(pcs_made.qty)) as pcsMade"), DB::raw("(order_list.qty - (IF(SUM(pcs_made.qty) IS NULL or SUM(pcs_made.qty) = '', '0', SUM(pcs_made.qty)))) as amount"), 'order_list.pl_status', 'order_list.production_status', 'order_list.id as orderId'))
                    ->where('purchase_order.is_deleted', '!=', 1)
                    ->where('order_list.pl_status', '=', $status)
                    ->groupBy('order_list.id')
                    ->orderBy('order_list.adminSequence', 'ASC')
                    //->limit($end)
                    //->skip($start)
                    ->get();
        else {
            $customer = DB::table('customers')->where('user_id', Auth::user()->id)->first();
            $data = DB::table('order_list')
                    ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                    ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
                    ->leftJoin('pcs_made', 'pcs_made.orderlist_id', '=', 'order_list.id')
                    ->leftJoin('po_images', 'po_images.order_id', '=', 'order_list.id')
                    ->leftJoin('customers', 'customers.id', '=', 'order_list.customer_id')
                    ->select('order_list.localSequence as sequence', 'purchase_order.po_number', 'customers.comp_name', 'part_number.SKU', 'po_images.approved_image as fileName', 'order_list.size_qty', 'purchase_order.require_date', DB::raw("IF(order_list.ESDate IS NULL or order_list.ESDate = '','',order_list.ESDate) as estDate"), 'order_list.qty', DB::raw("IF(SUM(pcs_made.qty) IS NULL or SUM(pcs_made.qty) = '', '0', SUM(pcs_made.qty)) as pcsMade"), 'order_list.amount', 'order_list.pl_status', 'order_list.production_status', 'order_list.id as orderId')
                    ->where('order_list.customer_id', '=', $customer->id)
                    ->where('purchase_order.is_deleted', '!=', 1)
                    ->where('order_list.pl_status', '=', $status)
                    ->groupBy('order_list.id')
                    ->orderBy('order_list.localSequence', 'ASC')
                    //->limit($end)
                    //->skip($start)
                    ->get();
        }

        switch ($type)
        {
            case 'pdf':
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadView('OrderStatusReport.PrintPDF', array('data' => $data));
                return $pdf->download("PLReport.pdf");
                break;
            case 'excel':
                $excel = App::make('excel');
                if ($excel instanceof Excel) {
                    $ex = $excel->loadView('OrderStatusReport.PrintExcel', array('data' => $data))
                            ->setTitle("PLReport")
                            ->sheet('Sheet');
                    $rowCount = count($data) + 1;
                    $ex->getSheet()
                            ->setBorder("A1:L$rowCount", 'thin');
                    return $ex->setFileName("PLReport")
                                    ->download('xls');
                }
                break;
        }
    }

}
