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
                                                <h3 class="panel-title"><i class="fa fa-table"></i> Order Details</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-inline">
                                                    <div class="form-group col-sm-6 col-md-4">
                                                        <label for="orderpoId">PO # : </label>
                                                        <input type="text" class="form-control" id="orderpoId" placeholder="IDcliente +(-)+ 0015">
                                                    </div>
                                                    <div class="form-group col-sm-6 col-md-4">
                                                        <label for="orderDate">Date : </label>
                                                        <input id="orderDate" type="text" value="" size="16" class="form-control default-date-picker">
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
                                                    <label for="State" class="col-sm-4 control-label">State:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="State" placeholder="State">
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
                                                <h3 class="panel-title"><i class="fa fa-truck"></i> Shipping Details</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="shippingMethod" class="col-sm-4 control-label">Shipping Method:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="shippingMethod">
                                                            <option>Air, Express</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="paymentTerms" class="col-sm-4 control-label">Payment Terms:</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="paymentTerms">
                                                            <option>30Days, 15Days, Payment Before Shipment</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="requiredDate" class="col-sm-4 control-label">Required Date:</label>
                                                    <div class="col-sm-8">
                                                        <input id="requiredDate" type="text" value="" size="16" class="form-control default-date-picker">
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
                                                        <input id="uploadArtPDF" type="file">                                                                                                                                               
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="uploadArtPDF" class="col-sm-4 control-label">Upload Art Ai:</label>
                                                    <div class="col-md-8">
                                                        <input id="uploadArtPDF" type="file">                                                                                                                                               
                                                    </div>
                                                </div>                                                                                                                                
                                                <a class="btn btn-link" href="#" role="button"><strong>Blog Art</strong></a>                                          
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
                                                            <th>Amount</th>
                                                            <th>Action</th>
                                                        </tr> 
                                                        <tr>
                                                            <td></td>
                                                            <td><input type="text" class="form-control" id="searchSKU" placeholder="SKU"></td>
                                                            <td><input type="text" class="form-control" id="searchDescription"></td>
                                                            <td><input type="text" class="form-control" id="searchQty" size="3"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><a href="#" class="btn btn-primary"><span class="fa fa-plus"></span> Add</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>BF0013</td>
                                                            <td>Barcelona FC sport Jersey</td>
                                                            <td>50</td>
                                                            <td>13</td>
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
                                                                <td align="right">Total Amount:</td> 
                                                                <td><input type="text" class="form-control" id="totalAmount" placeholder="$5000" size="5"></td>
                                                                <td></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>

                                                </div>                                       
                                                <div class="form-group">
                                                    <label for="comment" class="col-sm-2 col-md-1 control-label">Comment:</label>
                                                    <div class="col-sm-10 col-md-11">                                                            
                                                        <textarea class="form-control" rows="3" placeholder="Company Name" id="comment">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group" align="center">
                                                    <input type="submit" value="Submit" id="btnSubmit" class="btn btn-primary" style="margin-top: 10px;">
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