@extends('layouts.main')

@section('content')
<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#List">List</a></li>
                        <li><a href="{{ action('CustomerController@addCust') }}">Add</a></li>                       
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
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> Customer List</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Company Name</th>
                                                            <th>Building Number</th>
                                                            <th>Street Address</th>
                                                            <th>Interior Number</th>
                                                            <th>City</th>
                                                            <th>State</th>
                                                            <th>ZipCode</th>
                                                            <th>Country</th>
                                                            <th>Phone Number</th>
                                                            <th>Actions</th>
                                                        </tr> 
                                                        </thead>
                                                        <tbody>
                                                        <tr class="gradeX">
                                                            <td>032</td>
                                                            <td>Craft SA de CV</td>
                                                            <td>124</td>
                                                            <td>Always alive</td>
                                                            <td>32</td>
                                                            <td>Los Angeles</td>
                                                            <td>California</td>
                                                            <td>90049</td>
                                                            <td>USA</td>
                                                            <td>7895446332</td>
                                                            <td><a href="{{action('CustomerController@addCust')}}" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                                                        </tr>                                                       
                                                            <tr class="gradeX">
                                                                <td>041</td>
                                                                <td>Sports LLC</td>
                                                                <td>58</td>
                                                                <td>Centre Ville</td>
                                                                <td>2</td>
                                                                <td>Austin</td>
                                                                <td>Texas</td>
                                                                <td>78701</td>
                                                                <td>USA</td>
                                                                <td>54136985255</td>
                                                                <td><a href="{{action('CustomerController@addCust')}}" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>                                                                         
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
<!--body wrapper end-->
@endsection