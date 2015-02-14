@extends('layouts.main')

@section('content')
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
                            <form class="form-horizontal">                               
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
                                                        <input id="paymentDate" type="text" value="" size="10" class="form-control default-date-picker" placeholder="20/01/2015">
                                                    </div>
                                                    <div class="form-group col-sm-4 col-md-4">
                                                        <label for="searchCustomer">Customer : </label>
                                                        <input type="text" class="form-control" size="15" id="searchCustomer" placeholder="Customer ID, Name,">
                                                    </div>                                                    
                                                    <div class="form-group col-sm-4 col-md-4">
                                                        <label for="invoiceSelect">Invoice# : </label>
                                                        <select class="form-control" id="invoiceSelect">
                                                            <option>ID, Amount</option>
                                                        </select>
                                                    </div>                                                  
                                                </div>
                                                <br><br><br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-inline">
                                                            <div class="form-group col-sm-3 col-md-3">
                                                                <label for="txtAmount">Amount : </label>
                                                                <input id="txtAmount" type="text" value="" size="10" class="form-control" placeholder="$$$$">
                                                            </div>
                                                            <div class="form-group col-sm-9 col-md-9">
                                                                <label for="paymentRefNo">Payment Reference Number: : </label>
                                                                <input id="paymentRefNo" type="text" class="form-control" placeholder="Reference #">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group" align="center">                                                   
                                                    <button class="btn btn-primary" id="btnApply" style="margin-top: 10px;"><i class="fa fa-thumbs-o-up"></i>
                                                        Apply
                                                    </button>
                                                </div>                                                     
                                            </div>
                                        </div>                                   
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> Invoice List</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                                                        <thead>
                                                            <tr>
                                                            <th>Invoice ID</th>
                                                            <th>Invoice Value</th>
                                                            <th>Paid</th>
                                                            <th>Balance</th>                                                                
                                                        </tr> 
                                                        </thead>
                                                        <tbody>
                                                        <tr class="gradeX">
                                                            <td>FA342</td>
                                                            <td>$1216.00</td>
                                                            <td>$250</td>
                                                            <td>$966</td>                                                               
                                                        </tr>
                                                        </tbody>
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
                                                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                                                        <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Amount</th>
                                                            <th>Reference</th>
                                                            <th>Comments</th>                                                           
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr class="gradeX">
                                                            <td>7/19/2015</td>
                                                            <td>$100</td>
                                                            <td>93485U</td>
                                                            <td>PAGAME PUTO</td>                                                            
                                                        </tr> 
                                                        <tr class="gradeX">
                                                            <td>8/8/2015</td>
                                                            <td>$150</td>
                                                            <td>93U39487</td>
                                                            <td>LAKSDJF</td>                                                            
                                                        </tr> 
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
@endsection