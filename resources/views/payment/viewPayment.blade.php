@extends('layouts.main')

@section('content')
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
                            <form class="form-horizontal">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> Invoice List</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tr>
                                                            <th>Invoice ID</th>
                                                            <th>Invoice Value</th>
                                                            <th>Paid</th>
                                                            <th>Balance</th>                                                                
                                                        </tr>                                                         
                                                        <tr>
                                                            <td>FA342</td>
                                                            <td>$1216.00</td>
                                                            <td>$250</td>
                                                            <td>$966</td>                                                               
                                                        </tr>                                                            
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
                                                    <table class="table">
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Amount</th>
                                                            <th>Reference</th>
                                                            <th>Comments</th>
                                                            <th>Actions</th>
                                                        </tr> 
                                                        <tr>                                                           
                                                            <td><input type="text" class="form-control default-date-picker" id="searchDate" placeholder="22/01/2015" size="5"></td>
                                                            <td><input type="text" class="form-control" id="searchAmount" placeholder="$$$" size="3"></td>
                                                            <td><input type="text" class="form-control" id="searchReference" placeholder="Reference" size="5"></td>
                                                            <td><input type="text" class="form-control" id="searchComment" placeholder="Comments" size="5"></td>                                                        
                                                            <td><a href="#" class="btn btn-primary"><span class="fa fa-plus"></span> Add</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>7/19/2015</td>
                                                            <td>$100</td>
                                                            <td>93485U</td>
                                                            <td>PAGAME PUTO</td>
                                                            <td><a href="#" class="btn btn-danger"><span class="fa fa-trash-o"></span> </a> 
                                                                <a href="#" class="btn btn-primary"><span class="fa fa-pencil"></span></a></td>  
                                                        </tr> 
                                                        <tr>
                                                            <td>8/8/2015</td>
                                                            <td>$150</td>
                                                            <td>93U39487</td>
                                                            <td>LAKSDJF</td>
                                                            <td><a href="#" class="btn btn-danger"><span class="fa fa-trash-o"></span> </a> 
                                                                <a href="#" class="btn btn-primary"><span class="fa fa-pencil"></span></a></td>
                                                        </tr> 
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