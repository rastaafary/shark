
@extends('layouts.main')
@section('content')
{!! HTML::script('js/payment.js') !!}
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#List">List</a></li>
                        <li><a href="/payment/add">Add</a></li> 
                       <li><a href="/payment/view">View</a></li> 
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
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> Payment List</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                                                        <thead>
                                                        <tr>
                                                            <th>Payment ID</th>
                                                            <th>Invoice ID</th>
                                                            <th>Customer</th>
                                                            <th>Amount</th>
                                                            <th>Details</th>                                                           
                                                        </tr> 
                                                        </thead>
                                                        <tbody>
                                                        <tr class="gradeX">
                                                            <td>P0015</td>
                                                            <td>FA342</td>
                                                            <td>Sports LLC</td>
                                                            <td>$1256.00</td>                                                            
                                                            <td><a href="{{action('PaymentController@viewPayment')}}" class="fa fa-bars btn btn-primary"> Details </a></td>                                                                   
                                                        </tr>
                                                        <tr class="gradeX">
                                                            <td>P0015</td>
                                                            <td>FA342</td>
                                                            <td>Sports LLC</td>
                                                            <td>$1256.00</td>                                                            
                                                            <td><a href="{{action('PaymentController@viewPayment')}}" class="fa fa-bars btn btn-primary"> Details </a></td>                                                                   
                                                        </tr> 
                                                        </tbody>                                                        
                                                    </table>
                                                </div>                                                        
                                            </div>                                                    
                                        </div>  
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-offset-10 col-sm-2">
                                        <a href="#" class="btn btn-primary"> View PO </a>
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
