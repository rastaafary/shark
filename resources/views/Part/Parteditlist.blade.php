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
                                    <div class="col-sm-offset-8 col-sm-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search By:">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" >Select <span class="caret"></span></button>
                                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                    <li><a href="#">Link 1</a></li>
                                                    <li><a href="#">Link 2</a></li>
                                                    <li><a href="#">Link 3</a></li>
                                                    <li><a href="#">Link 4</a></li>
                                                </ul>
                                            </div>
                                        </div><br />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> Part Number</h3>
                                            </div>
                                            <div class="panel-body">

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tr>
                                                            <th>SKU</th>
                                                            <th>Description</th>
                                                            <th>Cost</th>
                                                            <th>Currency</th>
                                                            <th>Action</th>
                                                        </tr> 
                                                        <tr>
                                                            <td>BF0013</td>
                                                            <td>Barcelona FC sport Jersey</td>
                                                            <td>13</td>
                                                            <td>USA</td>
                                                            <td><a href="#" class="btn btn-primary"><span class="fa fa-pencil"></span></a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>MA0011</td>
                                                            <td>Barcelona FC sport Jersey</td>
                                                            <td>17</td>
                                                            <td>USA</td>
                                                            <td><a href="#" class="btn btn-primary"><span class="fa fa-pencil"></span></a></td>
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
