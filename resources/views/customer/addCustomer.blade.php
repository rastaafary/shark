@extends('layouts.main')

@section('content')
<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li ><a href="/customer">List</a></li>
                        <li class="active"><a href="/customer/add">Add</a></li>                       
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="Add">
                             {!! Form::open(array('class'=>'form-horizontal','url'=>'/customer/add','name'=>'addCustomer','id'=>'addCustomer')) !!}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-home"></i> Customer Details</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="companyName" class="col-sm-4 control-label">Company Name:</label>
                                                        <div class="col-sm-8">
                                                            <!-- <input type="text" class="form-control" id="companyName" placeholder="Company Name"> -->
                                                            {!! Form::text('comp_name',Input::old('value',isset($cust->comp_name) ? $cust->comp_name : '') ,array('class'=>'form-control', 'placeholder' => 'Company Name')) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="zipCode" class="col-sm-4 control-label">ZipCode:</label>
                                                        <div class="col-sm-8">
                                                           <!-- <input type="text" class="form-control" id="zipCode" placeholder="ZipCode"> -->
                                                            {!! Form::text('zipcode',Input::old('value',isset($cust->zipcode) ? $cust->zipcode : '') ,array('class'=>'form-control', 'placeholder' => 'ZipCode')) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="buildingNumber" class="col-sm-4 control-label">Building Number:</label>
                                                        <div class="col-sm-8">
                                                          <!--  <input type="text" class="form-control" id="buildingNumber" placeholder="Building Number"> -->
                                                            {!! Form::text('building_no',Input::old('value',isset($cust->building_no) ? $cust->building_no : '') ,array('class'=>'form-control', 'placeholder' => 'Building Number')) !!}
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="countryMethod" class="col-sm-4 control-label">Country:</label>
                                                        <div class="col-sm-8">
                                                           <!-- <select class="form-control" id="countryMethod">
                                                                <option>USA</option>
                                                                <option>Germany</option>
                                                            </select> -->
                                                            {!! Form::select('country', array('USA' => 'USA', 'Germany' => 'Germany'),null ,array('class'=>'form-control', 'placeholder' => 'Country')) !!}                               
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="streetAddress" class="col-sm-4 control-label">Street Address:</label>
                                                        <div class="col-sm-8">
                                                           <!-- <input type="text" class="form-control" id="streetAddress" placeholder="Street Address"> -->
                                                            {!! Form::text('street_addrs',Input::old('value',isset($cust->street_addrs) ? $cust->street_addrs : '') ,array('class'=>'form-control', 'placeholder' => 'Street Address')) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phoneNumber" class="col-sm-4 control-label">Phone Number:</label>
                                                        <div class="col-sm-8">
                                                           <!-- <input type="text" class="form-control" id="phoneNumber" placeholder="Phone Number"> -->
                                                            {!! Form::text('phone_no',Input::old('value',isset($cust->phone_no) ? $cust->phone_no : '') ,array('class'=>'form-control', 'placeholder' => 'Phone Number')) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="interiorNumber" class="col-sm-4 control-label">Interior Number:</label>
                                                        <div class="col-sm-8">
                                                           <!--  <input type="text" class="form-control" id="interiorNumber" placeholder="Interior Number"> -->
                                                            {!! Form::text('interior_no',Input::old('value',isset($cust->interior_no) ? $cust->interior_no : '') ,array('class'=>'form-control', 'placeholder' => 'Interior Number')) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="faxNumber" class="col-sm-4 control-label">Fax Number:</label>
                                                        <div class="col-sm-8">
                                                           <!-- <input type="text" class="form-control" id="faxNumber" placeholder="Fax Number"> -->
                                                            {!! Form::text('fax_number',Input::old('value',isset($cust->fax_number) ? $cust->fax_number : '') ,array('class'=>'form-control', 'placeholder' => 'Fax Number')) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="city" class="col-sm-4 control-label">City:</label>
                                                        <div class="col-sm-8">
                                                         <!--   <input type="text" class="form-control" id="city" placeholder="City"> -->
                                                            {!! Form::text('city',Input::old('value',isset($cust->city) ? $cust->city : '') ,array('class'=>'form-control', 'placeholder' => 'City')) !!}
                                                        </div>                                                               
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="website" class="col-sm-4 control-label">Website:</label>
                                                        <div class="col-sm-8">
                                                         <!--  <input type="text" class="form-control" id="website" placeholder="Website">  -->
                                                           {!! Form::text('website',Input::old('value',isset($cust->website) ? $cust->website : '') ,array('class'=>'form-control', 'placeholder' => 'Website')) !!} 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="state" class="col-sm-4 control-label">State:</label>
                                                        <div class="col-sm-8">
                                                       <!--  <input type="text" class="form-control" id="state" placeholder="State"> -->
                                                         {!! Form::text('state',Input::old('value',isset($cust->state) ? $cust->state : '') ,array('class'=>'form-control', 'placeholder' => 'State')) !!} 
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="customer image" class="col-sm-4 control-label">Customer Image:</label>
                                                        <div class="col-sm-8">
                                                           <!-- <input id="uploadCustomerImage" type="file"> -->
                                                            {!! Form::file('image', '') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="col-md-14">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><i class="fa fa-phone"></i> Contact Details</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contactName" class="col-sm-4 control-label">Contact Name:</label>
                                                            <div class="col-sm-8">
                                                                <!-- <input type="text" class="form-control" id="contactName" placeholder="Contact Name"> -->
                                                                {!! Form::text('contact_name',Input::old('value',isset($cust->contact_name) ? $cust->contact_name : '') ,array('class'=>'form-control', 'placeholder' => 'Contact Name')) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="position" class="col-sm-4 control-label">Position:</label>
                                                            <div class="col-sm-8">
                                                               <!-- <input type="text" class="form-control" id="position" placeholder="Position"> -->
                                                                {!! Form::text('position',Input::old('value',isset($cust->position) ? $cust->position : '') ,array('class'=>'form-control', 'placeholder' => 'Position')) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contactEmail" class="col-sm-4 control-label">Contact Email:</label>
                                                            <div class="col-sm-8">
                                                               <!-- <input type="text" class="form-control" id="contactEmail" placeholder="Contact Email"> -->  
                                                                {!! Form::text('contact_email',Input::old('value',isset($cust->contact_email) ? $cust->contact_email : '') ,array('class'=>'form-control', 'placeholder' => 'Contact Email')) !!}
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contactPassword" class="col-sm-4 control-label">Contact Password:</label>
                                                            <div class="col-sm-8">
                                                            <!--    <input type="password" class="form-control" id="contactPassword" placeholder="Contact Password"> -->                                                              
                                                                 {!! Form::password('password',array('class'=>'form-control', 'placeholder' => 'Contact Password')) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contactMobile" class="col-sm-4 control-label">Contact Mobile:</label>
                                                            <div class="col-sm-8">
                                                               <!-- <input type="text" class="form-control" id="contactMobile" placeholder="Contact Mobile"> -->
                                                                {!! Form::text('contact_mobile',Input::old('value',isset($cust->contact_mobile) ? $cust->contact_mobile : '') ,array('class'=>'form-control', 'placeholder' => 'Contact Mobile')) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contactBirthdate" class="col-sm-4 control-label">Contact BirthDate:</label>
                                                            <div class="col-sm-8">
                                                             <!--   <input id="contactBirthdate" type="text" value="" size="16" class="form-control default-date-picker"> -->
                                                                {!! Form::text('contact_birthdate',Input::old('value',isset($cust->contact_birthdate) ? $cust->contact_birthdate : '') ,array('class'=>'form-control default-date-picker', 'placeholder' => 'Contact BirthDate')) !!}
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="form-group" align="center">
                                                    {!! Form::submit('Save',array('class'=>'btn btn-primary','id'=>'btnSave')) !!}                                                    
                                                </div>
                                            </div>
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

