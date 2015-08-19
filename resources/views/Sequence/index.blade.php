@extends('layouts.main')
@section('content')
{!! HTML::script('js/production_sequence.js') !!}

<input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#" >List</a></li>
                        <li><a href="{{url('sequence/add')}}">Add</a></li>
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
                                                <h3 class="panel-title"><i class="fa fa-list-ol"></i> Sequence Number</h3>
                                            </div>
                                            <div class="panel-body">
                                                @if(Session::has('success'))
                                                <div class="alert alert-success">{!! Session::get('success') !!}</div>
                                                @elseif(Session::has('error'))
                                                <div class="alert alert-success">{!! Session::get('error') !!}</div>
                                                @endif
                                                <div class="table-responsive">
                                                    <table  class="display table table-bordered table-striped" id="production-sequence">
                                                        <thead>
                                                            <tr>
                                                                <th>id</th>
                                                                <th>Name</th>
                                                                <th>Action</th>
                                                                <th></th>
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
<!--body wrapper end-->

@endsection