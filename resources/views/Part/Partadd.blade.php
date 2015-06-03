@extends('layouts.main')
@section('content')
{!! HTML::script('js/part.js') !!}
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
<script>
    var whichPage = '<?php echo isset($part->id) ? 'Edit' : 'Add'; ?>';
</script>
<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li><a href="{!!url('/part')!!}">List</a></li>
                        <li class="active"><a href="{!!url('#')!!}" data-toggle="tab"><?php echo isset($part->id) ? 'Edit' : 'Add'; ?></a></li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">                                        
                        <div class="tab-pane active" id="Add">
                            @if(!isset($part->id))                            
                            {!! Form::open(array('class'=>'form-horizontal','url'=>'/part/add','name'=>'addpart','id'=>'addpart','files' => true)) !!}
                            {!! Form::hidden('id', Input::old('id',isset($part->id) ? $part->id : '')) !!}
                            @else
                            {!! Form::open(array('url'=>'/part/edit/'.$part->id, 'id'=>'editpart')) !!}
                            {!! Form::hidden('id', Input::old('id',isset($part->id) ? $part->id : '')) !!}
                            @endif

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        {!! HTML::ul($errors->all()) !!}
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-bars"></i> Part Number</h3>
                                        </div>
                                        <div class="panel-body">
                                            
                                             <div class="row">
                                <div style="color: red">
                                    {!! HTML::ul($errors->all()) !!}
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="partnumber" class="col-sm-4 control-label">SKU:</label>
                                        <div class="col-sm-8">
                                            {!! Form::text('SKU', Input::old('SKU',isset($part->SKU) ? $part->SKU : ''),array('class'=>'form-control','placeholder'=>'SKU','minlength'=>'6')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="col-sm-4 control-label">Description:</label>
                                        <div class="col-sm-8">
                                            {!! Form::text('description', Input::old('description',isset($part->description) ? $part->description : ''),array('class'=>'form-control','placeholder'=>'Description')) !!}   

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="purchasingcost" class="col-sm-4 control-label">Size:</label>
                                        <div class="col-sm-8">
                                            <?php if (!isset($part->id)) { ?>
                                                                {!! Form::select('labels[]',$sizelist,isset($size->labels) ? $size->labels:'', array('class' => 'js-example-basic-multiple','style'=>'width: 150px','multiple'=>'multiple','id'=>'sourceValues')) !!}<br/></td> 
                                                        <?php } else {
                                                            ?>
                                                            {!! Form::select('labels[]',$sizelist,$size, array('class' => 'js-example-basic-multiple','style'=>'width: 150px','multiple'=>'multiple','id'=>'sourceValues')) !!}<br/></td>
                                                    <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="unit" class="col-sm-4 control-label">Componenets:</label>
                                        <div class="col-sm-8">
                                            <?php if (!isset($part->id)) { ?>
                                                            {!! Form::select('label[]',$componentslist,isset($part->label) ? $part->label:'', array('class' => 'js-example-basic-multipled','style'=>'width: 150px','multiple'=>'multiple')) !!}<br></td>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        {!! Form::select('label[]',$componentslist,$comp, array('class' => 'js-example-basic-multipled','style'=>'width: 150px','multiple'=>'multiple')) !!}<br></td>
                                                    <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="equivalency" class="col-sm-4 control-label">AiFile:</label>
                                        <div class="col-sm-5">
                                           <!-- <input type="text" class="form-control" id="zipCode" placeholder="ZipCode"> -->
                                            <input id="ai" type="file" name="ai">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bomcost" class="col-sm-4 control-label">Cost:</label>
                                        <div class="col-sm-4">
                                           <!-- <input type="text" class="form-control" id="zipCode" placeholder="ZipCode"> -->
                                            {!! Form::text('cost', Input::old('cost',isset($part->cost) ? $part->cost : ''),array('class'=>'form-control','placeholder'=>'Cost')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="stockunit" class="col-sm-4 control-label">Currency:</label>
                                        <div class="col-sm-4">
                                           <!-- <input type="text" class="form-control" id="zipCode" placeholder="ZipCode"> -->
                                            {!! Form::select('currency_id', ['1' => 'USD', '2' => 'MXN'], isset($part->currency_id) ? $part->currency_id:'1', array('class' => 'form-control')) !!}

                                        </div>
                                    </div>
                                    

                                </div>

                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        {!! Form::submit('Save',array('class'=>'btn btn-lg btn-primary')) !!}
                                    </div>
                                </div>
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