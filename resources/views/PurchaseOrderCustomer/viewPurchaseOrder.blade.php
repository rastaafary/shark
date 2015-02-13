@extends('layouts.main')

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li><a href="/po">List</a></li>
                        <li><a href="/po/add">Add</a></li>
                        <li  class="active"><a href="#View">View</a></li>
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
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> Purchase Order List</h3>
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
                                                        </tr>                                                                       
                                                        <tr>
                                                            <td>1</td>
                                                            <td>032-0024</td>
                                                            <td>BF0012</td>
                                                            <td>15/05/2015</td>
                                                            <td>10/05/2015</td>
                                                            <td>50</td>
                                                            <td>0</td>
                                                            <td>50</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>030-0022</td>
                                                            <td>BF0013</td>
                                                            <td>15/05/2015</td>
                                                            <td>10/05/2015</td>
                                                            <td>50</td>
                                                            <td>25</td>
                                                            <td>25</td>
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