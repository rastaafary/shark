@extends('layouts.main')
@section('content')

<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#" >List</a></li>
                        <li><a href="/part/add">Add</a></li>
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
                                                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                                                        <thead>
                                                            <th>SKU</th>
                                                            <th>Description</th>
                                                            <th>Cost</th>
                                                            <th>Currency</th>
                                                            <th>Action</th>
                                                        </tr> 
                                                        </thead>
                                                        <tbody>
                                                        <tr class="gradeX">
                                                            <td>BF0013</td>
                                                            <td>Barcelona FC sport Jersey</td>
                                                            <td>13</td>
                                                            <td>USA</td>
                                                            <td><a href="{{action('PartController@addPart')}}" class="btn btn-primary"><span class="fa fa-pencil"></span></a></td>
                                                        </tr>
                                                        <tr class="gradeX">
                                                            <td>MA0011</td>
                                                            <td>Barcelona FC sport Jersey</td>
                                                            <td>17</td>
                                                            <td>USA</td>
                                                            <td><a href="{{action('PartController@addPart')}}" class="btn btn-primary"><span class="fa fa-pencil"></span></a></td>
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
