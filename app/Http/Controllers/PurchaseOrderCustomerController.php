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

class PurchaseOrderCustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userDetails()
    {
        $post = Input::all();
        if (isset($post['_token']))
            unset($post['_token']);
        if (isset($id)) {
            $cust = DB::table('customers')->where('user_id', $id)->first();
            return View::make('PurchaseOrderCustomer.addPurchaseOrder', ['page_title' => 'Add Purchase Order', 'id' => $id])->with('cust', $cust);
        }
        return view('PurchaseOrderCustomer.addPurchaseOrder', ['page_title' => 'Add Purchase Order']);
    }

    public function addPurchaseOrder($id = null)
    {
        // echo upload_max_filesize "2M" PHP_INI_PERDIR;
        //Get Logged User Deatils
        $user = Auth::user();

        //Get Custome Details
        $customer = DB::table('customers')->where('user_id', $user->id)->first();

        /*  if (count($customer) == 0 || empty($customer)) {
          Session::flash('message', "Please first create customer.");
          Session::flash('status', 'error');
          return redirect('/po');
          }
         */

        //  if customer then generate auto ID
        if (Auth::user()->hasRole('customer')) {
            $autoId = $this->getAutoPurchaseCustomerId($customer);
        }

        //check Is post
        if (Request::isMethod('post')) {
            $post = Input::all();

            // if admin or manager  log in
            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager')) {
                $customer = DB::table('customers')->where('id', $post['selectPOCustomer'])->first();
            }
            $autoId = $this->getAutoPurchaseCustomerId($customer);

            unset($post['_token']);

            $rules = array(
                'orderDate' => 'required',
                'shippingMethod' => 'required',
                'payment_terms' => 'required',
                'require_date' => 'required',
                'PDF' => 'mimes:pdf|max:10240',
                'Ai' => 'max:10240'
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return redirect('/po/add')
                                ->withErrors($validator)
                                ->withInput(Input::all());
            }

            if (isset($post['addNew'])) {
                // Add New Shipping Information
                $shipAddId = DB::table('shipping_info')->insertGetId(
                        array('customer_id' => $customer->id,
                            'comp_name' => $post['comp_name'],
                            'building_no' => $post['building_no'],
                            'street_addrs' => $post['street_addrs'],
                            'interior_no' => $post['interior_no'],
                            'city' => $post['city'],
                            'state' => $post['state'],
                            'zipcode' => $post['zipcode'],
                            'country' => $post['country'],
                            'phone_no' => $post['phone_no'],
                            'identifier' => $post['identifer'],
                            'type' => $post['shippingMethod'],
                            'date' => date('Y/m/d', strtotime($post['orderDate'])),
                            'invoice_id' => '',
                        )
                );
            } else {
                //Get Customer ID
                if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager')) {
                    $customer_data = DB::table('customers')->where('id', $post['selectPOCustomer'])->first();
                } else {
                    $customer_data = DB::table('customers')->where('user_id', $post['id'])->first();
                }
                $shipData = DB::table('shipping_info')
                        ->where('customer_id', $customer_data->id)
                        ->where('id', $post['oldIdentifire'])
                        ->first();
                $shipAddId = $shipData->id;
            }

            //Add Purchase Order
            $poId = DB::table('purchase_order')->insertGetId(
                    array('customer_id' => $customer->id,
                        'po_number' => $autoId,
                        'shipping_id' => $shipAddId,
                        'date' => date('Y/m/d', strtotime($post['orderDate'])),
                        'time' => date('H:i:s', strtotime($post['time'])),
                        'payment_terms' => $post['payment_terms'],
                        'require_date' => date('Y/m/d', strtotime($post['require_date'])),
                        'comments' => $post['comments']
                    )
            );

            //Upload the PDF
            if (isset($post['PDF'])) {
                $pdfName = $post['PDF']->getClientOriginalName();
                $file = Input::file('PDF');
                $destinationPath = 'files';
                $pdfFilename = str_replace(' ', '', $customer->comp_name) . time() . '_' . $pdfName;
                Input::file('PDF')->move($destinationPath, $pdfFilename);
                $post['PDF'] = $pdfFilename;
            } else {
                $post['PDF'] = '';
            }

            //Upload the Ai
            if (isset($post['Ai'])) {
                $aiName = $post['Ai']->getClientOriginalName();
                $file = Input::file('Ai');
                $destinationPath = 'files';
                $aiFilename = str_replace(' ', '', $customer->comp_name) . time() . '_' . $aiName;
                Input::file('Ai')->move($destinationPath, $aiFilename);
                $post['Ai'] = $aiFilename;
            } else {
                $post['Ai'] = '';
            }

            if (!empty($post['PDF']) || !empty($post['Ai'])) {
                //Add Blog Art Data
                $blogArtId = DB::table('blog_art_file')->insertGetId(
                        array('po_id' => $poId,
                            'customer_id' => $customer->id,
                            'name' => '',
                            'pdf' => $post['PDF'],
                            'ai' => $post['Ai'])
                );
            }

            $localSeqNo = 1;
            $adminSeqNo = 1;
            $lastCustSeqId = DB::table('order_list')->select('*')->where('customer_id', '=', $customer->id)->orderBy('localSequence', 'DESC')->first();
            $lastAdminSeqId = DB::table('order_list')->select('*')->orderBy('adminSequence', 'DESC')->first();
            if (!empty($lastCustSeqId)) {
                $localSeqNo = $lastCustSeqId->localSequence;
            }
            if (!empty($lastAdminSeqId)) {
                $adminSeqNo = $lastAdminSeqId->adminSequence;
            }

            //add po order
            $orders = json_decode($post['orders'], true);

            foreach ($orders as $orderlist) {
                unset($orderlist['orderId']);
                if ($orderlist['part_id'] > 0) {
                    $adminSeqNo++;
                    $localSeqNo++;
                    $orderlist['customer_id'] = $customer->id;
                    $orderlist['po_id'] = $poId;
                    $orderlist['localSequence'] = $localSeqNo;
                    $orderlist['adminSequence'] = $adminSeqNo;
                    $orderlist['created_by'] = Auth::user()->id;
                    $orderstatus = DB::table('order_list')->insert($orderlist);
                }
            }
            Session::flash('message', "PO Customer Added Sucessfully.");
            Session::flash('status', 'success');
            return redirect('/po');
            // return View::make('PurchaseOrderCustomer.listPurchaseOrder');
        }

        //get shipping address details
        if (isset($customer->id)) {
            $shipping = DB::table('shipping_info')->where('customer_id', $customer->id)->get();
        }
        //get parts Data
        $sku = $this->getSKUPartsData();

        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager')) {
            $cData = $this->getCustomerData();
            $autoId = '00-0000';
            return View::make("PurchaseOrderCustomer.addPurchaseOrder", ['page_title' => 'Add Purchase Order'])
                            // ->with("shipping", $shipping)
                            ->with('sku', $sku)
                            ->with('custData', $cData)
                            ->with('autoId', $autoId);
        }
        return View::make("PurchaseOrderCustomer.addPurchaseOrder", ['page_title' => 'Add Purchase Order'])
                        ->with("shipping", $shipping)
                        ->with('sku', $sku)
                        ->with('autoId', $autoId);
    }

    public function editPurchaseOrder($id = null)
    {
        //check Poid Is empty
        if (!empty($id)) {
            //Get Logged User Deatils
            $user = Auth::user();
            //Get Custome Details

            if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager')) {
                $po_data = DB::table('purchase_order')->where('id', $id)->first();
                $customer = DB::table('customers')->where('id', $po_data->customer_id)->first();
            } else {
                $customer = DB::table('customers')->where('user_id', $user->id)->first();
            }
            //Get data of purchase order
            $purchaseOrder = DB::table('purchase_order')
                    ->select(array('shipping_info.*', 'purchase_order.*', 'blog_art_file.*', 'blog_art_file.id as art_id'))
                    ->leftJoin('shipping_info', 'shipping_info.id', '=', 'purchase_order.shipping_id')
                    ->leftJoin('blog_art_file', 'blog_art_file.po_id', '=', 'purchase_order.id')
                    ->where('purchase_order.id', $id)
                    ->first();

            if (Request::isMethod('post')) {

                $post = Input::all();

                unset($post['_token']);
                $rules = array(
                    'orderDate' => 'required',
                    'shippingMethod' => 'required',
                    'payment_terms' => 'required',
                    'require_date' => 'required',
                    'PDF' => 'mimes:pdf|max:10240',
                    'PDF' => 'max:10240'
                );
                $validator = Validator::make(Input::all(), $rules);
                if ($validator->fails()) {
                    return redirect('/po/edit/' . $id)
                                    ->withErrors($validator)
                                    ->withInput(Input::all());
                }

                if (isset($post['addNew'])) {
                    // Add New Shipping Information
                    $shipAddId = DB::table('shipping_info')->insertGetId(
                            array(
                                'customer_id' => $customer->id,
                                'comp_name' => $post['comp_name'],
                                'building_no' => $post['building_no'],
                                'street_addrs' => $post['street_addrs'],
                                'interior_no' => $post['interior_no'],
                                'city' => $post['city'],
                                'state' => $post['state'],
                                'zipcode' => $post['zipcode'],
                                'country' => $post['country'],
                                'phone_no' => $post['phone_no'],
                                'identifier' => $post['identifer'],
                                'type' => $post['shippingMethod'],
                                'date' => date('Y/m/d', strtotime($post['orderDate'])),
                                'invoice_id' => '',
                            )
                    );
                } else {
                    $shipAddId = $purchaseOrder->shipping_id;
                    DB::table('shipping_info')
                            ->where('id', $shipAddId)
                            ->update(
                                    array(
                                        'type' => $post['shippingMethod']
                                    )
                    );
                }

                //update Purchase Order
                $poId = DB::table('purchase_order')
                        ->where('id', $id)
                        ->update(
                        array(
                            'shipping_id' => $post['oldIdentifire'],
                            'date' => date('Y/m/d', strtotime($post['orderDate'])),
                            'time' => date('H:i:s', strtotime($post['time'])),
                            'payment_terms' => $post['payment_terms'],
                            'require_date' => date('Y/m/d', strtotime($post['require_date'])),
                            'comments' => $post['comments']
                        )
                );

                //Upload the PDF
                if (isset($post['PDF'])) {
                    if (!empty($purchaseOrder->pdf)) {
                        @unlink('files/' . $purchaseOrder->pdf);
                    }
                    $pdfName = $post['PDF']->getClientOriginalName();
                    $file = Input::file('PDF');
                    $destinationPath = 'files';
                    $pdfFilename = str_replace(' ', '', $customer->comp_name) . rand() . '_' . $pdfName;
                    Input::file('PDF')->move($destinationPath, $pdfFilename);
                    $post['PDF'] = $pdfFilename;
                } else {
                    $post['PDF'] = '';
                }

                //Upload the Ai
                if (isset($post['Ai'])) {

                    if (!empty($purchaseOrder->ai)) {
                        @unlink('files/' . $purchaseOrder->ai);
                    }

                    $aiName = $post['Ai']->getClientOriginalName();
                    $file = Input::file('Ai');
                    $destinationPath = 'files';
                    $aiFilename = str_replace(' ', '', $customer->comp_name) . rand() . '_' . $aiName;
                    Input::file('Ai')->move($destinationPath, $aiFilename);
                    $post['Ai'] = $aiFilename;
                } else {
                    $post['Ai'] = '';
                }



                if (!empty($post['Ai']) || !empty($post['PDF'])) {
                    if (!empty($post['PDF'])) {
                        $blogArtData = DB::table('blog_art_file')->where('po_id', '=', $id)->first();
                        if (empty($blogArtData)) {

                            //Add Blog Art Data
                            $blogArtId = DB::table('blog_art_file')->insertGetId(
                                    array('po_id' => $id,
                                        'customer_id' => $customer->id,
                                        'name' => '',
                                        'pdf' => $post['PDF'])
                            );
                        } else {
                            //update Blog Art Data
                            $blogArtId = DB::table('blog_art_file')
                                    ->where('id', $blogArtData->id)
                                    ->update(
                                    array(
                                        'name' => '',
                                        'pdf' => $post['PDF']
                                    )
                            );
                        }
                    }
                    if (!empty($post['Ai'])) {
                        $blogArtData = DB::table('blog_art_file')->where('po_id', '=', $id)->first();
                        if (empty($blogArtData)) {
                            //Add Blog Art Data
                            $blogArtId = DB::table('blog_art_file')->insertGetId(
                                    array('po_id' => $id,
                                        'customer_id' => $customer->id,
                                        'name' => '',
                                        'ai' => $post['Ai'])
                            );
                        } else {
                            //update Blog Art Data
                            $blogArtId = DB::table('blog_art_file')
                                    ->where('id', $blogArtData->id)
                                    ->update(
                                    array(
                                        'name' => '',
                                        'ai' => $post['Ai']
                                    )
                            );
                        }
                    }
                }

                //add po order
                $orders = json_decode($post['orders'], true);
                $deleteOrderIds = explode(',', $post['deleteOrder']);

                if (count($deleteOrderIds) > 0) {
                    foreach ($deleteOrderIds as $deleteOrder) {
                        DB::table('order_list')->where('id', $deleteOrder)
                                ->delete();
                    }
                }
                $localSeqNo = 1;
                $adminSeqNo = 1;
                $lastCustSeqId = DB::table('order_list')->select('*')->where('customer_id', '=', $customer->id)->orderBy('localSequence', 'DESC')->first();
                $lastAdminSeqId = DB::table('order_list')->select('*')->orderBy('adminSequence', 'DESC')->first();
                if (!empty($lastCustSeqId)) {
                    $localSeqNo = $lastCustSeqId->localSequence;
                }
                if (!empty($lastAdminSeqId)) {
                    $adminSeqNo = $lastAdminSeqId->adminSequence;
                }
                foreach ($orders as $orderlist) {
                    if ($orderlist['part_id'] > 0) {
                        $orderId = $orderlist['orderId'];
                        unset($orderlist['orderId']);
                        if ($orderId > 0) {
                            //Update Order
                            DB::table('order_list')
                                    ->where('id', $orderId)
                                    ->update($orderlist);
                        } else {
                            $localSeqNo++;
                            $adminSeqNo++;
                            //Add new Order
                            $orderlist['customer_id'] = $customer->id;
                            $orderlist['po_id'] = $id;
                            $orderlist['adminSequence'] = $adminSeqNo;
                            $orderlist['localSequence'] = $localSeqNo;
                            $orderlist['created_by'] = $user->id;
                            DB::table('order_list')->insert($orderlist);
                        }
                    }
                }
                Session::flash('message', "PO Customer Updated Sucessfully.");
                Session::flash('status', 'success');
                return redirect('/po');
            }

            //Get list of Parts order
            $orderList = DB::table('order_list')
                    ->select(array('order_list.*', 'part_number.*', 'order_list.id as order_id'))
                    ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                    ->where('order_list.po_id', $id)
                    ->get();

            //echo '<pre>';print_r($purchaseOrder);exit;
            //get shipping address details
            if (isset($customer->id)) {
                $shipping = DB::table('shipping_info')->where('customer_id', $customer->id)->get();
            } else {
                $shipping = array();
            }


            //get parts Data
            $sku = $this->getSKUPartsData();
        } else {
            return redirect('/po/add');
        }

        /*  if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager')) {
          $cData = $this->getCustomerData();
          return View::make("PurchaseOrderCustomer.addPurchaseOrder", ['page_title' => 'Add Purchase Order'])
          ->with("shipping", $shipping)
          ->with('sku', $sku)
          ->with('custData', $cData)
          ->with('autoId', $purchaseOrder->po_number)
          ->with('orderlist', $orderList)
          ->with('purchaseOrder', $purchaseOrder);
          // ->with('autoId', $autoId);
          } */

        return View::make("PurchaseOrderCustomer.addPurchaseOrder", ['page_title' => 'Edit Purchase Order'], ['id' => $id])
                        ->with('cust', $customer)
                        ->with('orderlist', $orderList)
                        ->with('purchaseOrder', $purchaseOrder)
                        ->with('autoId', $purchaseOrder->po_number)
                        ->with('sku', $sku)
                        ->with('shipping', $shipping);
        // ->with('identifireList', $identifireData);
    }

    public function listPurchaseOrder()
    {
        return view('PurchaseOrderCustomer.listPurchaseOrder', ['page_title' => 'Purchase Order']);
    }

    public function searchSKU()
    {
        $sku = Request::segment(4);
        $data = DB::table('part_number')->select('SKU')->where('SKU', 'like', '%' . $sku . '%')->get();
        return Response(json_encode($data));
    }

    public function getDescription()
    {
        $sku = Input::get('description');
        $data = DB::table('part_number')->select('description', 'cost')->where('id', $sku)->get();
        return Response(json_encode($data));
    }

    public function addOrder()
    {
        $post = Input::all();

        $last_PO_id = DB::table('purchase_order')->orderBy('id', 'desc')->first();
        $customer = DB::table('customers')->where('user_id', $post['id'])->first();
        $SKU = DB::table('part_number')
                ->where('SKU', $post['searchSKU'])
                ->get();
        if (!empty($SKU)) {
            $add_Order = DB::table('order_list')->insert(
                    array('part_id' => $SKU->id,
                        'description' => $SKU->description,
                        'qty' => $post['Qty'],
                        'amount' => $post['Amount'],
                        'po_id' => $last_PO_id->id,
                        'customer_id' => $customer->id
                    )
            );
        }
    }

    public function getorderlist()
    {
        $orderlist = DB::table('order_list')
                ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                ->select(array('part_number.SKU', 'part_number.description', 'order_list.qty', 'part_number.cost', 'order_list.amount', 'order_list.id'));

        return Datatables::of($orderlist)
                        ->editColumn("id", '<a href="/po/deletepoCustomer/{{ $id }}" class="btn btn-danger" onClick = "return confirmDelete({{ $id }})" id="btnDelete">'
                                . '<span class="fa fa-trash-o"></span></a>'
                                . '&nbsp<a href="#" class="btn btn-primary" onClick = "return pocustEdit({{ $id }})" id="btnEdit">'
                                . '<span class="fa fa-pencil"></span></a>')
                        ->make();
    }

    public function geteditorderlist()
    {
        $id = Input::get('id');
        $data = DB::table('order_list')
                ->join('part_number', 'part_number.id', '=', 'order_list.part_id')
                ->select('part_number.SKU', 'part_number.description', 'part_number.cost', 'order_list.qty', 'order_list.amount')
                ->where('order_list.id', $id)
                ->get();
        return Response(json_encode($data));
    }

    public function editpoCustomer()
    {
        $post = Input::all();
        // $post['created_by'] = Auth::user()->id;
        //  var_dump($post);exit;
        $status = 0;
        if (isset($post['order_id'])) {
            $status = DB::table('order_list')
                    ->where('id', $post['order_id'])
                    ->update(array('qty' => $post['editQty'], 'amount' => $post['editAmount'], 'created_by' => Auth::user()->id));
            // ->update(array('part_id'=>$post['editSKU'],'qty'=>$post['editQty'],'amount'=>$post['editUnitPrice'],'created_by'=>Auth::user()->id));
        }
        if ($status) {
            Session::flash('message', "PO Customer edit Sucessfully.");
            Session::flash('status', 'success');
        } else {
            Session::flash('message', "PO Customer edit Unsucessfully.");
            Session::flash('status', 'error');
        }
        if (isset($post['list'])) {
            return redirect('/po');
        } else {
            return redirect('/po/add');
        }

        //  return View::make("PurchaseOrderCustomer.addPurchaseOrder");
    }

    public function deletepoCustomer($id = null)
    {
//        $firstDeleteSqeuence = DB::table('order_list')
//                ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
//                ->select('order_list.sequence', 'order_list.customer_id')
//                ->where('purchase_order.id', '=', $id)
//                ->orderBy('order_list.sequence', 'ASC')
//                ->first();
//        $sequence = 1;

        $status = DB::table('purchase_order')->where('id', $id)->update(array('is_deleted' => '1'));

//        $changeSequenceData = DB::table('order_list')
//                ->select('sequence', 'id')
//                ->where('customer_id', '=', $firstDeleteSqeuence->customer_id)
//                ->where('sequence', '!=', 0)
//                ->orderBy('sequence', 'ASC')
//                ->get();
//        
//        foreach ($changeSequenceData as $newData) {
//            DB::table('order_list')
//                    ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
//                    ->where('order_list.id', '=', $newData->id)
//                    ->where('purchase_order.is_deleted', '=', '0')
//                    ->update(array('order_list.sequence' => $sequence++));
//        }

        if ($status) {
            Session::flash('message', 'PO Customer delete Successfully.');
            Session::flash('status', 'success');
        } else {
            Session::flash('message', "PO Customer delete Unsucessfully.");
            Session::flash('status', 'error');
        }

        return redirect('/po');
    }

    /**
     * get getPoCustomerlist
     */
    public function getPoCustomerlist()
    {
        if (Auth::user()->hasRole('customer')) {
            // Get PO List
            $customer = DB::table('customers')->where('user_id', Auth::user()->id)->first();
            $orderlist = DB::table('order_list')
                    ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                    ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
                    ->leftJoin('order_status', 'order_list.id', '=', 'order_status.po_id')
                    ->select(array('purchase_order.po_number', 'purchase_order.require_date', DB::raw('MAX(order_list.ESDate)'), DB::raw('SUM(order_list.qty)'), DB::raw('SUM(order_list.amount)'), 'purchase_order.id')) //, DB::raw('SUM(order_status.pcs_made)')
                    ->groupBy('purchase_order.id')
                    ->where('purchase_order.is_deleted', '=', '0')
                    ->where('order_list.customer_id', '=', $customer->id)
                    ->where('purchase_order.customer_id', '=', $customer->id);

            //->selectRow('purchase_order.po_number,purchase_order.require_date,part_number.description,sum(order_list.qty) as qty,sum(order_status.pcs_made) as pcs_made,sum(order_list.amount) as `amount`,`purchase_order.id`')
            return Datatables::of($orderlist)
                            ->editColumn("id", '<a href="/po/deletepoCustomer/{{ $id }}" class="btn btn-danger" onClick = "return confirmDelete({{ $id }})" id="btnDelete">'
                                    . '<span class="fa fa-trash-o"></span></a>'
                                    . '&nbsp<a href="/po/edit/{{ $id }}" class="btn btn-primary" id="btnEdit" onClick = "return confirmEdit({{ $id }})">'
                                    . '<span class="fa fa-pencil"></span></a>')
                            //->editColumn("description", '')
                            ->make();
        } else {
            $orderlist = DB::table('order_list')
                    ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                    ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
                    ->leftJoin('order_status', 'order_list.id', '=', 'order_status.po_id')
                    ->select(array('purchase_order.po_number', 'purchase_order.require_date', 'part_number.description', DB::raw('SUM(order_list.qty)'), DB::raw('SUM(order_list.amount)'), 'purchase_order.id')) //, DB::raw('SUM(order_status.pcs_made)')
                    ->groupBy('purchase_order.id')
                    ->where('purchase_order.is_deleted', '=', '0');

            return Datatables::of($orderlist)
                            ->editColumn("id", '<a href="/po/deletepoCustomer/{{ $id }}" class="btn btn-danger" onClick = "return confirmDelete({{ $id }})" id="btnDelete">'
                                    . '<span class="fa fa-trash-o"></span></a>'
                                    . '&nbsp<a href="/po/edit/{{ $id }}" class="btn btn-primary" id="btnEdit" onClick = "return confirmEdit({{ $id }})">'
                                    . '<span class="fa fa-pencil"></span></a>')
                            ->editColumn("description", '')
                            ->make();
        }
    }

    /**
     * UDF For Get Auto Purchase Customer Id
     */
    public function getAutoPurchaseCustomerId($customerData)
    {
        //Get last purchase Id
        $purchaseOrderData = DB::table('purchase_order')->select('id')->orderBy('id', 'desc')->first();

        //Generate Po_id
        if ($purchaseOrderData == null) {
            $autoId = str_pad(1, 4, '0', STR_PAD_LEFT);
        } else {
            $autoId = str_pad($purchaseOrderData->id + 1, 4, '0', STR_PAD_LEFT);
        }
        return $customerData->id . "-" . $autoId;
    }

    /**
     * UDF For Get SKU Parts Data
     */
    public function getSKUPartsData()
    {
        $partsData = DB::table('part_number')->select('SKU', 'id')->get();
        $sku = '';
        $sku .="<option value='" . '' . "' selected='selected' > select sku</option>";
        foreach ($partsData as $key => $value) {
            $sku .="<option value='" . $value->id . "'>" . $value->SKU . "</option>";
        }
        return $sku;
    }

    /**
     * UDF For Get PO Customer Data
     */
    public function getCustomerData()
    {
        $custData = DB::table('customers')->select('contact_name', 'id', 'phone_no')->get();
        $cData = '';
        $cData .="<option value='" . '' . "' selected='selected' > Select Customer</option>";
        foreach ($custData as $key => $value) {
            $cData .="<option value='" . $value->id . "'>" . $value->contact_name . " " . $value->phone_no . "</option>";
        }
        return $cData;
    }

    public function getIdentifireList($id = null)
    {
        $id = Input::get('custId');
        $custData = DB::table('shipping_info')->select('id', 'identifier')->where('customer_id', '=', $id)->get();
        return Response(json_encode($custData));
    }

}
