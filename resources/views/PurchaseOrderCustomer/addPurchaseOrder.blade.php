@extends('layouts.main')

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li><a href="/po">List</a></li>
                        <li class="active"><a href="#Add">Add</a></li>                       
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">                        
                        <div class="tab-pane active" id="Add">
                            <!-- <form class="form-horizontal">-->
                            @if(!isset($id))
                            {!! Form::open(array('class'=>'form-horizontal','url'=>'/po/add','name'=>'PoCustomer','id'=>'PoCustomer','files' => true)) !!}
                            {!! Form::hidden('id',Input::old('id',isset(Auth::user()->id) ? Auth::user()->id : '')) !!}
                            @else                             
                            {!! Form::open(array('class'=>'form-horizontal','url'=>'/po/edit','name'=>'PoCustomer','id'=>'PoCustomer','files' => true)) !!}
                            {!! Form::hidden('id',Input::old('id',isset(Auth::user()->id) ? Auth::user()->id : '')) !!}
                            @endif
                            <div class="media usr-info">
                                <div class="pull-left">
                                    @if(Auth::user()->image)
                                    {!! HTML::image('images/user/'.Auth::user()->image, 'a picture', array('class' => 'thumb')) !!}
                                    @else
                                    {!! HTML::image('images/user/default.jpg', 'a picture', array('class' => 'thumb')) !!}
                                    @endif
                                </div>                                    
                                <div class="media-body">
                                    <h3 class="media-heading">@if( Auth::check() )
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
                                            <h3 class="panel-title"><i class="fa fa-table"></i> Order Details</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-inline">
                                                <div class="form-group col-sm-6 col-md-4">
                                                    <label for="orderpoId">PO # : </label>
                                                    <label for="orderpoId" style="font-weight: bold;"><?=$autoId?></label>
                                                </div>
                                                <div class="form-group col-sm-6 col-md-4">
                                                    <label for="orderDate">Date : </label>
                                                    <!-- <input id="orderDate" type="text" value="" size="16" class="form-control default-date-picker"> -->
                                                    {!! Form::text('orderDate',Input::old('orderDate',isset($cust->orderDate) ? $cust->orderDate : '') ,array('class'=>'form-control default-date-picker', 'placeholder' => 'Date', 'id' => 'orderDate')) !!}
                                                </div>
                                                <div class="form-group col-sm-6 col-md-4">
                                                    <label for="orderTime">Time : </label>
                                                    <input type="text" class="form-control" id="orderTime" placeholder="11:14:00AM">
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
                                            <h3 class="panel-title"><i class="fa fa-home"></i> Address Details</h3>
                                        </div>
                                        {!! HTML::ul($errors->all()) !!}
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="shippingDetails" class="col-sm-4 control-label">Shipping Details:</label>
                                                <div class="col-sm-8">
                                                    <!--{!! Form::select('shippingDetails', ['1'=>'1'],'', array('class' => 'form-control')) !!}-->
                                                    <select class="form-control" id='oldIdentifire' name='oldIdentifire'>
                                                        @foreach($shipping as $value)
                                                        <option value="{{$value->identifier}}">{{$value->identifier}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="newshippingDetails" class="col-sm-4 control-label">Add New Details:</label>
                                                <div class="col-sm-8">
                                                    {!! Form::checkbox('addNew','','',array('value'=>'Add New','id'=>'addNew')) !!}
                                                </div>
                                            </div>
                                            <div id='newdetails' style="display: none;">
                                                <div class="form-group">
                                                    <label for="companyName" class="col-sm-4 control-label">Company Name:</label>
                                                    <div class="col-sm-8">
                                                       <!-- <input type="text" class="form-control" id="companyName" placeholder="Company Name">-->
                                                        {!! Form::text('comp_name',Input::old('comp_name',isset($cust->comp_name) ? $cust->comp_name : '') ,array('class'=>'form-control', 'placeholder' => 'Company Name')) !!}
                                                    </div>
                                                </div>
                                                <!--                                                <div class="form-group">
                                                                                                    <label for="companyName" class="col-sm-4 control-label">ame:</label>
                                                                                                    <div id="the-basics" class="col-sm-8">
                                                                                                        <input class="typeahead" type="text" placeholder="States of USA">
                                                                                                    </div> 
                                                                                                </div>-->
                                                <div class="form-group">
                                                    <label for="buildingNumber" class="col-sm-4 control-label">Building Number:</label>
                                                    <div class="col-sm-8">
                                                       <!-- <input type="text" class="form-control" id="buildingNumber" placeholder="Building Number">-->
                                                        {!! Form::text('building_no',Input::old('building_no',isset($cust->building_no) ? $cust->building_no : '') ,array('class'=>'form-control', 'placeholder' => 'Building Number')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="streetAddress" class="col-sm-4 control-label">Street Address:</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="streetAddress" placeholder="Street Address">-->
                                                        {!! Form::text('street_addrs',Input::old('street_addrs',isset($cust->street_addrs) ? $cust->street_addrs : '') ,array('class'=>'form-control', 'placeholder' => 'Street Address')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="interiorNumber" class="col-sm-4 control-label">Interior Number:</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="interiorNumber" placeholder="Interior Number">-->
                                                        {!! Form::text('interior_no',Input::old('interior_no',isset($cust->interior_no) ? $cust->interior_no : '') ,array('class'=>'form-control', 'placeholder' => 'Interior Number')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="city" class="col-sm-4 control-label">City:</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="city" placeholder="City">-->
                                                        {!! Form::text('city',Input::old('city',isset($cust->city) ? $cust->city : '') ,array('class'=>'form-control', 'placeholder' => 'City')) !!}
                                                    </div>                                                               
                                                </div>
                                                <div class="form-group">
                                                    <label for="State" class="col-sm-4 control-label">State:</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="State" placeholder="State">-->
                                                        {!! Form::text('state',Input::old('state',isset($cust->state) ? $cust->state : '') ,array('class'=>'form-control', 'placeholder' => 'State')) !!} 
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="zipCode" class="col-sm-4 control-label">ZipCode:</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="zipCode" placeholder="ZipCode">-->
                                                        {!! Form::text('zipcode',Input::old('zipcode',isset($cust->zipcode) ? $cust->zipcode : '') ,array('class'=>'form-control', 'placeholder' => 'ZipCode')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="country" class="col-sm-4 control-label">Country:</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="country" placeholder="Country">-->
                                                        <!--{!! Form::select('country', ['USA' => 'USA', 'Germany' => 'Germany'], isset($cust->country) ? $cust->country:'USA', array('class' => 'form-control')) !!}-->
                                                        {!! Form::select('country',['USA'=>'USA','Germany'=>'Germany'],'', array('class' => 'form-control'))!!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phoneNumber" class="col-sm-4 control-label">Phone Number:</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="phoneNumber" placeholder="Phone Number">-->
                                                        {!! Form::text('phone_no',Input::old('phone_no',isset($cust->phone_no) ? $cust->phone_no : '') ,array('class'=>'form-control', 'placeholder' => 'Phone Number')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="identifier" class="col-sm-4 control-label">Identifier :</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="phoneNumber" placeholder="Phone Number">-->
                                                        {!! Form::text('identifer','' ,array('class'=>'form-control', 'placeholder' => 'Identifier')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                                       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-truck"></i> Shipping Details</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="shippingMethod" class="col-sm-4 control-label">Shipping Method:</label>
                                                <div class="col-sm-8">
                                                    <!--<select class="form-control" id="shippingMethod">
                                                        <option>Air</option>
                                                        <option>Express</option>
                                                    </select>-->
                                                    {!! Form::select('shippingMethod', ['Air' => 'Air', 'Express' => 'Express'], isset($PoCust->shippingMethod) ? $PoCust->shippingMethod:'Air', array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="paymentTerms" class="col-sm-4 control-label">Payment Terms:</label>
                                                <div class="col-sm-8">
                                                   <!-- <select class="form-control" id="paymentTerms">
                                                        <option>15Days</option>
                                                        <option>30Days</option>
                                                        <option>Payment Before Shipment</option>
                                                    </select>-->
                                                    {!! Form::select('payment_terms', ['15Days' => '15Days', '30Days' => '30Days','Payment Before Shipment'=>'Payment Before Shipment'], isset($PoCust->payment_terms) ? $PoCust->payment_terms:'15Days', array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="requiredDate" class="col-sm-4 control-label">Required Date:</label>
                                                <div class="col-sm-8">
                                                    <!--<input id="requiredDate" type="text" value="" size="16" class="form-control default-date-picker">-->
                                                    {!! Form::text('require_date',Input::old('require_date',isset($cust->require_date) ? $cust->require_date : '') ,array('class'=>'form-control default-date-picker', 'placeholder' => 'Require Date', 'id' => 'require_date')) !!}
                                                </div>
                                            </div>                                                                                                                                                                                          
                                        </div>                                                       
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-upload"></i> Details</h3>
                                        </div>
                                        <div class="panel-body">   
                                            <div class="form-group">
                                                <label for="uploadArtPDF" class="col-sm-4 control-label">Upload Art PDF:</label>
                                                <div class="col-md-8">
                                                    <!--<input id="uploadArtPDF" type="file">-->
                                                    {!! Form::file('PDF', Input::old('PDF',isset($cust->PDF) ? $cust->PDF : '')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="uploadArtPDF" class="col-sm-4 control-label">Upload Art Ai:</label>
                                                <div class="col-md-8">
                                                    <!--<input id="uploadArtAi" type="file">-->
                                                    {!! Form::file('Ai',  Input::old('Ai',isset($cust->Ai) ? $cust->Ai : '')) !!}
                                                </div>
                                            </div>                                                                                                                                
                                            <a class="btn btn-link" href="/blogArt/29" role="button"><strong>Blog Art</strong></a>                                          
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
                                            <div class="table-responsive col-md-12">
                                                <table id="purchaseOrderTbl" class="display table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th style="width: 18%;">SKU</th>
                                                            <th style="width: 35%;">Description</th>
                                                            <th style="width: 10%;">Qty</th>
                                                            <th style="width: 10%;">Unit Price</th>
                                                            <th style="width: 10%;">Amount</th>
                                                            <th style="width: 18%;">Action</th>
                                                        </tr> 
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" id="allOrderData" name="orders" value="">
                                                                <input type="hidden" id="updateId" value="0">
                                                            </td>
                                                            <td>
                                                                <select name="sku" id="skuOrder" onChange="getinfo(this);" class ='sku select2 form-control'><?php echo $sku; ?></select>
                                                            </td>
                                                            <td>
                                                                <input autocomplete="off" id="searchDescription" class="input form-control" name="searchDescription[]" type="text" placeholder="searchDescription"/>
                                                            </td>
                                                            <td>
                                                                <input autocomplete="off" id="purchaseQty" class="input form-control" type="text" placeholder="qty"/>
                                                            </td>
                                                            <td>
                                                                <label id="unitPrice"></label>
                                                            </td>
                                                            <td>
                                                                <label id="totalPrice"></label>
                                                            </td>
                                                            <td>
                                                                <button id="addMoreOrder" class="btn btn-primary" type="button"><i class="fa fa-plus"></i> Add</button>
                                                                <button id="cancelUpdate" class="btn btn-warning" type="button" style="display: none;"><i class="fa fa-reply"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="7">
                                                                <span style="margin-left: 45%;">
                                                                    Total Quantity : <label id="totalQuantity">0</label>
                                                                </span>
                                                                <span style="margin-left: 8%;">
                                                                    Total Amount : <label id="totalAmout">0</label>
                                                                </span>                                                    
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <div class="form-group mtop10">
                                                    <label for="comment" class="col-sm-2 col-md-1 control-label">Comment:</label>
                                                    <div class="col-sm-10 col-md-11">                                                            
                                                        {!! Form::textarea('comments',Input::old('phone_no',isset($cust->phone_no) ? $cust->phone_no : ''), array('class'=>'form-control','rows'=>'3','placeholder'=>'Comments','id' => 'comments'))!!}
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group" align="center">
                                                    {!! Form::submit('Save',array('class'=>'btn btn-primary', 'id'=>'btnSubmit')) !!}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--</form>-->
                                {!! Form::close() !!}

                            </div>                       
                        </div>
                    </div>
            </section>
        </div>
    </div>
</div>
<!-- Add more Order Template-->
<script type="text/x-jQuery-tmpl" id="new-order-template">
    <tr class="newOrderData" id="newOrder-${orderNo}">
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
            <button type="button" class="btn btn-danger" onclick="removeNewOrder(this)"><i class="fa fa-trash-o"></i></button>
            <button type="button" class="btn btn-primary" onclick="editNewOrder(this)"><i class="fa fa-edit"></i></button>
        </td>
    </tr>
</script>
<!-- Modal Start -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--            <form class="form-horizontal">-->
            {!! Form::open(array('class'=>'form-horizontal','url'=>'/po/editorder','name'=>'editorder','id'=>'editorder','files' => true)) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Product</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <input type="hidden" id="order_id" name="order_id" value="">
                    <div class="form-group">
                        <label for="editSKU" class="col-sm-4 control-label">SKU :</label>
                        <div class="col-sm-6">
<!--                             <select name="sku[]" id="sku" onChange="getinfo(this);"class ='sku'><?php echo $sku; ?></select>-->
                            <input type="text" name="editSKU" class="form-control" id="editSKU" placeholder="BF0013" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editDescription" class="col-sm-4 control-label">Description :</label>
                        <div class="col-sm-6">
                            <input type="text" name="editDescription" class="form-control" id="editDescription" placeholder="Barcelona FC sport Jersey" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editQty" class="col-sm-4 control-label">Qty :</label>
                        <div class="col-sm-6">
                            <input type="text" name="editQty" class="form-control" id="editQty" placeholder="50">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editUnitPrice" class="col-sm-4 control-label">Unit Price :</label>
                        <div class="col-sm-6">
                            <input type="text" name="editUnitPrice" class="form-control" id="editUnitPrice" placeholder="13" disabled>
                        </div>
                    </div>                                                    
                    <div class="form-group">
                        <label for="editAmount" class="col-sm-4 control-label">Amount :</label>
                        <div class="col-sm-6">
                            <input type="text" name="editAmount" class="form-control" id="editAmount" placeholder="5000" readonly>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
            <!--            </form>-->
        </div>
    </div>
</div>
<!-- Modal End -->  
@endsection
