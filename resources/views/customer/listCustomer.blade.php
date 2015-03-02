@extends('layouts.main')
@section('content')
{!! HTML::script('js/customer.js') !!}
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
                                                    <table  class="display table table-bordered table-striped" id="customer-list">
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
                                                        </tbody>
                                                        <?php /* @foreach ($customerlist as $value)
                                                          <tr class="gradeX">
                                                          <td>{{ $value->id }}</td>
                                                          <td>{{ $value->comp_name }}</td>
                                                          <td>{{ $value->building_no }}</td>
                                                          <td>{{ $value->street_addrs }}</td>
                                                          <td>{{ $value->interior_no}}</td>
                                                          <td>{{ $value->city }}</td>
                                                          <td>{{ $value->state }}</td>
                                                          <td>{{ $value->zipcode }}</td>
                                                          <td>{{ $value->country }}</td>
                                                          <td>{{ $value->phone_no }}</td>
                                                          <td>@if (isset($value->id))
                                                          <a href="{{ action('CustomerController@deleteCust')}}/{{$value->user_id}}" class="btn btn-danger"><span class="fa fa-trash-o"></span> </a>
                                                          <a href="{{ action('CustomerController@editCust')}}/{{$value->user_id}}" class="btn btn-primary"><span class="fa fa-pencil"></span></a>
                                                          @endif
                                                          </td>
                                                          </tr>
                                                          @endforeach */ ?>

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