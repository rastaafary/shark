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
                            {!! Form::open(array('class'=>'form-horizontal','url'=>'/po/add','name'=>'PoCustomer','id'=>'PoCustomer','files' => true)) !!}
                            {!! Form::hidden('id',Input::old('id',isset(Auth::user()->id) ? Auth::user()->id : '')) !!}
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
                                                    <label for="orderpoId" style="font-weight: bold;">{{ Auth::user()->id.'-'.'001' }}</label>
                                                </div>
                                                <div class="form-group col-sm-6 col-md-4">
                                                    <label for="orderDate">Date : </label>
                                                    <!-- <input id="orderDate" type="text" value="" size="16" class="form-control default-date-picker"> -->
                                                    {!! Form::text('orderDate',Input::old('orderDate',isset($cust->orderDate) ? $cust->orderDate : '') ,array('class'=>'form-control default-date-picker', 'placeholder' => 'Date', 'id' => 'orderDate')) !!}
                                                </div>
                                                <div class="form-group col-sm-6 col-md-4">
                                                    <label for="orderTime">Time : </label>
                                                    <input type="email" class="form-control" id="orderTime" placeholder="11:14:00AM">
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
                                            <div class="table-responsive">
<!--                                                <table  class="display table table-bordered table-striped">-->
                                                   <!-- <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>SKU</th>
                                                            <th>Description</th>
                                                            <th>Qty</th>
                                                            <th>Unit Price</th>
                                                            <th>Amount</th>
                                                            <th>Action</th>
                                                        </tr> 
                                                    </thead>  -->                                            

                                                    <div class="controls" id="profs"> 
                                                        <script type="text/template" id="element-template">
                                                            <div class="addpo">        
                                                            <select name="sku[]" id="sku" onChange="getinfo(this);" class ='sku'><?php echo $sku; ?></select>
                                                            <input autocomplete="off" id="searchDescription" class="input" name="searchDescription[]" type="text" placeholder="searchDescription"/>
                                                            <input autocomplete="off" id="searchQty" onkeydown="edValueKeyPress(event);"  onblur="calAmount(this);" class="input" name="searchQty[]" type="text" placeholder="qty"/>
                                                            <input autocomplete="off" id="unitprice" class="input" name="unitprice[]" type="text" placeholder="unitprice" readonly/>
                                                            <input autocomplete="off" id="amount" class="input" name="amount[]" type="text" placeholder="amount"/>
                                                            <input type="button" class="remove" onclick="removediv(this)" value="remove">
                                                            <br>
                                                            </div>
                                                        </script> 
                                                         <button id="b1" class="btn btn-primary add-more" type="button">Add</button>  
                                                        <div id="maindiv">

                                                        </div>                                                        
                                                       
    <!--                                                        <td><a href="javascript:void(0)" id="addorder" class="btn btn-primary"><span class="fa fa-plus"></span> Add</a></td>-->
                                                    </div>
                                                    <div class="container">
                                                        
<!--                                                   </tr>     <tr class="gradeX">
                                                            <td>1</td>
                                                            <td>BF0013</td>
                                                            <td>Barcelona FC sport Jersey</td>
                                                            <td>50</td>
                                                            <td>13</td>
                                                            <td>$5000</td>
                                                            <td><a href="#" class="btn btn-danger"><span class="fa fa-trash-o"></span> </a> 
                                                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editProductModal"><span class="fa fa-pencil"></span></a></td>
                                                        </tr>                                                 
                                                        <tr class="gradeX">
                                                            <td></td>
                                                            <td></td>
                                                            <td align="right"><label class="control-label">Total Qty :</label></td>                                                               
                                                            <td><input type="text" class="form-control" id="totalQty" placeholder="50" size="3"></td>
                                                            <td></td>
                                                            <td align="right"><label class="control-label">Total Amount:</label></td> 
                                                            <td><input type="text" class="form-control" id="totalAmount" placeholder="$5000" size="5"></td>
                                                            <td></td>
                                                        </tr> 
                                                        </tbody>
                                                </table>-->
                                            </div>                                     
                                            <div class="form-group">
                                                <label for="comment" class="col-sm-2 col-md-1 control-label">Comment:</label>
                                                <div class="col-sm-10 col-md-11">                                                            
                                                    <!--<textarea class="form-control" rows="3" placeholder="Company Name" id="comment">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</textarea>-->
                                                    {!! Form::textarea('comments',Input::old('phone_no',isset($cust->phone_no) ? $cust->phone_no : ''), array('class'=>'form-control','rows'=>'3','placeholder'=>'Comments','id' => 'comments'))!!}
                                                </div>
                                            </div>

                                            <div class="form-group" align="center">
                                                <!--<input type="submit" value="Submit" id="btnSubmit" class="btn btn-primary" style="margin-top: 10px;">-->
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
                <table id="po_cust_order" class="display table table-bordered table-striped">
                    <thead>
                        <tr>
                            
                            <th>SKU</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr> 
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</div>

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
