@extends('layouts.main')
@section('content')
{!! HTML::script('js/BOM.js') !!}
{!! HTML::script('js/jquery.maskedinput.min.js') !!}
<?php if ($route_name == 'edit') { ?>
    {!! HTML::script('js/EditBOM.js') !!}
<?php } ?>
<script>
    var part_id = '<?php echo $part_id ?>';
    var route_name = '<?php echo $route_name ?>';
</script>
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li><a href="/part/{{$part_id}}/bom">List</a></li>
                        <li class="active"><a href="#Add"><?php echo isset($bom->id) ? 'Edit' : 'Add'; ?></a></li>                       
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">                        
                        <div class="tab-pane active" id="Add">
                            @if(!isset($id))
                            {!! Form::open(array('class'=>'form-horizontal','url'=>'/part/'.$part_id.'/bom/add','name'=>'BOM','id'=>'BOM')) !!}
                            {!! Form::hidden('id', Input::old('id',isset($bom->id) ? $bom->id : '')) !!}
                            @else                             
                            {!! Form::open(array('class'=>'form-horizontal','url'=>'/part/'.$part_id.'/bom/edit/'.$id,'name'=>'BOM','id'=>'BOM')) !!}
                            {!! Form::hidden('id', Input::old('id',isset($bom->id) ? $bom->id : '')) !!}
                            @endif
                            <div class="row">
                                <div style="color: red">
                                    {!! HTML::ul($errors->all()) !!}
                                </div>
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
                                                        <select id="part_id" name="part_id" class='form-control skuDropDown'>
                                                            @if(count($part_data) > 0)
                                                            <option value='selected=selected'> Select SKU </option>
                                                            @foreach($part_data as $value)
                                                            @if(isset($bom->part_id))
                                                            @if($value->id == $bom->part_id)
                                                            <option value="{{$value->id}}" selected>{{$value->SKU}}</option>
                                                            @endif
                                                            @else
                                                            <option value="{{$value->id}}">{{$value->SKU}}</option>
                                                            @endif
                                                            @endforeach
                                                            @endif
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
                                                            <input type="text" class="form-control typeahead" name="selectedRawMaterial" id='selectedRawMaterial' placeholder="SHK-FAB-1000">
<!--                                                            <input type="hidden" id="raw_material" name="raw_material"  value=""/>-->
                                                            {!! Form::hidden('raw_material',Input::old('raw_material',isset($bom->raw_material) ? $bom->raw_material : '') ,array('class'=>'form-control', 'id' => 'raw_material')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description" class="col-sm-4 control-label">Description : </label>
                                                        <div class="col-sm-8">
                                                            {!! Form::text('descritpion',Input::old('descritpion',isset($bom->descritpion) ? $bom->descritpion : '') ,array('class'=>'form-control', 'placeholder' => '', 'id' => 'descritpion', 'readonly')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bom_cost" class="col-sm-4 control-label">Bom Cost:</label>
                                                        <div class="col-sm-8">
                                                            {!! Form::text('bom_cost',Input::old('bom_cost',isset($bom->bom_cost) ? $bom->bom_cost : '') ,array('class'=>'form-control two-digits', 'placeholder' => '','id' => 'bom_cost', 'readonly')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="scrap_rate" class="col-sm-4 control-label">ScrapRate (%): </label>
                                                        <div class="col-sm-8">
                                                            {!! Form::text('scrap_rate',Input::old('scrap_rate',isset($bom->scrap_rate) ? $bom->scrap_rate : '') ,array('class'=>'form-control two-digits', 'placeholder' => '', 'id' => 'scrap_rate')) !!}
                                                        </div>                                                               
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="yield" class="col-sm-4 control-label">Yield : </label>
                                                        <div class="col-sm-8">
                                                            {!! Form::text('yield',Input::old('yield',isset($bom->yield) ? $bom->yield : '') ,array('class'=>'form-control two-digits1', 'placeholder' => '', 'id' => 'yield')) !!}
                                                        </div>                                                               
                                                    </div> 
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="total" class="col-sm-4 control-label">Total : </label>
                                                        <div class="col-sm-8">
                                                            {!! Form::text('total',Input::old('total',isset($bom->total) ? $bom->total : '') ,array('class'=>'form-control', 'placeholder' => '', 'id' => 'total', 'readonly')) !!}
                                                        </div>                                                               
                                                    </div> 
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="unit" class="col-sm-4 control-label">Unit : </label>   
                                                        <div class="col-sm-8">
                                                            {!! Form::text('unit',Input::old('unit',isset($bom->unit) ? $bom->unit : '') ,array('class'=>'form-control', 'placeholder' => '', 'id' => 'unit', 'readonly')) !!}
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
