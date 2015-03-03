@extends('layouts.main')
@section('content')
{!! HTML::script('js/invoice.js') !!}
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#List">List</a></li>
                        <li><a href="/invoice/add">Add</a></li>                      
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
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> Invoice List</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table  class="display table table-bordered table-striped" id="invoiceList">
                                                        <thead>
                                                            <tr>
                                                                <th>Invoice ID</th>
                                                                <th>Invoice Value</th>
                                                                <th>Paid</th>
                                                                <th>Balance</th>
                                                                <th>Aging</th>
                                                                <th>View Details</th>
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
@endsection
