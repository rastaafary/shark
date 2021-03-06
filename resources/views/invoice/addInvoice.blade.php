@extends('layouts.main')
@section('content')
{!! HTML::script('js/invoice.js') !!}

<script>
    var oldOrderData = <?php echo (isset($invoiceSKUOrder))?json_encode($invoiceSKUOrder):'[]'; ?>;
    var shippingId = <?php echo (isset($invoiceOrder->shipping_id))?($invoiceOrder->shipping_id):'0'; ?>;
</script>
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li><a href="{!!url('/invoice')!!}">List</a></li>
                        <li class="active"><a href="javascript:void(0);">{!! isset($id) ? 'Edit' : 'Add' !!}</a></li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">                        
                        <div class="tab-pane active" id="Add">
                            @if(isset($id))
                                {!! Form::open(array('class'=>'form-horizontal','url'=>'/invoice/edit/'.$id,'name'=>'Invoice','id'=>'Invoice','files' => true)) !!}
                            @else
                                {!! Form::open(array('class'=>'form-horizontal','url'=>'/invoice/add','name'=>'Invoice','id'=>'Invoice','files' => true)) !!}
                            @endif
                            {!! Form::hidden('user_id',Input::old('user_id',isset(Auth::user()->id) ? Auth::user()->id : '')) !!}
                            <div class="media usr-info">
                                <div class="pull-left">                                        
                                    @if(Auth::user()->image)
                                    {!! HTML::image('images/user/'.Auth::user()->image, 'a picture', array('class' => 'thumb')) !!}
                                    @else
                                    {!! HTML::image('images/user/default.jpg', 'a picture', array('class' => 'thumb')) !!}
                                    @endif
                                </div>                                    
                                <div class="media-body">
                                    <h3 class="media-heading">
                                        @if( Auth::check() )
                                        {{ Auth::user()->name }}
                                        @endif
                                    </h3>                                      
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-table"></i> Invoice Details</h3>
                                        </div>                                            
                                        <div class="panel-body">
                                            <div class="form-inline">
                                                <div class="form-group col-sm-3 col-md-3">
                                                    <label for="invoice_no">Invoice ID# : </label> 
                                                    <label for="invoice_no" style="font-weight: bold;">{{ $auto_invoice_no }}</label>
                                                </div>
                                                <div class="form-group col-sm-4 col-md-4">
                                                    <label class="control-label" for="invoiceDateTime">Date/Time : </label>
                                                    <label class="control-label" id="invoiceDateTime" name="invoiceDateTime"><?php echo date('d/m/Y h:i:s A'); ?></label>
                                                </div>  
                                                <div class="form-group col-sm-5  col-md-5"> 
                                                    <label class="control-label" for="po_id">Select PO : </label>
                                                    <select class="form-control" id="po_id" name='po_id'>
                                                        <option value="">Select PO</option>
                                                        @foreach($po as $value)
                                                        <option value="{{$value->id}}" {{ isset($invoiceOrder->po_id)?($value->id == $invoiceOrder->po_id) ? 'Selected' : '' : ''}} >{{$value->po_number}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-home"></i> Billing Info:</h3>
                                        </div>
                                        {!! HTML::ul($errors->all()) !!}
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="companyName" class="col-sm-4 control-label">Company Name:</label>
                                                <div class="col-sm-8">
                                                    {!! Form::text('comp_name',Input::old('comp_name',isset($invoiceOrder->comp_name) ? $invoiceOrder->comp_name : '') ,array('class'=>'form-control', 'placeholder' => 'Company Name','id' => 'comp_name')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="buildingNumber" class="col-sm-4 control-label">Building Number:</label>
                                                <div class="col-sm-8">
                                                    {!! Form::text('building_no',Input::old('building_no',isset($invoiceOrder->building_no) ? $invoiceOrder->building_no : '') ,array('class'=>'form-control', 'placeholder' => 'Building Number','id' => 'building_no')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="streetAddress" class="col-sm-4 control-label">Street Address:</label>
                                                <div class="col-sm-8">
                                                    {!! Form::text('street_addrs',Input::old('street_addrs',isset($invoiceOrder->street_addrs) ? $invoiceOrder->street_addrs : '') ,array('class'=>'form-control', 'placeholder' => 'Street Address','id' => 'street_addrs')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="interiorNumber" class="col-sm-4 control-label">Interior Number:</label>
                                                <div class="col-sm-8">
                                                    {!! Form::text('interior_no',Input::old('interior_no',isset($invoiceOrder->interior_no) ? $invoiceOrder->interior_no : '') ,array('class'=>'form-control', 'placeholder' => 'Interior Number','id' => 'interior_no')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="city" class="col-sm-4 control-label">City:</label>
                                                <div class="col-sm-8">
                                                    {!! Form::text('city',Input::old('city',isset($invoiceOrder->city) ? $invoiceOrder->city : '') ,array('class'=>'form-control', 'placeholder' => 'City','id' => 'city')) !!}
                                                </div>                                                               
                                            </div>
                                            <div class="form-group">
                                                <label for="state" class="col-sm-4 control-label">State:</label>
                                                <div class="col-sm-8">
                                                    {!! Form::text('state',Input::old('state',isset($invoiceOrder->state) ? $invoiceOrder->state : '') ,array('class'=>'form-control', 'placeholder' => 'State','id' => 'state')) !!} 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="zipCode" class="col-sm-4 control-label">ZipCode:</label>
                                                <div class="col-sm-8">
                                                    {!! Form::text('zipcode',Input::old('zipcode',isset($invoiceOrder->zipcode) ? $invoiceOrder->zipcode : '') ,array('class'=>'form-control', 'placeholder' => 'ZipCode','id' => 'zipcode')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="country" class="col-sm-4 control-label">Country:</label>
                                                <div class="col-sm-8">
                                                    <select name="country" class="form-control textinput" aria-invalid="false" id="country">
                                                        <option value="USA" <?php if (isset($invoiceOrder)) echo ($invoiceOrder->country == 'USA') ? 'selected' : ''; ?>>USA</option>
                                                        <option value="Germany" <?php if (isset($invoiceOrder)) echo ($invoiceOrder->country == 'Germany') ? 'selected' : ''; ?>>Germany</option>
                                                    </select>
<!--                                                    {!! Form::select('country',['USA'=>'USA','Germany'=>'Germany'],'', array('class' => 'form-control'))!!}-->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="phoneNumber" class="col-sm-4 control-label">Phone Number:</label>
                                                <div class="col-sm-8">
                                                    {!! Form::text('phone_no',Input::old('phone_no',isset($invoiceOrder->phone_no) ? $invoiceOrder->phone_no : '') ,array('class'=>'form-control', 'placeholder' => 'Phone Number','id' => 'phone_no')) !!}
                                                </div>
                                            </div>
                                        </div>                                                       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-truck"></i> Shipping Info:</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">  
                                                <label for="oldShippingInfo" class="col-sm-4 control-label">Select Shipping Details :</label>
                                                <div class="col-sm-6">
                                                    <select class="form-control col-sm-6" id="oldShippingInfo" name='oldShippingInfo'>                                                            
                                                    </select>                                                       
                                                </div>
                                            </div>
                                            <div class="form-group"> 
                                                <div class="col-sm-10">
                                                    <label for="shippingInfo" class="control-label">Or Add New Shipping Information :</label>
                                                    {!! Form::checkbox('addNew','','',array('value'=>'Add New','id'=>'addNew')) !!}
                                                </div>
                                            </div>
                                            <div id='newdetails' style="display: none;">
                                                <div class="form-group">
                                                    <label for="companyName" class="col-sm-4 control-label">Company Name:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('shpcomp_name',Input::old('shpcomp_name',isset($cust->comp_name) ? $cust->comp_name : '') ,array('class'=>'form-control', 'placeholder' => 'Company Name')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="buildingNumber" class="col-sm-4 control-label">Building Number:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('shpbuilding_no',Input::old('shpbuilding_no',isset($cust->building_no) ? $cust->building_no : '') ,array('class'=>'form-control', 'placeholder' => 'Building Number')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="streetAddress" class="col-sm-4 control-label">Street Address:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('shpstreet_addrs',Input::old('shpstreet_addrs',isset($cust->street_addrs) ? $cust->street_addrs : '') ,array('class'=>'form-control', 'placeholder' => 'Street Address')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="interiorNumber" class="col-sm-4 control-label">Interior Number:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('shpinterior_no',Input::old('shpinterior_no',isset($cust->interior_no) ? $cust->interior_no : '') ,array('class'=>'form-control', 'placeholder' => 'Interior Number')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="city" class="col-sm-4 control-label">City:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('shpcity',Input::old('shpcity',isset($cust->city) ? $cust->city : '') ,array('class'=>'form-control', 'placeholder' => 'City')) !!}
                                                    </div>                                                               
                                                </div>
                                                <div class="form-group">
                                                    <label for="state" class="col-sm-4 control-label">State:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('shpstate',Input::old('shpstate',isset($cust->state) ? $cust->state : '') ,array('class'=>'form-control', 'placeholder' => 'State')) !!} 
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="zipCode" class="col-sm-4 control-label">ZipCode:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('shpzipcode',Input::old('shpzipcode',isset($cust->zipcode) ? $cust->zipcode : '') ,array('class'=>'form-control', 'placeholder' => 'ZipCode')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="country" class="col-sm-4 control-label">Country:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::select('shpcountry',['USA'=>'USA','Germany'=>'Germany'],'', array('class' => 'form-control'))!!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phoneNumber" class="col-sm-4 control-label">Phone Number:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('shpphone_no',Input::old('shpphone_no',isset($cust->phone_no) ? $cust->phone_no : '') ,array('class'=>'form-control', 'placeholder' => 'Phone Number')) !!}
                                                    </div>
                                                </div> 
                                                <div class="form-group">
                                                    <label for="identifier" class="col-sm-4 control-label">Identifier :</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="phoneNumber" placeholder="Phone Number">-->
                                                        {!! Form::text('shpidentifer','' ,array('class'=>'form-control', 'placeholder' => 'Identifier')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-bars"></i> Products</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table id="invoiceProductTbl" class="display table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th style="width:20%;">SKU</th>
                                                            <th style="width:35%;">Description</th>
                                                            <th style="width:8%;">Qty</th>
                                                            <th style="width:10;">Unit Price</th>
                                                            <th style="width:11%;">DIscount %</th>
                                                            <th style="width:9%;">Amount</th>
                                                            <th style="width:25%;">Action</th>
                                                        </tr> 
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" id="deleteOrder" name="deleteOrder">
                                                                <input type="hidden" id="allOrderData" name="orders" value="">
                                                                <input type="hidden" id="updateId" value="0">
                                                            </td>
                                                            <td>
                                                                <select class="form-control SKUselect2" id="skuOrder" name='skuOrder'></select>
                                                            </td>
                                                            <td>
<!--                                                                <input id="vDescription" autocomplete="off" class="input form-control" name="searchDescription" type="text" placeholder="searchDescription"/>-->
                                                                <label id="vDescription" name="searchDescription"></label>
                                                            </td>
                                                            <td>
                                                                <input id="vPurchaseQty" name="vQty" autocomplete="off" class="input form-control" type="text" placeholder="qty"/>
                                                            </td>
                                                            <td>
                                                                <label id="vUnitPrice"></label>
                                                            </td>
                                                            <td>
                                                                <input id="vDiscount" name="Discount" autocomplete="off" class="input form-control" type="text" placeholder="Discount"/>
                                                            </td>
                                                            <td>
                                                                <label id="vTotalPrice"></label>
                                                            </td>
                                                            <td>
                                                                <button id="vAddMoreOrder" class="btn btn-primary" type="button"><i class="fa fa-plus"></i> Add</button>
                                                                <button id="vCancelUpdate" class="btn btn-warning" type="button" style="display: none;"><i class="fa fa-reply"></i></button>
                                                            </td>                                                            
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <td colspan="7">
                                                            <span style="margin-left: 50%;">
                                                                Total Quantity : <label id="vTotalQuantity">0</label>
                                                            </span>
                                                            <span style="margin-left: 15%;">
                                                                Total Amount : <label id="vTotalAmout">0</label>
                                                            </span>                                                    
                                                        </td>
                                                    </tfoot>
                                                </table>
                                            </div>                               

                                            <div class="form-group col-sm-12">
                                                <label for="shippingMethod" class="control-label col-sm-2" >Shipping Method:</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control" id="shippingMethod" name="shippingMethod">
                                                        <option value="Air" <?php if (isset($invoiceOrder)) echo ($invoiceOrder->type == 'Air') ? 'selected' : ''; ?>>Air</option>
                                                        <option value="Express" <?php if (isset($invoiceOrder)) echo ($invoiceOrder->type == 'Express') ? 'selected' : ''; ?>>Express</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-7">
                                                    {!! Form::label('Payment Term:','',array('class'=>'control-label','for'=>'payment_terms')) !!}
                                                    {!! Form::label('','',array('class'=>'control-label','id'=>'payment_terms')) !!} &nbsp;&nbsp;&nbsp;
                                                    {!! Form::label('Due Date:','',array('class'=>'control-label','for'=>'req_date')) !!}
                                                    {!! Form::label('','',array('class'=>'control-label','id'=>'req_date')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12 text-center">
                                                    <input type="submit" value="Generate / Update" id="btnSubmit" class="btn btn-primary" style="margin-top: 10px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>                       
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script type="text/x-jQuery-tmpl" id="InvoiceOrderTemplate">
    <tr class="newInvoiceData" id="newOrder-${orderNo}">
        <td>
            <input type="hidden" class="orderId" value="${orderId}">
            ${orderNo}
        </td>           
        <td>
            <label id="${skuId}" orderid="${purchaseOrderId}" invoiceorderid="${invoiceOrderId}" class="sku">${skuLabel}</label>
        </td>
        <td>
            <label class="description">${description}</label>
        </td>
        <td>
            <label class="purchaseQty">${purchaseQty}</label>
        </td>
        <td>
            <label class="unitPrice">${unitPrice}</label>
        </td>
         <td>
            <label class="discount">${discount}</label>
        </td>
        <td>
            <label class="totalPrice">${totalPrice}</label>
        </td>
        <td>
            <button type="button" class="btn btn-danger del" onclick="return removeNewOrder(this)"><i class="fa fa-trash-o"></i></button>
            <button type="button" class="btn btn-primary edit" onclick="editNewOrder(this)"><i class="fa fa-edit"></i></button>
        </td>
    </tr>
</script>

<!-- Modal Start -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal">   
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Product</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <div class="form-group">
                            <label for="editSKU" class="col-sm-4 control-label">SKU :</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="editSKU" placeholder="BF0013">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editDescription" class="col-sm-4 control-label">Description :</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="editDescription" placeholder="Barcelona FC sport Jersey">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editQty" class="col-sm-4 control-label">Qty :</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="editQty" placeholder="50">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editUnitPrice" class="col-sm-4 control-label">Unit Price :</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="editUnitPrice" placeholder="13">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editDiscount" class="col-sm-4 control-label">Discount :</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="editDiscount" placeholder="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editAmount" class="col-sm-4 control-label">Amount :</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="editAmount" placeholder="5000">
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add more Order Template-->
<script type="text/x-jQuery-tmpl" id="new-invoice-template">
    <tr class="newInvoiceData" id="newOrder-${orderNo}">
    <td>
    ${orderNo}
    </td>           
    <td>
    <label id="${skuId}" class="sku">${skuLabel}</label>
    </td>
    <td>
    <label class="description">${description}</label>
    </td>
    <td>
    <label class="purchaseQty">${purchaseQty}</label>
    </td>
    <td>
    <label class="unitPrice">${unitPrice}</label>
    </td>
    <td>
    <label class="totalPrice">${totalPrice}</label>
    </td>
    <td>
    <button type="button" class="btn btn-danger" onclick="removeNewInvoice(this)"><i class="fa fa-trash-o"></i></button>
    <button type="button" class="btn btn-primary" onclick="editNewInvoice(this)"><i class="fa fa-edit"></i></button>
    </td>
    </tr>
</script>
<!-- Modal End -->
@endsection