@extends('layouts.main')
@section('content')
{!! HTML::script('js/customer.js') !!}
<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li ><a href="/RawMaterial">List</a></li>
                        <li class="active"><a href="/customer/add"><?php echo isset($id) ? 'Edit' : 'Add'; ?></a></li>                       
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="Add">

                            {!! Form::open(array('class'=>'form-horizontal','url'=>'RawMaterial/add','name'=>'addCustomer','id'=>'addCustomer','files' => true)) !!}
                                
                            <div class="row">
                                {!! HTML::ul($errors->all()) !!}
                                <div class="col-sm-6">
                                   <div class="form-group">
                                        <label for="partnumber" class="col-sm-4 control-label">Part Number:</label>
                                        <div class="col-sm-8">
                                           <!-- <input type="text" class="form-control" id="zipCode" placeholder="ZipCode"> -->
                                            {!! Form::text('partnumber','' ,array('class'=>'form-control', 'placeholder' => 'Part Number')) !!}
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="col-sm-4 control-label">Description:</label>
                                        <div class="col-sm-8">
                                           <!-- <input type="text" class="form-control" id="zipCode" placeholder="ZipCode"> -->
                                            <!--{!! Form::text('zipcode','' ,array('class'=>'form-control', 'placeholder' => 'Company Name')) !!}-->
                                             {!! Form::textarea('description','',array('class'=>'form-control','rows'=>'3','placeholder'=>'Description' ,'style'=>'width:100%;' )) !!}   
                                               @if ($errors->has('description')){{ $errors->first('description') }} @endif</td>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="purchasingcost" class="col-sm-4 control-label">Purchasing Cost:</label>
                                        <div class="col-sm-8">
                                           <!-- <input type="text" class="form-control" id="zipCode" placeholder="ZipCode"> -->
                                            {!! Form::text('purchasingcost','' ,array('class'=>'form-control', 'placeholder' => 'Purchasing Cost')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group">
                                        <label for="unit" class="col-sm-4 control-label">Unit:</label>
                                        <div class="col-sm-8">
                                           <!-- <input type="text" class="form-control" id="zipCode" placeholder="ZipCode"> -->
                                            <!--{!! Form::text('zipcode','' ,array('class'=>'form-control', 'placeholder' => 'Company Name')) !!}-->
                                            {!! Form::select('unit', ['1' => 'inches', '2' => 'squaremetters', '3' => 'metters', '4' => 'centimeters'], '', array('class' => 'Stock Unit')) !!}
                                          
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="equivalency" class="col-sm-4 control-label">Equivalency:</label>
                                        <div class="col-sm-8">
                                           <!-- <input type="text" class="form-control" id="zipCode" placeholder="ZipCode"> -->
                                            {!! Form::text('equivalency','' ,array('class'=>'form-control', 'placeholder' => 'Equivalency')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="stockunit" class="col-sm-4 control-label">Stock Unit:</label>
                                        <div class="col-sm-8">
                                           <!-- <input type="text" class="form-control" id="zipCode" placeholder="ZipCode"> -->
                                            {!! Form::select('stockunit', ['1' => 'inches', '2' => 'squaremetters', '3' => 'metters', '4' => 'centimeters'], '', array('class' => 'Stock Unit')) !!}
                                            
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label for="bomcost" class="col-sm-4 control-label">BOM Cost:</label>
                                        <div class="col-sm-8">
                                           <!-- <input type="text" class="form-control" id="zipCode" placeholder="ZipCode"> -->
                                            {!! Form::text('bomcost','' ,array('class'=>'form-control', 'placeholder' => 'BOM Cost')) !!}
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

