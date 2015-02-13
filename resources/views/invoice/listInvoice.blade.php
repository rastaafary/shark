@extends('layouts.main')

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                     <ul class="nav nav-tabs">
                        <li class="active"><a href="#List">List</a></li>
                        <li><a href="/invoice/add">Add</a></li>
                        <li><a href="/invoice/view">View</a></li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="List">
                            <form class="form-horizontal">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group text-right">
                                            <div class="col-sm-8">                                                  
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="searchInvoice" placeholder="Search by invoice">
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th>Invoice ID</th>
                                                    <th>Invoice Value</th>
                                                    <th>Paid</th>
                                                    <th>Balance</th>
                                                    <th>Aging</th>
                                                    <th>View Details</th>
                                                </tr>                                                                
                                                <tr>
                                                    <td>FA342</td>
                                                    <td>$1216.00</td>
                                                    <td>$250</td>
                                                    <td>$966</td>
                                                    <td>15 days</td> 
                                                    <td><a href="#" class="btn btn-default"> Details </a></td>
                                                </tr>
                                                <tfoot>
                                                    <tr>
                                                        <td>FA343</td>
                                                        <td>$300.00</td>
                                                        <td>$100</td>                                                               
                                                        <td>$200</td>
                                                        <td>20 days Due</td>
                                                        <td><a href="#" class="btn btn-default"> Details </a></td>                                                                         
                                                    </tr>
                                                </tfoot>
                                            </table>
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
