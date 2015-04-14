@extends('layouts.main')
@section('content')
{!! HTML::script('js/BOM.js') !!}

<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li><a href="/po">List</a></li>
                        <li class="active"><a href="#Add">Add</a></li>                       
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">                        
                        <div class="tab-pane active" id="Add">
                            @if(!isset($id))
                            {!! Form::open(array('class'=>'form-horizontal','url'=>'/part/bom/add','name'=>'BOM','id'=>'BOM')) !!}
                            {!! Form::hidden('id',Input::old('id',isset(Auth::user()->id) ? Auth::user()->id : '')) !!}
                            @else                             
                            {!! Form::open(array('class'=>'form-horizontal','url'=>'/part/bom/edit/'.$id,'name'=>'BOM','id'=>'BOM')) !!}
                            {!! Form::hidden('id',Input::old('id',isset(Auth::user()->id) ? Auth::user()->id : '')) !!}
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-table"></i> Details</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-inline">
                                                <div class="form-group col-sm-6">
                                                    <label for="part_id" class="col-sm-4 control-label">SKU : </label> 
                                                    <div class="col-sm-8">
                                                        <select id="part_id" name="part_id" class='form-control'>
                                                            <option>ABC</option>
                                                            <option>PQR</option>
                                                            <option>XYZ</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="skuDescripton">SKU Description : </label>
                                                    {!! Form::text('skuDescripton',Input::old('skuDescripton',isset($bom->skuDescripton) ? $bom->skuDescripton : '') ,array('class'=>'form-control','id'=>'skuDescripton','placeholder'=>'SKU Description')) !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="row">   
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="rawMaterial" class="col-sm-4 control-label">RawMaterial: </label>
                                                        <div class="col-sm-8">
                                                            {!! Form::text('raw_material',Input::old('raw_material',isset($BOM->raw_material) ? $BOM->raw_material : '') ,array('class'=>'form-control', 'placeholder' => 'SHK-FAB-1000', 'id' => 'raw_material')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description" class="col-sm-4 control-label">Description : </label>
                                                        <div class="col-sm-8">
                                                            {!! Form::text('descritpion',Input::old('descritpion',isset($bom->descritpion) ? $bom->descritpion : '') ,array('class'=>'form-control', 'placeholder' => 'Rolls de tela', 'id' => 'descritpion')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bom_cost" class="col-sm-4 control-label">Bom Cost:</label>
                                                        <div class="col-sm-8">
                                                            {!! Form::text('bom_cost',Input::old('bom_cost',isset($bom->bom_cost) ? $bom->bom_cost : '') ,array('class'=>'form-control', 'placeholder' => '14.5','id' => 'bom_cost')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="scrap_rate" class="col-sm-4 control-label">ScrapRate (%): </label>
                                                        <div class="col-sm-8">
                                                            {!! Form::text('scrap_rate',Input::old('scrap_rate',isset($bom->scrap_rate) ? $bom->scrap_rate : '') ,array('class'=>'form-control', 'placeholder' => '5%', 'id' => 'scrap_rate')) !!}
                                                        </div>                                                               
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="yield" class="col-sm-4 control-label">Yield : </label>
                                                        <div class="col-sm-8">
                                                            {!! Form::text('yield',Input::old('yield',isset($bom->yield) ? $bom->yield : '') ,array('class'=>'form-control', 'placeholder' => '0.5', 'id' => 'yield')) !!}
                                                        </div>                                                               
                                                    </div> 
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="total" class="col-sm-4 control-label">Total : </label>
                                                        <div class="col-sm-8">
                                                            {!! Form::text('total',Input::old('total',isset($bom->total) ? $bom->total : '') ,array('class'=>'form-control', 'placeholder' => '7.25', 'id' => 'total')) !!}
                                                        </div>                                                               
                                                    </div> 
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="unit" class="col-sm-4 control-label">Unit : </label>   
                                                        <div class="col-sm-8">
                                                            <select id="unit" name="unit" class='form-control'>
                                                                <option>ABC</option>
                                                                <option>PQR</option>
                                                                <option>XYZ</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group" align="center">
                                                        {!! Form::submit('Save',array('class'=>'btn btn-primary', 'id'=>'btnSubmit')) !!}
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>
</div>
</div>

@endsection
