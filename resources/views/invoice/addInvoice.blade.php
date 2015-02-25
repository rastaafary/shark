@extends('layouts.main')

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li><a href="/invoice">List</a></li>
                        <li class="active"><a href="#Add">Add</a></li>                       
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">                        
                        <div class="tab-pane active" id="Add">
                           {!! Form::open(array('class'=>'form-horizontal','url'=>'/invoice/add','name'=>'Invoice','id'=>'Invoice','files' => true)) !!}
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
                                                    <div class="form-group col-sm-4 col-md-4">
                                                        <label for="invoiceId">Invoice ID# : </label>
                                                        <input type="text" class="form-control" id="invoiceId" placeholder="IN0025">
                                                    </div>
                                                    <div class="form-group col-sm-4 col-md-4">
                                                        <label class="control-label" for="invoiceDateTime">Date/Time : </label>
                                                        <label class="control-label" id="invoiceDateTime" name="invoiceDateTime"><?php echo date('d/m/Y h:i:s A'); ?></label>
                                                    </div>  
                                                    <div class="form-group col-sm-4  col-md-4"> 
                                                        <label class="control-label" for="selectPO">Select PO : </label>
                                                        <select class="form-control" id="selectPO" name='selectPO'>
                                                            <option value="">Select PO</option>
                                                            @foreach($po as $value)
                                                            <option value="{{$value->id}}">{{$value->id}}</option>
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
                                                        {!! Form::text('comp_name',Input::old('comp_name',isset($cust->comp_name) ? $cust->comp_name : '') ,array('class'=>'form-control', 'placeholder' => 'Company Name')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="buildingNumber" class="col-sm-4 control-label">Building Number:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('building_no',Input::old('building_no',isset($cust->building_no) ? $cust->building_no : '') ,array('class'=>'form-control', 'placeholder' => 'Building Number')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="streetAddress" class="col-sm-4 control-label">Street Address:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('street_addrs',Input::old('street_addrs',isset($cust->street_addrs) ? $cust->street_addrs : '') ,array('class'=>'form-control', 'placeholder' => 'Street Address')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="interiorNumber" class="col-sm-4 control-label">Interior Number:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('interior_no',Input::old('interior_no',isset($cust->interior_no) ? $cust->interior_no : '') ,array('class'=>'form-control', 'placeholder' => 'Interior Number')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="city" class="col-sm-4 control-label">City:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('city',Input::old('city',isset($cust->city) ? $cust->city : '') ,array('class'=>'form-control', 'placeholder' => 'City')) !!}
                                                    </div>                                                               
                                                </div>
                                                <div class="form-group">
                                                    <label for="state" class="col-sm-4 control-label">State:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('state',Input::old('state',isset($cust->state) ? $cust->state : '') ,array('class'=>'form-control', 'placeholder' => 'State')) !!} 
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="zipCode" class="col-sm-4 control-label">ZipCode:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('zipcode',Input::old('zipcode',isset($cust->zipcode) ? $cust->zipcode : '') ,array('class'=>'form-control', 'placeholder' => 'ZipCode')) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="country" class="col-sm-4 control-label">Country:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::select('country',['USA'=>'USA','Germany'=>'Germany'],'', array('class' => 'form-control'))!!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phoneNumber" class="col-sm-4 control-label">Phone Number:</label>
                                                    <div class="col-sm-8">
                                                        {!! Form::text('phone_no',Input::old('phone_no',isset($cust->phone_no) ? $cust->phone_no : '') ,array('class'=>'form-control', 'placeholder' => 'Phone Number')) !!}
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
                                                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>SKU</th>
                                                                <th>Description</th>
                                                                <th>Qty</th>
                                                                <th>Unit Price</th>
                                                                <th>DIscount %</th>
                                                                <th>Amount</th>
                                                                <th>Action</th>
                                                            </tr> 
                                                        </thead>
                                                        <tbody>
                                                            <tr class="gradeX">
                                                                <td></td>
                                                                <td><select class="form-control" id="selectSKU" name='selectSKU'></select></td>
                                                                <td><input type="text" class="form-control" id="searchDescription"></td>
                                                                <td><input type="text" class="form-control" id="searchQty" size="3"></td>
                                                                <td><input type="text" class="form-control" id="searchUnitPrice" size="3"></td>
                                                                <td><input type="text" class="form-control" id="searchDiscout" size="3"></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr class="gradeX">
                                                                <td>1</td>
                                                                <td>BF0013</td>
                                                                <td>Barcelona FC sport Jersey</td>
                                                                <td>50</td>
                                                                <td>13</td>
                                                                <td>0%</td>
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
                                                    </table>
                                                </div>                               

                                                <div class="form-group col-sm-12">
                                                    <label for="shippingMethod" class="control-label col-sm-2" >Shipping Method:</label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control" id="shippingMethod" name="shippingMethod">
                                                            <option>Air</option>
                                                            <option>Express</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <label for="shippingMethod" class="control-label">Payment Term:</label>
                                                        <label id="paymentTerm" for="paymentTerm" class="control-label"></label>&nbsp;&nbsp;&nbsp;
                                                        <label for="shippingMethod" class="control-label">Due Date:</label>
                                                        <label for="shippingMethod" class="control-label">18/01/2015 + PO date</label>
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
<!-- Modal End -->
@endsection