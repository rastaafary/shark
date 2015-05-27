@extends('layouts.main')
@section('content')
{!! HTML::script('js/manageUser.js') !!}

<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li><a href="{!!url('/userList')!!}">List</a></li>
                        <li class="active"><a href="#Add">Add</a></li>                      
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content"> 
                        <div class="tab-pane active" id="Add">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">                                       
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-bars"></i> Add User</h3>
                                        </div>
                                        <div class="panel-body">  
                                            <!-- <form class="form-horizontal"> -->
                                            {!! Form::open(array('class'=>'form-horizontal','url'=>'/userList/add','name'=>'addUser','id'=>'addUser','files' => true)) !!}

                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <div class="form-group">
                                                        <label for="addEmail" class="col-sm-4 control-label">Email :</label>
                                                        <div class="col-sm-6">
                                                            <!-- <input type="text" class="form-control" id="addEmail" placeholder="Email ID"> -->
                                                            {!! Form::text('email',Input::old('email',isset($post['email']) ? $post['email'] : '') ,array('class'=>'form-control', 'placeholder' => 'Email ID')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="addPassword" class="col-sm-4 control-label">Password :</label>
                                                        <div class="col-sm-6">
                                                            <!-- <input type="text" class="form-control" id="addPassword" placeholder="Password"> -->
                                                            {!! Form::password('password',array('class'=>'form-control', 'placeholder' => 'Password')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="addName" class="col-sm-4 control-label">Name :</label>
                                                        <div class="col-sm-6">
                                                            <!-- <input type="text" class="form-control" id="addName" placeholder="Name"> -->
                                                            {!! Form::text('name', Input::old('name',isset($post['name']) ? $post['name'] : '') ,array('class'=>'form-control', 'placeholder' => 'Name')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="addBirthDate" class="col-sm-4 control-label">Birth Date :</label>
                                                        <div class="col-sm-6">
                                                           <!-- <input type="text" class="form-control" id="addBirthDate" placeholder="Birth Date"> -->
                                                            {!! Form::text('birthdate', Input::old('birthdate',isset($post['birthdate']) ? $post['birthdate'] : '') ,array('class'=>'form-control default-date-picker', 'placeholder' => 'Birth Date', 'id' => 'birthdate')) !!}
                                                        </div>
                                                    </div>                                                    
                                                    <div class="form-group">
                                                        <label for="addMobileNo" class="col-sm-4 control-label">Mobile No :</label>
                                                        <div class="col-sm-6">
                                                            <!-- <input type="text" class="form-control" id="addMobileNo" placeholder="Mobile No"> -->
                                                            {!! Form::text('mobileno', Input::old('mobileno',isset($post['mobileno']) ? $post['mobileno'] : '') ,array('class'=>'form-control', 'placeholder' => 'Mobile No')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="addPosition" class="col-sm-4 control-label">Position :</label>
                                                        <div class="col-sm-6">
                                                            <!-- <input type="text" class="form-control" id="addPosition" placeholder="Position"> -->
                                                            {!! Form::text('position', Input::old('position',isset($post['position']) ? $post['position'] : '') ,array('class'=>'form-control', 'placeholder' => 'Position')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="addPosition" class="col-sm-4 control-label">Role :</label>
                                                        <div class="col-sm-6">
                                                            <!-- <input type="text" class="form-control" id="addPosition" placeholder="Position"> -->
                                                            {!! Form::select('role', array('1' => 'Admin', '2' => 'Manager'),null ,array('class'=>'form-control')) !!}                               
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="addImage" class="col-sm-4 control-label">Image :</label>                           
                                                        <div class="col-sm-6">                              
                                                           <!--  <input id="addImage" type="file"> -->
                                                            {!! Form::file('image', '') !!}
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="modal-footer">
                                                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Save</button> -->
                                                {!! Form::submit('Save',array('class'=>'btn btn-primary','id'=>'btnSave')) !!}                                        
                                                <a href="{{ action('ManageUserController@userList') }}" class="btn btn-default"><span>Cancle</span></a>
                                            </div>
                                            {!! Form::close() !!}
                                            <!-- </form> -->
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