@extends('layouts.main')
@section('content')
{!! HTML::script('js/part.js') !!}


<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#" >List</a></li>
                        <li><a href="{!!url('/part/add')!!}">Add</a></li>
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
                                                    <table  class="display table table-bordered table-striped" id="list-parts">
                                                        <thead>
                                                            <tr>
                                                                <th>SKU</th>
                                                                <th>Description</th>
                                                                <th>Cost</th>
                                                                <th>BOM Total</th>
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
<!--body wrapper end-->

@endsection

<?php /*

  <a href="{{ action('PartController@partList')}}">List</a>
  <a href="{{ action('PartController@addPart')}}">Add</a>
  <a href="{{ action('PartController@editPart')}}">Edit</a>
  <br/>
  @foreach ($partlist as $value)
  {{ $value->SKU }}
  {{ $value->description }}
  {{ $value->cost }}
  {{ $value->currency }}
  @if (isset($value->id))
  <a id="edit" href="{{ action('PartController@editPart')}}/{{$value->id}}">edit</a>
  @endif
  <br/>
  @endforeach

 */ ?>
