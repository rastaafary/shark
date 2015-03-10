@extends('layouts.main')
@section('content')
{!! HTML::script('js/payment.js') !!}
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li><a href="/payment">List</a></li>
                        <li><a href="/payment/add">Add</a></li> 
                        <li class="active"><a href="#View">View</a></li>                         
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">                        
                        <div class="tab-pane active" id="View">
                            <form class="form-horizontal" method="post" name="quickPaymentForm">                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> Invoice List</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                                                        <tr>
                                                            <th>Invoice ID</th>
                                                            <th>Invoice Value</th>
                                                            <th>Paid</th>
                                                            <th>Balance</th>                                                                
                                                        </tr>
                                                        @foreach($invoiceDetails as $invoice)
                                                        <tr>
                                                            <td><input type="hidden" name="p_invoiceSelect" value="{{$invoice->id}}"/>{{$invoice->invoice_no}}</td>
                                                            <td>${{$invoice->total}}</td>
                                                            <td>${{$totalPaid}}</td>
                                                            <td>${{$invoice->total-$totalPaid}}</td>
                                                        </tr>
                                                        @endforeach 
                                                    </table>
                                                </div>      
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> Invoice Details</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="display table table-bordered table-striped">
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Amount</th>
                                                            <th>Reference</th>
                                                            <th>Comments</th>
                                                            <th>Actions</th>
                                                        </tr> 
                                                        <tr class="gradeX">                                                           
                                                            <td><input type="text" class="form-control default-date-picker" id="p_date" name="p_date" placeholder="Date" size="5"></td>
                                                            <td><input type="text" class="form-control" id="p_paid" name="p_paid" placeholder="$$$" size="3"></td>
                                                            <td><input type="text" class="form-control" id="p_refno" name="p_refno" placeholder="Reference" size="5"></td>
                                                            <td><textarea class="form-control" id="p_comment" name="p_comment"></textarea></td> 
                                                            <td>
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input type="hidden" id="p_id" name="p_id" value="0"/>
                                                                <input type="hidden" id="p_old_paid" name="p_old_paid" value=""/>
                                                                <button type="submit" class="btn btn-primary" id="addMorePayment"><span class="fa fa-plus"></span> Add</button>
                                                                <button style="display: none;" type="button" class="btn btn-warning" id="cancelUpdate"><i class="fa fa-reply"></i></button>
                                                            </td>
                                                        </tr>
                                                        @foreach($paymentDetails as $payment)
                                                        <tr class="oldPayment">
                                                            <td class="p_date">{{$payment->date}}</td>
                                                            <td>$<span class="p_paid">{{$payment->paid}}</span></td>
                                                            <td class="p_refno">{{$payment->payment_ref_no}}</td>
                                                            <td class="p_comment">{{$payment->comments}}</td>
                                                            <td>
                                                                <input type="hidden" class="p_id" value="{{$payment->id}}" />
                                                                <a href="/payment/delete/{{$payment->id}}" class="btn btn-danger deletePayment"><span class="fa fa-trash-o"></span> </a> 
                                                                <button type="button" class="btn btn-primary" onclick="editPayment(this)"><span class="fa fa-pencil"></span></button>
                                                            </td>  
                                                        </tr>
                                                        @endforeach 
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
<div class="modal fade" id="editInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Invoice</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <div class="form-group">
                            <label for="editDate" class="col-sm-4 control-label">Date :</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="editDate" placeholder="7/19/2015">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editAmount" class="col-sm-4 control-label">Amount :</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="editAmount" placeholder="100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editReference" class="col-sm-4 control-label">Reference :</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="editReference" placeholder="93485U">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="editComments" class="col-sm-4 control-label">Comments :</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="editComments" placeholder="PAGAME PUTO">
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