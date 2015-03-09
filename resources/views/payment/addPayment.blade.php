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
                        <li class="active"><a href="#Add">Add</a></li>
                        <li><a href="/payment/view">View</a></li> 
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">                        
                        <div class="tab-pane active" id="Add">
                            <form class="form-horizontal" method="post" name="paymentForm"> 
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-table"></i> Payment Details</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-inline">
                                                    <div class="form-group col-sm-3 col-md-3">
                                                        <label for="paymentDate">Date : </label>
                                                        <input id="paymentDate" name="paymentDate" type="text" value="" size="10" class="form-control default-date-picker" placeholder="Date">
                                                    </div>
                                                    <div class="form-group col-sm-4 col-md-4">
                                                        <label for="searchCustomer" >Customer : </label>
                                                        <input type="text" class="form-control typeahead" size="15" id="searchCustomer" name="searchCustomer" placeholder="Customer ID, Name">
                                                        <input type="hidden" name="selectedCust" value=""/>
                                                    </div>                                                    
                                                    <div class="form-group col-sm-4 col-md-4">
                                                        <label for="invoiceSelect">Invoice# : </label>
                                                        <select class="form-control" id="invoiceSelect" name="invoiceSelect">
                                                            <option value="0" selected disabled>Select Invoice</option>
                                                        </select>
                                                    </div>                                                  
                                                </div>
                                                <br><br><br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-inline">
                                                            <div class="form-group col-sm-3 col-md-3">
                                                                <label for="txtAmount" class="control-label">Amount : </label>
                                                                <input id="txtAmount" name="txtAmount" type="text" value="" size="10" class="form-control" placeholder="$$$$">
                                                            </div>
                                                            <div class="form-group col-sm-9 col-md-9">
                                                                <label for="paymentRefNo">Payment Reference Number: </label>
                                                                <input id="paymentRefNo" name="paymentRefNo" type="text" class="form-control" placeholder="Reference #">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group" align="center">                                                   
                                                    <button class="btn btn-primary" id="btnApply" style="margin-top: 10px;"><i class="fa fa-thumbs-o-up"></i> Apply</button>
                                                </div>                                                     
                                            </div>
                                        </div>                                   
                                    </div> 
                                </div>
                                <div class="row" id="invoiceListBlock" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> Invoice List</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="display table table-bordered table-striped">
                                                        <tr>
                                                            <th>Invoice ID</th>
                                                            <th>Invoice Value</th>
                                                            <th>Paid</th>
                                                            <th>Balance</th>                                                                
                                                        </tr> 
                                                        <tbody id="invoiceListDT"></tbody>
                                                    </table>
                                                </div>      
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="invoiceDetailBlock" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> Invoice Details</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table  class="display table table-bordered table-striped">
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Amount</th>
                                                            <th>Reference</th>
                                                            <th>Comments</th>                                                           
                                                        </tr>
                                                        <tbody id="invoiceDetailDT"></tbody>
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
@endsection