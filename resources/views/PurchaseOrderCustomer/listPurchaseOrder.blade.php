@extends('layouts.main')

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#List">List</a></li>
                        <li><a href="{{action('PurchaseOrderCustomerController@addPurchaseOrder')}}" >Add</a></li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">                        
                        <div class="tab-pane active" id="List">
                            <form class="form-horizontal">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">                                                            
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> Purchase Order List</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="display table table-bordered table-striped" id="POCustomer-list">
                                                        <thead>
                                                            <tr>
                                                                <th>Sequence</th>
                                                                <th>PO Number</th>
                                                                <th>Part Number</th>
                                                                <th>Required Date</th>
                                                                <th>Estimated Shipping Date</th>
                                                                <th>PO Qty</th>
                                                                <th>Pcs Made</th>
                                                                <th>Balance</th>
                                                                <th>Action</th>
                                                            </tr>                                                                       
                                                        </thead>
                                                        <tbody>                                                       
                                                        </tbody>
                                                    </table>                                                                   
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
<div class="modal fade" id="editPurchaseOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Purchase Order</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <div class="form-group">
                            <label for="editSequence" class="col-sm-4 control-label">Sequence :</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="editSequence" placeholder="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editPONumber" class="col-sm-4 control-label">PO Number :</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="editPONumber" placeholder="032-0024">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editPartNumber" class="col-sm-4 control-label">Part Number :</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="editPartNumber" placeholder="BF0012">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editRequiredDate" class="col-sm-4 control-label">Required Date :</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="editRequiredDate" placeholder="15/05/2015">
                            </div>
                        </div>                                                    
                        <div class="form-group">
                            <label for="editEstimatedShippingDate" class="col-sm-4 control-label">Estimated Shipping Date:</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="editEstimatedShippingDate" placeholder="10/05/2015">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editPOQty" class="col-sm-4 control-label">PO Qty :</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="editPOQty" placeholder="50">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editPcsMade" class="col-sm-4 control-label">Pcs Made :</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="editPcsMade" placeholder="0">
                            </div>
                        </div>                                                    
                        <div class="form-group">
                            <label for="editBalance" class="col-sm-4 control-label">Balance :</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="editBalance" placeholder="50">
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal End -->

@endsection