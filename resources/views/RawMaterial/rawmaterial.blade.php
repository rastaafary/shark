
@extends('layouts.main')
@section('content')
{!! HTML::script('js/rawMaterial.js') !!}

<a href="{{ action('RawMaterialController@listRawMaterial')}}">List</a> 
<a href="{{ action('RawMaterialController@addRawMaterial')}}">Add</a> 
<a href="{{ action('PartController@editPart')}}">Edit</a> 
<br/>


<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#" >List</a></li>
                        <li><a href="/RawMaterial/add">Add</a></li>
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
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> Part Number</h3>
                                            </div>
                                            <div class="panel-body">

                                                <div class="table-responsive">
                                                    <table  class="display table table-bordered table-striped" id="list-part">
                                                        <thead>
                                                            <tr>
                                                                <th>Part No</th>
                                                                <th>Description</th>
                                                                <th>Purchasing Cost</th>
                                                                <th>Unit</th>
                                                                <th>Equivalency</th>
                                                                <th>Stock Unit</th>
                                                                <th>bomcost</th> 
                                                                                                                               <th>Action</th>
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