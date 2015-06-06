@extends('layouts.main')
@section('content')
{!! HTML::script('js/PoCustomer.js') !!}

<script>
    var oldOrderData = <?php echo (isset($orderlist)) ? json_encode($orderlist) : '[]'; ?>;

</script>
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li><a href="{!!url('/po')!!}">List</a></li>
                        <li class="active"><a href="{!!url('#Add')!!}"><?php echo isset($id) ? 'Edit' : 'Add'; ?></a></li>                       
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
                            {!! Form::open(array('class'=>'form-horizontal','url'=>'/po/edit/'.$id,'name'=>'PoCustomer','id'=>'PoCustomer','files' => true)) !!}
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
                                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
                                @if(!isset($id))                               
                                <div class="form-group col-sm-4 col-md-3">
                                    <label for="orderpoId">Select Customer : </label>
                                    <select name="selectPOCustomer" id="selectPOCustomer" class ='POselect2 form-control'><?php echo $custData; ?></select>
                                    <div style="color: red">
                                        <?php echo $errors->first('selectPOCustomer'); ?>                                        
                                    </div>    
                                </div>
                                @else
                                <div class="form-group col-sm-6 col-md-4">
                                    <label >Company Name :  </label>                                                  
                                    <label for="orderpoId" style="font-weight: bold;"><?= $cust->comp_name ?></label>                                                   
                                </div>
                                @endif
                                @endif
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
                                                    <label for="orderpoId" style="font-weight: bold;"><?= $autoId ?></label>                                                   
                                                </div>

                                                <div class="form-group col-sm-6 col-md-4">
                                                    <div style="color: red">
                                                        <?php echo $errors->first('orderDate'); ?> 
                                                    </div>
                                                    <label for="orderDate">Date : </label>
                                                    <!-- <input id="orderDate" type="text" value="" size="16" class="form-control default-date-picker"> -->
                                                    {!! Form::text('orderDate',Input::old('orderDate',isset($purchaseOrder->date) ? $purchaseOrder->date : date("Y/m/d")) ,array('class'=>'form-control default-date-picker','id' => 'orderDate')) !!}
                                                </div>
                                                <div class="form-group col-sm-6 col-md-4">
                                                    <label for="orderTime">Time : </label>
                                                    <!--<input type="text" class="form-control" id="orderTime" name="time" placeholder="11:14 AM">-->
                                                    {!! Form::text('time',Input::old('time',isset($purchaseOrder->time) ? "date('h:i A', strtotime($purchaseOrder->time))" : date("H:i A")) ,array('class'=>'form-control', 'placeholder' => '11:14 AM', 'id' => 'orderTime')) !!}
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

                                        <div class="panel-body">                                            
                                            <div class="form-group">
                                                <label for="shippingDetails" class="col-sm-4 control-label">Shipping Details:</label>
                                                <div class="col-sm-8">
                                                    <!--{!! Form::select('shippingDetails', ['1'=>'1'],'', array('class' => 'form-control')) !!}-->
                                                    <select class="form-control" id='oldIdentifire' name='oldIdentifire'>
                                                        @if(Auth::user()->hasRole('customer'))
                                                        @if(count($shipping) > 0)
                                                        @foreach($shipping as $value)
                                                        <option value="{{$value->id}}" <?php if (isset($purchaseOrder)) echo ($value->id == $purchaseOrder->shipping_id) ? 'selected' : ''; ?> >{{$value->identifier}}</option>
                                                        @endforeach
                                                        @endif
                                                        @endif

                                                        @if(isset($id))
                                                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('admin'))
                                                        @if(count($shipping) > 0)
                                                        @foreach($shipping as $value)
                                                        <option value="{{$value->id}}" <?php if (isset($purchaseOrder)) echo ($value->id == $purchaseOrder->shipping_id) ? 'selected' : ''; ?> >{{$value->identifier}}</option>
                                                        @endforeach
                                                        @endif
                                                        @endif                                                        
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="newshippingDetails" class="col-sm-4 control-label">Add New Details:</label>
                                                <div class="col-sm-8">
                                                    <input type="checkbox" name="addNew" id="addNew">
                                                    <!--                                                    {!! Form::checkbox('addNew','','',array('value'=>'Add New','id'=>'addNew')) !!}-->
                                                </div>
                                            </div>
                                            <div id='newdetails' style="display: none;">
                                                <div class="form-group">
                                                    <label for="companyName" class="col-sm-4 control-label">Company Name:</label>
                                                    <div class="col-sm-8">
                                                       <!-- <input type="text" class="form-control" id="companyName" placeholder="Company Name">-->
                                                        {!! Form::text('comp_name',Input::old('comp_name',isset($purchaseOrder->comp_name) ? $purchaseOrder->comp_name : '') ,array('class'=>'form-control', 'placeholder' => 'Company Name')) !!}
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
                                                        {!! Form::text('building_no',Input::old('building_no',isset($purchaseOrder->building_no) ? $purchaseOrder->building_no : '') ,array('class'=>'form-control', 'placeholder' => 'Building Number')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="streetAddress" class="col-sm-4 control-label">Street Address:</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="streetAddress" placeholder="Street Address">-->
                                                        {!! Form::text('street_addrs',Input::old('street_addrs',isset($purchaseOrder->street_addrs) ? $purchaseOrder->street_addrs : '') ,array('class'=>'form-control', 'placeholder' => 'Street Address')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="interiorNumber" class="col-sm-4 control-label">Interior Number:</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="interiorNumber" placeholder="Interior Number">-->
                                                        {!! Form::text('interior_no',Input::old('interior_no',isset($purchaseOrder->interior_no) ? $purchaseOrder->interior_no : '') ,array('class'=>'form-control', 'placeholder' => 'Interior Number')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="city" class="col-sm-4 control-label">City:</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="city" placeholder="City">-->
                                                        {!! Form::text('city',Input::old('city',isset($purchaseOrder->city) ? $purchaseOrder->city : '') ,array('class'=>'form-control', 'placeholder' => 'City')) !!}
                                                    </div>                                                               
                                                </div>
                                                <div class="form-group">
                                                    <label for="State" class="col-sm-4 control-label">State:</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="State" placeholder="State">-->
                                                        {!! Form::text('state',Input::old('state',isset($purchaseOrder->state) ? $purchaseOrder->state : '') ,array('class'=>'form-control', 'placeholder' => 'State')) !!} 
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="zipCode" class="col-sm-4 control-label">ZipCode:</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="zipCode" placeholder="ZipCode">-->
                                                        {!! Form::text('zipcode',Input::old('zipcode',isset($purchaseOrder->zipcode) ? $purchaseOrder->zipcode : '') ,array('class'=>'form-control', 'placeholder' => 'ZipCode')) !!}
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
                                                        {!! Form::text('phone_no',Input::old('phone_no',isset($purchaseOrder->phone_no) ? $purchaseOrder->phone_no : '') ,array('class'=>'form-control', 'placeholder' => 'Phone Number')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="identifier" class="col-sm-4 control-label">Identifier :</label>
                                                    <div class="col-sm-8">
                                                        <!--<input type="text" class="form-control" id="phoneNumber" placeholder="Phone Number">-->
                                                        {!! Form::text('identifer',Input::old('identifer',isset($purchaseOrder->identifier) ? $purchaseOrder->identifier : '') ,array('class'=>'form-control', 'placeholder' => 'Identifer')) !!}
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
                                            <div style="color: red">
                                                <?php echo $errors->first('require_date'); ?>  
                                                <?php echo $errors->first('payment_terms'); ?>
                                                <?php echo $errors->first('shippingMethod'); ?>
                                            </div>
                                            <div class="form-group">
                                                <label for="shippingMethod" class="col-sm-4 control-label">Shipping Method:</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="shippingMethod" name="shippingMethod">
                                                        <option value="Air" <?php if (isset($purchaseOrder)) echo ($purchaseOrder->type == 'Air') ? 'selected' : ''; ?>>Air</option>
                                                        <option value="Express" <?php if (isset($purchaseOrder)) echo ($purchaseOrder->type == 'Express') ? 'selected' : ''; ?>>Express</option>
                                                    </select>
                                                    <!--                                                    {!! Form::select('shippingMethod', ['Air' => 'Air', 'Express' => 'Express'], isset($PoCust->shippingMethod) ? $PoCust->shippingMethod:'Air', array('class' => 'form-control')) !!}-->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="paymentTerms" class="col-sm-4 control-label">Payment Terms:</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="payment_terms" name="payment_terms">
                                                        <option value="15Days" <?php if (isset($purchaseOrder)) echo ($purchaseOrder->payment_terms == '15Days') ? 'selected' : ''; ?>>15Days</option>
                                                        <option value="30Days" <?php if (isset($purchaseOrder)) echo ($purchaseOrder->payment_terms == '30Days') ? 'selected' : ''; ?>>30Days</option>
                                                        <option value="Payment Before Shipment" <?php if (isset($purchaseOrder)) echo ($purchaseOrder->payment_terms == 'Payment Before Shipment') ? 'selected' : ''; ?>>Payment Before Shipment</option>
                                                    </select>
                                                    <!--                                                    {!! Form::select('payment_terms', ['15Days' => '15Days', '30Days' => '30Days','Payment Before Shipment'=>'Payment Before Shipment'], isset($PoCust->payment_terms) ? $PoCust->payment_terms:'15Days', array('class' => 'form-control')) !!}-->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="requiredDate" class="col-sm-4 control-label">Required Date:</label>
                                                <div class="col-sm-8">
                                                    <!--<input id="requiredDate" type="text" value="" size="16" class="form-control default-date-picker">-->
                                                    {!! Form::text('require_date',Input::old('require_date',isset($purchaseOrder->require_date) ? $purchaseOrder->require_date : '') ,array('class'=>'form-control default-date-picker', 'placeholder' => 'Require Date', 'id' => 'require_date')) !!}
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
                                            <div style="color: red">
                                                <?php echo $errors->first('PDF'); ?>                                        
                                            </div>                                                                                  
                                            <div class="form-group">
                                                <label for="uploadArtPDF" class="col-sm-4 control-label">Upload Art PDF:</label>
                                                <div class="col-md-8">
                                                    <input id="uploadArtPDF" type="file" name="PDF">
                                                    <?php
                                                    if (isset($purchaseOrder->pdf)) {
                                                        if (!empty($purchaseOrder->pdf)) {
                                                            ?>
                                                            <a href="{!!url('/')!!}/files/<?php echo isset($purchaseOrder->pdf) ? $purchaseOrder->pdf : '' ?>" target="_new">Click To View</a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="uploadArtPDF" class="col-sm-4 control-label">Upload Art Ai:</label>
                                                <div class="col-md-8">
                                                    <input id="uploadArtAi" type="file" name="Ai">
                                                    <?php
                                                    if (isset($purchaseOrder->ai)) {
                                                        if (!empty($purchaseOrder->ai)) {
                                                            ?>
                                                            <a href="{!!url('/')!!}/files/<?php echo isset($purchaseOrder->ai) ? $purchaseOrder->ai : '' ?>" target="_new">Click To View</a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Upload Image:</label>
                                                <?php
                                                if (isset($poImages) && !empty($poImages)) {
                                                    foreach ($poImages as $image) {
                                                        if (isset($image->fileName) && !empty($image->fileName)) {
                                                            ?>
                                                            <span class="col-lg-offset-4 col-sm-8">
                                                                <a href="{!!url('/')!!}/files/poMultiImage/<?php echo $image->fileName; ?>" target="_new">Click To View</a>
                                                                &nbsp;<a href='javascript:void(0);' class='deleteDbImage text-danger' title='Delete image' imageId="<?php echo $image->id; ?>"><i class='fa fa-trash-o margin-top-10'></i></a><br/>
                                                            </span>                                                       
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                                <div class="col-lg-offset-4 col-md-6">
                                                    <input type="file" name="uploadImage[]">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-primary" title="Add more images" onclick="addMoreImages()"><i class="fa fa-plus"></i> Add</button>
                                                </div>
                                            </div>
                                            <div id="moreImagesDiv"></div>
                                            <div style="color: red">
                                                <?php echo $errors->first('uploadImage'); ?>                                        
                                            </div>   

                                            @if(isset($id))
                                            <a class="btn btn-link" href="{!!url('/blogArt')!!}<?= $purchaseOrder->po_id ?>" role="button"><strong>Blog Art</strong></a>                                          
                                            @endif
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
                                                            <th style="width: 25%;">Description</th>
                                                            <th style="width: 25%;">Size</th>
                                                            <th style="width: 10%;">Qty</th>
                                                            <th style="width: 10%;">Unit Price</th>
                                                            <th style="width: 10%;">Amount</th>
                                                            <th style="width: 18%;">Action</th>
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
                                                                <select name="sku" id="skuOrder" onChange="getinfo(this);" class ='sku select2 form-control'><?php echo $sku; ?></select>
                                                            </td>
                                                            <td>
<!--                                                                <input autocomplete="off" id="searchDescription" class="input form-control" name="searchDescription[]" type="text" placeholder="searchDescription"/>-->
                                                                <label id="searchDescription" name="searchDescription[]" class="control-label"></label>
                                                            </td>
                                                            <td>
<!--                                                                <input autocomplete="off" id="searchDescription" class="input form-control" name="searchDescription[]" type="text" placeholder="searchDescription"/>-->
                                                                <label id="size" name="size[]" class="control-label"></label>
                                                            </td>
                                                            <td>
                                                                <input autocomplete="off" id="purchaseQty" class="input form-control" type="text" placeholder="qty"/>
                                                            </td>
                                                            <td>
                                                                <label id="unitPrice" class="control-label"></label>
                                                            </td>
                                                            <td>
                                                                <label id="totalPrice" class="control-label"></label>
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
                                                        {!! Form::textarea('comments',Input::old('comments',isset($purchaseOrder->comments) ? $purchaseOrder->comments : ''), array('class'=>'form-control','rows'=>'3','placeholder'=>'Comments','id' => 'comments'))!!}
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
    <input type="hidden" class="orderId" value="${orderId}">
    ${orderNo}
    </td>           
    <td>
    <label id="${skuId}" class="sku">${skuLabel}</label>
    </td>
    <td>
    <label class="description">${description}</label>
    </td>
    <td>
    <label class="size">${size}</label>
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
    <button type="button" class="btn btn-danger" onclick="return removeNewOrder(this)"><i class="fa fa-trash-o"></i></button>
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
