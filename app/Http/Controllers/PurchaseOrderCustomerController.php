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
        $post = Input::all();

        $order = array();
        foreach ($post as $key => $value) {
            $k = 0;
            if ($key == 'sku') {
                foreach ($value as $keys => $sku) {
                    $order[$k]['part_id'] = $sku;
                    $k++;
                }
            }
            $k = 0;
            if ($key == 'searchQty') {
                foreach ($value as $keys => $searchQty) {
                    $order[$k]['qty'] = $searchQty;
                    $k++;
                }
            }
            $k = 0;
            if ($key == 'searchQty') {
                foreach ($value as $keys => $searchQty) {
                    $order[$k]['qty'] = $searchQty;
                    $k++;
                }
            }
            $k = 0;
            if ($key == 'amount') {
                foreach ($value as $keys => $amount) {
                    $order[$k]['amount'] = $amount;
                    $k++;
                }
            }
        }


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
                //->with(array("shipping" => $shipping, $validator));
            }

            $dt = $post['require_date'];
            $my_date = date('m/d/Y', strtotime($dt));
            $time = strtotime($my_date);
            $reqDate = date('Y/m/d', $time);

            $dt = $post['orderDate'];
            $my_date = date('m/d/Y', strtotime($dt));
            $time = strtotime($my_date);
            $ordDate = date('Y/m/d', $time);


            if (isset($post['addNew'])) {

                //Get Customer ID
                $customer = DB::table('customers')->where('user_id', $post['id'])->first();

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
                            'date' => $ordDate,
                            'invoice_id' => '',
                ));
            } else {
                //Get Customer ID
                $customer_data = DB::table('customers')->where('user_id', $post['id'])->first();
                $customer = DB::table('shipping_info')
                        ->where('customer_id', $customer_data->id)
                        ->where('identifier', $post['oldIdentifire'])
                        ->first();

                // Add Old Shipping Information
                $shp_info = DB::table('shipping_info')->insert(
                        array('customer_id' => $customer->customer_id,
                            'comp_name' => $customer->comp_name,
                            'building_no' => $customer->building_no,
                            'street_addrs' => $customer->street_addrs,
                            'interior_no' => $customer->interior_no,
                            'city' => $customer->city,
                            'state' => $customer->state,
                            'zipcode' => $customer->zipcode,
                            'country' => $customer->country,
                            'phone_no' => $customer->phone_no,
                            'identifier' => $post['oldIdentifire'],
                            'type' => $post['shippingMethod'],
                            'date' => $ordDate,
                            'invoice_id' => '',
                ));
            }
            //Get the Customer Details
            // $customer = DB::table('customers')->where('user_id', $id)->first();
            $customer = DB::table('customers')->where('user_id', $post['id'])->first();

            //$blogfiles = '';
            //Upload the PDF
            if (isset($post['PDF'])) {
                $pdfName = $post['PDF']->getClientOriginalName();
                $file = Input::file('PDF');
                $destinationPath = 'images/Blog_art';
                $pdfFilename = str_replace(' ', '', $customer->comp_name) . time() . '_' . $pdfName;
                Input::file('PDF')->move($destinationPath, $pdfFilename);
                $post['PDF'] = $pdfFilename;
                //$blogfiles = $blogfiles . ' ' . $filename;
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

            // Get Shipping Id
            //$shipping = DB::table('shipping_info')->where('customer_id', $id)->last();       
            //  $shipping = DB::table('shipping_info')->orderBy('id', 'desc')->first();
            $shipping = DB::table('shipping_info')->where('customer_id', $customer->id)->orderBy('id', 'desc')->first();
            //Add Purchase Order
            $po = DB::table('purchase_order')->insert(
                    array('customer_id' => $customer->id,
                        'po_number' => '',
                        'shipping_id' => $shipping->id,
                        'date' => $ordDate,
                        'payment_terms' => $post['payment_terms'],
                        'require_date' => $reqDate,
                        'comments' => $post['comments']
                    )
            );

            $po_number = '';
            $inc_id = '';
            $customer = Auth::user()->id;
            $c_ID = str_pad($customer, 4, '0', STR_PAD_LEFT);
            $inc_id = DB::table('purchase_order')->orderBy('id', 'desc')->first();
            if ($inc_id == null) {
                $inc_id = 1;
                $inv_ID = str_pad($inc_id, 5, '0', STR_PAD_LEFT);
            } else {
                $inv_ID = str_pad($inc_id->id, 5, '0', STR_PAD_LEFT);
            }
            $po_number = $c_ID . "-" . $inv_ID;

            DB::table('purchase_order')
                    ->where('shipping_id', $shipping->id)
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
            foreach ($order as $order => $orderlist) {
                if ($orderlist['part_id'] > 0) {
                    $orderlist['customer_id'] = $customer->id;
                    $orderlist['po_id'] = $PO_id->id;
                    $orderlist['created_by'] = Auth::user()->id;
                    $orderstatus = DB::table('order_list')->insert($orderlist);
                }
            }
            Session::flash('message', "PO Customer Added Sucessfully.");
            Session::flash('alert-class', 'alert-danger');
            return View::make('PurchaseOrderCustomer.listPurchaseOrder');
            //$last_id = DB::table('user')->orderBy('id', 'desc')->first();
        }
        //return redirect('/userList/add')->with('identifier', $shipping->identifier);
        $uid = Auth::user()->id;

        if (isset($uid) && $uid != null) {

            $cust = DB::table('customers')->where('user_id', $uid)->first();
            $shipping = array();
            if (isset($cust->id)) {
                $cust_id = $cust->id;
                $shipping = DB::table('shipping_info')->where('customer_id', $cust_id)->get();
            }
            $data = DB::table('part_number')->select('SKU', 'id')->get(); //->where('SKU', 'like', '%' . $sku . '%')->get();
            $sku = '';
            $sku .="<option value='" . '' . "' selected='selected' > select sku</option>";
            foreach ($data as $key => $value)
                $sku .="<option value='" . $value->id . "'>" . $value->SKU . "</option>";


            return View::make("PurchaseOrderCustomer.addPurchaseOrder", ['page_title' => 'Add Purchase Order'])
                            ->with("shipping", $shipping)->with('sku', $sku);
        }
    }

    public function editPurchaseOrder()
    {
        
        return redirect('/po/add');
      //return view('PurchaseOrderCustomer.addPurchaseOrder', ['page_title' => 'Edit Purchase Order']);  
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
            Session::flash('alert-class', 'alert-danger');
        } else {
            Session::flash('message', "PO Customer edit Unsucessfully.");
            Session::flash('alert-class', 'alert-danger');
        }
        return redirect('/po/add');
        //  return View::make("PurchaseOrderCustomer.addPurchaseOrder");
    }

    public function deletepoCustomer($id = null)
    {
        $status = 0;
        $status = DB::table('order_list')->where('id', $id)->delete();
        if ($status) {
            Session::flash('message', 'PoCustomer delete Successfully!!');
            // Session::flash('alert-success', 'success');
        } else {
            Session::flash('message', "PO Customer delete Unsucessfully.");
        }
        return redirect('/po/add');
    }

    /**
     * get getPoCustomerlist
     */
    public function getPoCustomerlist()
    {

        $orderlist = DB::table('order_list')
                ->leftJoin('part_number', 'part_number.id', '=', 'order_list.part_id')
                ->leftJoin('purchase_order', 'purchase_order.id', '=', 'order_list.po_id')
                ->select(array('purchase_order.po_number', 'part_number.SKU', 'purchase_order.require_date', 'part_number.description', 'order_list.qty', 'part_number.cost', 'order_list.amount', 'order_list.id'));

        return Datatables::of($orderlist)
                        ->editColumn("id", '<a href="#" class="btn btn-danger" id="btnDelete">'
                                . '<span class="fa fa-trash-o"></span></a>'
                                . '&nbsp<a href="/po/edit/{{ $po_number }}" class="btn btn-primary" id="btnEdit">'
                                . '<span class="fa fa-pencil"></span></a>')
                        ->make();
    }

}
