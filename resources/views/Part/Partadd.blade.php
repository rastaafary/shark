@extends('layouts.main')
@section('content')
<!--
<a href="{{ action('PartController@partList')}}">List</a> 
<a href="{{ action('PartController@addPart')}}">Add</a> 
<a href="{{ action('PartController@editPart')}}">Edit</a> 
{!! Form::open(array('url'=>'/part/add/', 'id'=>'addpart')) !!}
{!! Form::hidden('id', Input::old('value',isset($part->id) ? $part->id : '')) !!}
{!! Form::label('SKU','SKU',array('id'=>'','class'=>'')) !!}
{!! Form::text('SKU', Input::old('value',isset($part->SKU) ? $part->SKU : '')) !!}<br/>
{!! Form::label('description','description',array('id'=>'','class'=>'')) !!}
{!! Form::text('description', Input::old('value',isset($part->description) ? $part->description : '')) !!}<br/>
{!! Form::label('cost','cost',array('id'=>'','class'=>'')) !!}
{!! Form::text('cost', Input::old('value',isset($part->cost) ? $part->cost : '')) !!}<br/>
{!! Form::label('currency','currency',array('id'=>'','class'=>'')) !!}
{!! Form::select('currency', array('USD' => 'USD', 'MXN' => 'MXN')) !!}<br/>
{!! Form::submit('save') !!}
{!! Form::close() !!}
-->
<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li><a href="/part">List</a></li>
                        <li class="active"><a href="#" data-toggle="tab">Add</a></li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">                                        
                        <div class="tab-pane active" id="Add">
                            <!--<form class="form-horizontal">-->
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        {!! HTML::ul($errors->all()) !!}
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-bars"></i> Part Number</h3>
                                        </div>
                                        <div class="panel-body">
                                            @if(!isset($part->id))
                                            {!! Form::open(array('url'=>'/part/add', 'id'=>'addpart')) !!}
                                            {!! Form::hidden('id', Input::old('value',isset($part->id) ? $part->id : '')) !!}
                                            @else
                                            {!! Form::open(array('url'=>'/part/edit/'.$part->id, 'id'=>'editpart')) !!}
                                            {!! Form::hidden('id', Input::old('value',isset($part->id) ? $part->id : '')) !!}
                                            @endif
                                            <div class="table-responsive">
                                                <table  class="display table">
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
                                                            <td><!--<input type="text" class="form-control" id="SKU" placeholder="SKU">-->
                                                                {!! Form::text('SKU', Input::old('value',isset($part->SKU) ? $part->SKU : ''),array('class'=>'form-control','placeholder'=>'SKU')) !!}<br/></td>
                                                            <td><!--<input type="text" class="form-control" id="Description">-->
                                                                {!! Form::text('description', Input::old('value',isset($part->description) ? $part->description : ''),array('class'=>'form-control','placeholder'=>'Description')) !!}<br/></td>
                                                            <td><!--<input type="text" class="form-control" id="Cost" size="3">-->
                                                                {!! Form::text('cost', Input::old('value',isset($part->cost) ? $part->cost : ''),array('class'=>'form-control','placeholder'=>'Cost')) !!}<br/></td>
                                                            <td><!--<select class="form-control" id="Currncy">       
                                                                    <option>USA</option>
                                                                    <option>MXN</option>
                                                                </select>-->
                                                                {!! Form::select('currency_id',array('1' => 'USD', '2' => 'MXN'), null, array('class' => 'form-control')) !!}
                                                            </td>
                                                            <td><!--<a href="#" class="btn btn-primary"><span class="fa fa-plus"></span> Add</a>-->
                                                                {!! Form::submit('Save',array('class'=>'btn btn-primary')) !!}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--</form>-->

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!--body wrapper end-->
@endsection