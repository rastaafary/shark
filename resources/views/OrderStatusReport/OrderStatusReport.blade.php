@extends('layouts.main')

@section('content')
<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="tab-content">
                        <form class="form-horizontal">
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
                                                <table class="table">
                                                    <tr>
                                                        <th>PO</th>
                                                        <th>SKU</th>
                                                        <th>Pcs Made</th>
                                                        <th>Balance</th>
                                                    </tr>                                                                
                                                    <tr>
                                                        <td>032-0024</td>
                                                        <td>BF0012</td>
                                                        <td>0</td>
                                                        <td>50</td>
                                                    </tr>
                                                </table>
                                                <br>
                                                <table class="table">
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Quantity</th>
                                                        <th>Actions</th>
                                                    </tr>                                                                
                                                    <tr>
                                                        <td><input id="contactBirthdate" type="text" value="" size="16" class="form-control default-date-picker"></td>
                                                        <td><input type="text" class="form-control" placeholder="Qty"> </td>
                                                        <td>
                                                            <table>
                                                                <tr>
                                                                    <td> <button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> ADD</button></td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <button class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></button>
                                                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                                                    </td>
                                                                <tr>
                                                            </table>
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
                            <!-- Modal End -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-bars"></i> Order Status Report List</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th>Sequence</th>
                                                        <th>PO Number</th>
                                                        <th>Part Number</th>
                                                        <th>Required Date</th>
                                                        <th>Estimated Shipping Date</th>
                                                        <th>PO Qty</th>
                                                        <th>Pcs Made</th>
                                                        <th>Balance</th>
                                                        <th>Mark Pieces Made</th>
                                                    </tr>                                                                
                                                    <tr>
                                                        <td>1</td>
                                                        <td>032-0024</td>
                                                        <td>BF0012</td>
                                                        <td>15/05/2015</td>
                                                        <td>10/05/2015</td>
                                                        <td>50</td>
                                                        <td> <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                                                                0
                                                            </button> </td>
                                                        <td>50</td>
                                                        <td>0</td>
                                                    </tr>
                                                    <tfoot>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>030-0022</td>
                                                            <td>BF0013</td>
                                                            <td>15/05/2015</td>
                                                            <td>10/05/2015</td>
                                                            <td>50</td>
                                                            <td> <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                                                                    25
                                                                </button>  </td>
                                                            <td>25</td>
                                                            <td>0</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div> 
                                        </div>
                                    </div>
                                </div> 
                            </div>         
                        </form>
                        </section>
                    </div>
                </div>
        </div>
        <!--body wrapper end-->
        @endsection