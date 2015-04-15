@extends('layouts.main')
@section('content')
{!! HTML::script('js/BOM.js') !!}

<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#List">List</a></li>
                        <li><a href="/part/{{$part_id}}/bom/add">Add</a></li>
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
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> BOM List</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="display table table-bordered table-striped" id="BOM_list">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 5%;">Part Number</th>
                                                                <th style="width: 5%;">Discription</th>
                                                                <th style="width: 5%;">Cost</th>
                                                                <th style="width: 5%;">Unit</th>
                                                                <th style="width: 5%;">Yield</th>
                                                                <th style="width: 5%;">Total</th>
                                                                <th style="width: 5%;">Action</th>
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