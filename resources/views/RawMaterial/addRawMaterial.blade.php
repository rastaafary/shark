@extends('layouts.main')
@section('content')
{!! HTML::script('js/rawMaterial.js') !!}
{!! HTML::script('js/jquery.maskedinput.min.js') !!}

<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li ><a href="{!!url('/RawMaterial')!!}">List</a></li>
                        <li class="active"><a href="{!!url('#')!!}" data-toggle="tab"><?php echo isset($rawmaterial->id) ? 'Edit' : 'Add'; ?></a></li>                       
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="Add">

                            @if(!isset($rawmaterial->id))                            
                            {!! Form::open(array('class'=>'form-horizontal','url'=>'/RawMaterial/add','name'=>'addpart','id'=>'addpart','files' => true)) !!}
                            {!! Form::hidden('id', Input::old('id',isset($rawmaterial->id) ? $rawmaterial->id : '')) !!}
                            @else
                            {!! Form::open(array('url'=>'/RawMaterial/edit/'.$rawmaterial->id, 'id'=>'addpart')) !!}
                            {!! Form::hidden('id', Input::old('id',isset($rawmaterial->id) ? $rawmaterial->id : '')) !!}
                            @endif

                            <div class="row">
                                <div style="color: red">
                                    {!! HTML::ul($errors->all()) !!}
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="partnumber" class="col-sm-4 control-label">Raw Material No:</label>
                                        <div class="col-sm-8">
                                            {!! Form::text('partnumber',Input::old('partnumber',isset($rawmaterial->partnumber) ?  $rawmaterial->partnumber : '') ,array('class'=>'form-control', 'placeholder' => 'Part Number', 'id'=>'product')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="col-sm-4 control-label">Description:</label>
                                        <div class="col-sm-8">
                                            {!! Form::textarea('description', Input::old('description',isset($rawmaterial->description) ?  $rawmaterial->description : ''),array('class'=>'form-control','rows'=>'3','placeholder'=>'Description' ,'style'=>'width:100%;' )) !!}   

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="purchasingcost" class="col-sm-4 control-label">Purchasing Cost:</label>
                                        <div class="col-sm-8">
                                            {!! Form::text('purchasingcost', Input::old('purchasingcost',isset($rawmaterial->purchasingcost) ?  $rawmaterial->purchasingcost : ''),array('class'=>'form-control two-digits', 'placeholder' => 'Purchasing Cost', 'id' => 'purchasingcost deci')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="unit" class="col-sm-4 control-label">Unit:</label>
                                        <div class="col-sm-8">
                                            {!! Form::select('unit', ['1' => 'inches', '2' => 'squaremetters', '3' => 'metters', '4' => 'centimeters'], isset($rawmaterial->unit) ? $rawmaterial->unit:'1', array('class' => 'form-control Stock Unit')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="equivalency" class="col-sm-4 control-label">Equivalency:</label>
                                        <div class="col-sm-8">
                                           <!-- <input type="text" class="form-control" id="zipCode" placeholder="ZipCode"> -->
                                            {!! Form::text('equivalency', Input::old('equivalency',isset($rawmaterial->equivalency) ?  $rawmaterial->equivalency : ''),array('class'=>'form-control two-digits1', 'placeholder' => 'Equivalency', 'id' => 'equivalency')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="stockunit" class="col-sm-4 control-label">Stock Unit:</label>
                                        <div class="col-sm-8">
                                           <!-- <input type="text" class="form-control" id="zipCode" placeholder="ZipCode"> -->
                                            {!! Form::select('stockunit', ['1' => 'inches', '2' => 'squaremetters', '3' => 'metters', '4' => 'centimeters'], isset($rawmaterial->stockunit) ? $rawmaterial->stockunit:'1', array('class' => 'form-control Stock Unit')) !!}

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bomcost" class="col-sm-4 control-label">BOM Cost:</label>
                                        <div class="col-sm-8">
                                           <!-- <input type="text" class="form-control" id="zipCode" placeholder="ZipCode"> -->
                                            {!! Form::text('bomcost', Input::old('bomcost',isset($rawmaterial->bomcost) ?  $rawmaterial->bomcost : ''),array('class'=>'form-control two-digits2', 'placeholder' => 'BOM Cost', 'id' => 'bomcost', 'readonly')) !!}
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
            </section>
        </div>
    </div>
</div>

<!--body wrapper end-->
@endsection

