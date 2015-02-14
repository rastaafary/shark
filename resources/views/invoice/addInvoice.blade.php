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
                            <form class="form-horizontal">
                                <div class="media usr-info">
                                    <div class="pull-left">                                        
                                        {!! HTML::image('images/user-avatar.png', 'a picture', array('class' => 'thumb')) !!}
                                    </div>                                    
                                    <div class="media-body">
                                        <h3 class="media-heading">John Doe</h3>                                      
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
                                                    <div class="form-group col-sm-5 col-md-5">
                                                        <label for="invoiceId">Invoice ID# : </label>
                                                        <input type="text" class="form-control" id="invoiceId" placeholder="IN0025">
                                                    </div>
                                                    <div class="form-group col-sm-5 col-md-5">
                                                        <label class="control-label" for="invoiceDateTime">Date/Time : </label>
                                                        <label class="control-label" id="invoiceDateTime"> 18/01/2015 1035:00AM</label>
                                                    </div>  
                                                    <div class="form-group col-sm-2 col-md-2">                                                                
                                                        <select class="form-control" id="selectPO">
                                                            <option>Select PO</option>
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
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="companyName" class="col-sm-4 control-label">Company Name:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="companyName" placeholder="Company Name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="buildingNumber" class="col-sm-4 control-label">Building Number:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="buildingNumber" placeholder="Building Number">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="streetAddress" class="col-sm-4 control-label">Street Address:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="streetAddress" placeholder="Street Address">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="interiorNumber" class="col-sm-4 control-label">Interior Number:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="interiorNumber" placeholder="Interior Number">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="city" class="col-sm-4 control-label">City:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="city" placeholder="City">
                                                    </div>                                                               
                                                </div>
                                                <div class="form-group">
                                                    <label for="state" class="col-sm-4 control-label">State:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="state" placeholder="State">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="zipCode" class="col-sm-4 control-label">ZipCode:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="zipCode" placeholder="ZipCode">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="country" class="col-sm-4 control-label">Country:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="country" placeholder="Country">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phoneNumber" class="col-sm-4 control-label">Phone Number:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="phoneNumber" placeholder="Phone Number">
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
                                                    <div class="col-sm-6">
                                                        <select class="form-control col-sm-6" id="shippingInfo">
                                                            <option>Select Shipping Information</option>
                                                        </select>
                                                        <label for="shippingInfo" class="control-label">Or Add New Shipping Information :</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="companyName" class="col-sm-4 control-label">Company Name:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="companyName" placeholder="Company Name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="buildingNumber" class="col-sm-4 control-label">Building Number:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="buildingNumber" placeholder="Building Number">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="streetAddress" class="col-sm-4 control-label">Street Address:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="streetAddress" placeholder="Street Address">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="interiorNumber" class="col-sm-4 control-label">Interior Number:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="interiorNumber" placeholder="Interior Number">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="city" class="col-sm-4 control-label">City:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="city" placeholder="City">
                                                    </div>                                                               
                                                </div>
                                                <div class="form-group">
                                                    <label for="state" class="col-sm-4 control-label">State:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="state" placeholder="State">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="zipCode" class="col-sm-4 control-label">ZipCode:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="zipCode" placeholder="ZipCode">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="country" class="col-sm-4 control-label">Country:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="country" placeholder="Country">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phoneNumber" class="col-sm-4 control-label">Phone Number:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="phoneNumber" placeholder="Phone Number">
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
                                                    <table class="table">
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
                                                        <tr>
                                                            <td></td>
                                                            <td><input type="text" class="form-control" id="searchSKU" placeholder="SKU" size="4"></td>
                                                            <td><input type="text" class="form-control" id="searchDescription"></td>
                                                            <td><input type="text" class="form-control" id="searchQty" size="3"></td>
                                                            <td><input type="text" class="form-control" id="searchUnitPrice" size="3"></td>
                                                            <td><input type="text" class="form-control" id="searchDiscout" size="3"></td>
                                                            <td></td>
                                                            <td><a href="#" class="btn btn-primary"><span class="fa fa-plus"></span> Add</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>BF0013</td>
                                                            <td>Barcelona FC sport Jersey</td>
                                                            <td>50</td>
                                                            <td>13</td>
                                                            <td>0%</td>
                                                            <td>$5000</td>
                                                            <td><a href="#" class="btn btn-danger"><span class="fa fa-trash-o"></span> </a> 
                                                                <a href="#" class="btn btn-primary"><span class="fa fa-pencil"></span></a></td>
                                                        </tr>
                                                        <tfoot>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td align="right">Total Qty :</td>                                                               
                                                                <td><input type="text" class="form-control" id="totalQty" placeholder="50" size="3"></td>
                                                                <td></td>
                                                                <td align="right">Total Amount:</td> 
                                                                <td><input type="text" class="form-control" id="totalAmount" placeholder="$5000" size="5"></td>
                                                                <td></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>

                                                </div>                                

                                                <div class="form-group col-sm-4">
                                                    <label for="shippingMethod" class="col-sm-6 control-label">Shipping Method:</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control col-sm-4" id="shippingMethod">
                                                            <option>Air, Express</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <label for="shippingMethod" class="control-label">Payment Term:</label>
                                                    <label for="shippingMethod" class="control-label">Information From PO</label>&nbsp;&nbsp;&nbsp;
                                                    <label for="shippingMethod" class="control-label">Due Date:</label>
                                                    <label for="shippingMethod" class="control-label">18/01/2015 + PO date</label>
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
@endsection