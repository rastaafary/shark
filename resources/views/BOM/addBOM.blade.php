@extends('layouts.main')
@section('content')
{!! HTML::script('js/BOM.js') !!}
{!! HTML::script('js/addBOM.js') !!}
{!! HTML::script('js/jquery.maskedinput.min.js') !!}
<?php if ($route_name == 'edit') { ?>
    {!! HTML::script('js/EditBOM.js') !!}
<?php } ?>
<script>
    var part_id = '<?php echo $part_id ?>';
    var route_name = '<?php echo $route_name ?>';
    var oldBomData = <?php echo (isset($bomList)) ? json_encode($bomList) : '[]'; ?>;
    var bId = <?php echo (isset($id)) ? $id : 0; ?>;

</script>

<div class="wrapper">
    <div class="row">
        <div class="col-md-12">

            <header class="panel-heading custom-tab dark-tab">
                <ul class="nav nav-tabs">
                    <li><a href="{!!url('/')!!}/part/{{$part_id}}/bom">List</a></li>
                    <li class="active"><a href="{!!url('#Add')!!}"><?php echo isset($bom->id) ? 'Edit' : 'Add'; ?></a></li>                       
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
                                                    <label id="lbl_part_id" class="col-sm-4 control-label" style='display: none;'></label> 
                                                    <select id="part_id" name="part_id" class='form-control skuDropDown'>
                                                        @if(count($part_data) > 0)
                                                        <!--                                                        <option value='selected=selected'> Select SKU </option>-->


                                                        @foreach($part_data as $value)
                                                        @if($value->id == $part_id)
                                                        <option value="{{$value->id}}" selected>{{$value->SKU}}</option>

                                                        @elseif(isset($bom->part_id) && $value->id == $bom->part_id)

                                                        <option value="{{$value->id}}" selected>{{$value->SKU}}</option>

                                                        @else
                                                        <option value="{{$value->id}}">{{$value->SKU}}</option>

                                                        @endif
                                                        @endforeach

                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="skuDescripton" >SKU Description : </label>

                                                {!! Form::text('skuDescripton',Input::old('skuDescripton',isset($bom->skuDescripton) ? $bom->skuDescripton : '') ,array('class'=>'form-control','id'=>'skuDescripton','placeholder'=>'SKU Description',  'readonly')) !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="table-responsive col-md-12">
                                                <table id="purchaseOrderTbl" class="display table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 2%;">#</th>
                                                            <th style="width: 8%;">RawMaterial</th>
                                                            <th style="width: 13%;">Description</th>
                                                            <th style="width: 3%;">BOMCost</th>
                                                            <th style="width: 3%;">ScrapeRate(%)</th>
                                                            <th style="width: 3%;">Yield</th>
                                                            <th style="width: 6%;">Total</th>
                                                            <th style="width: 12%;">Unit</th>
                                                            <th style="width: 6%;">Action</th>
                                                        </tr> 
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" id="deleteOrder" name="deleteOrder">
                                                                <input type="hidden" id="allOrderData" name="orders" value="">
                                                                <input type="hidden" id="updateId" value="0">
                                                            </td>

                                                            <td>
                                                                <input type="text" class="form-control typeahead" name="selectedRawMaterial" id='selectedRawMaterial' class="selectedRawMaterial" placeholder="SHK-FAB-1000">
                                                                <input type="hidden" id="raw_material" class="raw_material" name="raw_material"  value=""/>
                                                            </td>
                                                            <td>
<!--                                                                <input  autocomplete="off" type="text" class="form-control typeahead" name="descritpion" id='descritpion' placeholder="SHK-FAB-1000" readonly>-->
                                                                {!! Form::text('descritpion','' ,array('class'=>'form-control', 'placeholder' => '','id' => 'descritpion', 'readonly')) !!}
                                                            </td>
                                                            <td>    
                                                                {!! Form::text('bom_cost','' ,array('class'=>'form-control two-digits typeahead', 'placeholder' => '','id' => 'bom_cost', 'readonly')) !!}
<!--                                                                <input  autocomplete="off" type="text" class="form-control typeahead" name="bom_cost" id='bom_cost' readonly>-->
                                                            </td>
                                                            <td>    
                                                                {!! Form::text('scrap_rate','' ,array('class'=>'form-control two-digits typeahead', 'placeholder' => '', 'id' => 'scrap_rate')) !!}
<!--                                                                <input  autocomplete="off" type="text" class="form-control typeahead" name="scrap_rate" id='scrap_rate' >-->
                                                            </td>
                                                            <td>    
                                                                {!! Form::text('yield','' ,array('class'=>'form-control two-digits1', 'placeholder' => '', 'id' => 'yield')) !!}
<!--                                                                <input  autocomplete="off" type="text" class="form-control typeahead" name="yield" id='yield'>-->
                                                            </td>
                                                            <td>
                                                                {!! Form::text('total','',array('class'=>'form-control', 'placeholder' => '', 'id' => 'total', 'readonly')) !!}
<!--                                                                 <input  autocomplete="off" type="text" class="form-control typeahead" name="total" id='total' readonly>-->
                                                            </td>
                                                            <td>
                                                                <!--                                                                {!! Form::text('unit','',array('class'=>'form-control', 'placeholder' => '', 'id' => 'unit', 'readonly')) !!}-->
                                                                <input  autocomplete="off" type="text" class="form-control typeahead" name="unit" id='unit' readonly>
                                                            </td>
                                                            <td>
                                                                <button id="addMoreOrder" class="btn btn-primary" type="button"><i class="fa fa-plus"></i> Add</button>
                                                                <button id="cancelUpdate" class="btn btn-warning" type="button" style="display: none;"><i class="fa fa-reply"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="9">
                                                                <span style="margin-left: 53%;">
                                                                    Total Amount : <label id="totalAmout">0</label>
                                                                </span>                                                    
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>


                                                <div class="form-group" align="center">
                                                    {!! Form::submit('Save',array('class'=>'btn btn-primary', 'id'=>'btnSubmit')) !!}
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                {!! Form::close() !!}

                            </div> 

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/x-jQuery-tmpl" id="new-order-template">
    <tr class="newOrderData" id="newOrder-${orderNo}">
    <td>
    <input type="hidden" class="orderId" value="${orderId}">
    ${orderNo}
    </td>           
    <td>
    <label class="selectedRawMaterial" >${selectedRawMaterial}</label>
    <label class="raw_material" style="display:none;">${raw_material}</label>
    </td>
    <td>
    <label class="descritpion">${descritpion}</label>
    </td>
    <td>
    <label class="bom_cost">${bom_cost}</label>
    </td>
    <td>
    <label class="scrap_rate">${scrap_rate}</label>
    </td>
    <td>
    <label class="yield">${yield}</label>
    </td>
    <td>
    <label class="total">${total}</label>
    </td>
    <td>
    <label class="unit">${unit}</label>
    </td>
    <td>
    <button type="button" class="btn btn-danger" onclick="return removeNewOrder(this)" id="tblDelete-${orderId}"><i class="fa fa-trash-o"></i></button>
    <button type="button" class="btn btn-primary" onclick="return editNewOrder(this)" id="tblEdit-${orderId}"><i class="fa fa-edit"></i></button>
    </td>
    </tr>
</script>

@endsection