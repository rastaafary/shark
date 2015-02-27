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
        $user = Auth::user();
        $customer = DB::table('customers')->where('user_id',$user->id)->first();
        $purchaseOrderData = DB::table('purchase_order')->orderBy('id', 'desc')->first();
        
        if ($purchaseOrderData == null) {
            $autoId = str_pad(1, 4, '0', STR_PAD_LEFT);
        } else {
            $autoId = str_pad($purchaseOrderData->id, 4, '0', STR_PAD_LEFT);
        }
        $autoId = $po_number = $customer->id . "-" . $autoId;
        
        
        $post = Input::all();
        if (isset($post['_token'])) {
            unset($post['_token']);

            $rules = array(
                'orderDate' => 'required',
                'shippingMethod' => 'required',
                'payment_terms' => 'required',
                'require_date' => 'required',
                'PDF' => 'mimes:pdf|max:1024',
                'Ai' => 'mimes:pdf|max:1024'
            );
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return redirect('/po/add')
                                ->withErrors($validator)
                                ->withInput(Input::all());
            }

            if (isset($post['addNew'])) {
                //Get Customer ID
                //$customer = DB::table('customers')->where('user_id', $post['id'])->first();
                // Add New Shipping Information
                $shp_info = DB::table('shipping_info')->insert(
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
                ));
                if ($shp_info == 1) {
                    $shp_info = DB::table('shipping_info')->where('customer_id', $customer->id)->orderBy('id', 'desc')->first();
                }
            } else {
                //Get Customer ID
                $customer_data = DB::table('customers')->where('user_id', $post['id'])->first();
                $shp_info = DB::table('shipping_info')
                        ->where('customer_id', $customer_data->id)
                        ->where('identifier', $post['oldIdentifire'])
                        ->first();
            }
            //Get the Customer Details
            
            //Upload the PDF
            if (isset($post['PDF'])) {
                $pdfName = $post['PDF']->getClientOriginalName();
                $file = Input::file('PDF');
                $destinationPath = 'images/Blog_art';
                $pdfFilename = str_replace(' ', '', $customer->comp_name) . time() . '_' . $pdfName;
                Input::file('PDF')->move($destinationPath, $pdfFilename);
                $post['PDF'] = $pdfFilename;
            }

            //Upload the Ai
            if (isset($post['Ai'])) {
                $aiName = $post['Ai']->getClientOriginalName();
                $file = Input::file('Ai');
                $destinationPath = 'images/Blog_art';
                $aiFilename = str_replace(' ', '', $customer->comp_name) . time() . '_' . $aiName;
                Input::file('Ai')->move($destinationPath, $aiFilename);
                $post['Ai'] = $aiFilename;
                //$aiFile = $blogfiles . ' ' . $filename;
            }
            
            //$customer = DB::table('customers')->where('user_id',$user->id)->first();
 
            //Add Purchase Order
            $po = DB::table('purchase_order')->insert(
                    array('customer_id' => $customer->id,
                        'po_number' => '',
                        'shipping_id' => $shp_info->id,
                        'date' => date('Y/m/d', strtotime($post['orderDate'])),
                        'payment_terms' => $post['payment_terms'],
                        'require_date' => date('Y/m/d', strtotime($post['require_date'])),
                        'comments' => $post['comments']
                    )
            );

            DB::table('purchase_order')                   
                    ->where('shipping_id', $shp_info->id)
                    ->orderBy('id', 'desc')
                    ->update(array('po_number' => $po_number));



            $PO_id = DB::table('purchase_order')->where('customer_id', $customer->id)->orderBy('id', 'desc')->first();

            //Add Blog Art Data
            $blog_art = DB::table('blog_art_file')->insert(
                    array('po_id' => $PO_id->id,
                        'customer_id' => $customer->id,
                        'name' => '',
                        'pdf' => $pdfFilename,
                        'ai' => $aiFilename)
            );

            //add po order
            $orders = json_decode($post['orders'],true);
            foreach ($orders as $orderlist) {
                if ($orderlist['part_id'] > 0) {
                    $orderlist['customer_id'] = $customer->id;
                    $orderlist['po_id'] = $PO_id->id;
                    $orderlist['created_by'] = Auth::user()->id;
                    $orderstatus = DB::table('order_list')->insert($orderlist);
                }
            } 
            Session::flash('message', "PO Customer Added Sucessfully.");
            Session::flash('status', 'success');
            return View::make('PurchaseOrderCustomer.listPurchaseOrder');
            //$last_id = DB::table('user')->orderBy('id', 'desc')->first();
        }
        
        
        $cust = DB::table('customers')->where('user_id', $user->id)->first();
        
        if (isset($cust->id)) {
            $shipping = DB::table('shipping_info')->where('customer_id', $cust->id)->get();
        }
        
        $partsData = DB::table('part_number')->select('SKU', 'id')->get(); //->where('SKU', 'like', '%' . $sku . '%')->get();
        $sku = '';
        $sku .="<option value='" . '' . "' selected='selected' > select sku</option>";
        foreach ($partsData as $key => $value) {
            $sku .="<option value='" . $value->id . "'>" . $value->SKU . "</option>";
        }         
        
        return View::make("PurchaseOrderCustomer.addPurchaseOrder", ['page_title' => 'Add Purchase Order'])
                        ->with("shipping", $shipping)
                        ->with('sku', $sku)
                        ->with('autoId',$autoId);
        
    }
    
    public function editPurchaseOrder($id = null) {
         if (isset($id)) {

       /*     $order_data = DB::table('order_list')
                    ->where('id', $id)
                    ->first();
            $po_data = DB::table('purchase_order')
                    ->where('id', $order_data->po_id)
                    ->first();
            $Shipping_data = DB::table('shipping_info')
                    ->where('id', $po_data->shipping_id)
                    ->first();
            $blog_data = DB::table('blog_art_file')
                    ->where('po_id', $po_data->id)
                    ->first();
            var_dump($order_data);
            var_dump($po_data);
            var_dump($Shipping_data);
            var_dump($blog_data);
            exit("hk"); */

            $orderlist = DB::table('order_list')
                    ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
                    ->leftJoin('shipping_info', 'shipping_info.id', '=', 'purchase_order.shipping_id')
                    ->leftJoin('blog_art_file', 'blog_art_file.po_id', '=', 'purchase_order.id')
                    ->select(array('order_list.id', 'order_list.part_id', 'order_list.qty', 'order_list.amount', 'order_list.created_at', 'order_list.created_by', 'order_list.po_id', 'purchase_order.po_number', 'purchase_order.customer_id', 'purchase_order.shipping_id', 'purchase_order.date', 'purchase_order.payment_terms', 'purchase_order.require_date', 'purchase_order.comments', 'shipping_info.comp_name', 'shipping_info.building_no', 'shipping_info.street_addrs', 'shipping_info.interior_no', 'shipping_info.city', 'shipping_info.state', 'shipping_info.zipcode', 'shipping_info.country', 'shipping_info.phone_no', 'shipping_info.identifier', 'shipping_info.type', 'shipping_info.invoice_id', 'shipping_info.created_by', 'blog_art_file.pdf', 'blog_art_file.ai'))
                    ->where('order_list.id', $id)
                    ->get();
            var_dump($orderlist);
            exit("hk");

            return View::make('customer.addCustomer', ['page_title' => 'Edit Customer', 'id' => $id])->with('cust', $cust);
        }
        return view('customer.addCustomer', ['page_title' => 'List Customer']);
        //exit($id.' -> Coming Soon');
        
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

    /**
     * get description by sku
     */
    public function getDescription()
    {
        $sku = Input::get('description');
        $data = DB::table('part_number')->select('description', 'cost')->where('id', $sku)->get();
        return Response(json_encode($data));
    }

    /**
     * 
     */
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
        $status = 0;
           
        $status = DB::table('order_list')->where('id', $id)->delete();
        if ($status) {
            Session::flash('message', 'PO Customer delete Successfully.');
            Session::flash('status', 'success');
        } else {
            Session::flash('message', "PO Customer delete Unsucessfully.");
            Session::flash('status', 'error');
        }
        $post = Input::all();
        if (isset($post['list'])) {
            return redirect('/po');
        } else {
            return redirect('/po/add');
        }
        
    }

    /**
     * get getPoCustomerlist
     */
    public function getPoCustomerlist()
    {
        $orderlist = DB::table('order_list')
                ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
                ->leftJoin('order_status', 'order_list.id', '=', 'order_status.po_id')
                ->select(array('purchase_order.po_number', 'part_number.SKU', 'purchase_order.require_date', 'part_number.description', 'order_list.qty', 'order_status.pcs_made', 'order_list.amount', 'order_list.id'))
                ->groupBy('order_list.id');

        return Datatables::of($orderlist)
                        ->editColumn("id", '<a href="/po/deletepoCustomer/{{ $id }}?list=true" class="btn btn-danger" onClick = "return confirmDelete({{ $id }})" id="btnDelete">'
                                . '<span class="fa fa-trash-o"></span></a>'
                                . '&nbsp<a href="/po/edit/{{ $id }}" class="btn btn-primary" id="btnEdit">'
                                . '<span class="fa fa-pencil"></span></a>')
                        ->editColumn("description", '(REMAINIG)')
                        ->make();
    }

}
