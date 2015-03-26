@extends('layouts.main')
@section('content')
{!! HTML::script('js/OrderStatus.js') !!}


<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="tab-content">
                        <!-- Modal Start -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Add Pcs Made</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table" id="pcsMadeTable">
                                                <tr>
                                                    <th>PO</th>
                                                    <th>Date</th>
                                                    <th>SKU</th>
                                                    <th>Pcs Made</th>
                                                    <th>Balance</th>
                                                    <th>Actions</th>
                                                </tr>
                                                <tbody  id="pcsBody"></tbody>
                                            </table>
                                            <br>
                                            <table class="table" id="addMorePcsMadePopup">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Quantity</th>
                                                    <th>Actions</th>
                                                </tr>                                                                
                                                <tr>
                                                    <td><input type="text" size="7" class="form-control default-date-picker" placeholder="Date" name="pcsMadeDate" id="pcsMadeDate" ></td>
                                                    <td>
                                                        <input type="text" class="form-control" size="3" placeholder="Qty" id="pcsMadeQty" name="pcsMadeQty"> 
                                                        <input type="hidden" name="pcsMadeQty_old" id="pcsMadeQty_old" value="0"/>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="pcsMadeId" id="pcsMadeId" value="0"/>
                                                        <input type="hidden" name="orderlist_id" id="orderlist_id" value="0"/>
                                                        <button type="button" class="btn btn-primary btn-sm" id="addPcsMadeBtn"><i class="fa fa-plus"></i> ADD</button>
                                                        <button id="cancelUpdate" class="btn btn-warning" type="button" style="display: none;"><i class="fa fa-reply"></i></button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div> 
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                   <div class="example" id="demo">
                       <input type="checkbox" name="toggle" data-toggle="toggle" checked data-on="open" data-off="closed" id="openCloseToggle">
                       
				
                    </div>
                        <!-- Modal End -->

                        <form class="form-horizontal" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-bars"></i> Order Status Report List</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table  class="display table table-bordered table-striped" id="order-list">
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
                                                            <!--<th>Mark Pieces Made</th>-->
                                                            <th>Status</th>
                                                        </tr> 
                                                    </thead>
                                                    <tbody><tbody>
                                                </table>
                                            </div> 
                                        </div>
                                    </div>
                                </div> 
                            </div>         
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!--body wrapper end-->
@endsection