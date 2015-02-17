@extends('layouts.main')

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">              
                <div class="panel-body">
                    <div class="tab-content">                        
                        <div class="tab-pane active" id="List">
                            <!--<form class="form-horizontal">-->
                            {!! Form::open(array('id'=>'editUser','class'=>'form-horizontal','url'=>'/userProfile/edit')) !!}
                            {!! Form::hidden('id',Input::old('value',isset( Auth::user()->id) ?  Auth::user()->id : '')) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">                                                            
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-bars"></i> User Profile</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="userName" class="col-sm-4 control-label">Name :</label>
                                                <div class="col-sm-4">
                                                    <!--<input type="text" class="form-control" id="userName" placeholder="Name">-->
                                                    {!! Form::text('name', Input::old('value',isset($user->name) ? $user->name : ''),array('class'=>'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="userEmail" class="col-sm-4 control-label">Email :</label>
                                                <div class="col-sm-4">
                                                    <!--<input type="text" class="form-control" id="userEmail" placeholder="Email ID">-->
                                                    {!! Form::text('email', Input::old('value',isset($user->email) ? $user->email : ''),array('class'=>'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="userPhone" class="col-sm-4 control-label">Phone No :</label>
                                                <div class="col-sm-4">
                                                  <!-- <input type="text" class="form-control" id="userPhone" placeholder="Phone No">-->
                                                    {!! Form::text('mobileno', Input::old('value',isset($user->mobileno) ? $user->mobileno : ''),array('class'=>'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="addPosition" class="col-sm-4 control-label">Position :</label>
                                                <div class="col-sm-4">
                                                    <!-- <input type="text" class="form-control" id="addPosition" placeholder="Position"> -->
                                                    {!! Form::text('position', Input::old('value',isset($user->position) ? $user->position : ''),array('class'=>'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="addPosition" class="col-sm-4 control-label">Role :</label>
                                                <div class="col-sm-4">
                                                    <!-- <input type="text" class="form-control" id="addPosition" placeholder="Position"> -->
                                                    @if($user->role==1)
                                                    {!! Form::label('role',Input::old('value','Customer') ) !!}
                                                    @else
                                                    {!! Form::label('role',Input::old('value','Admin') ) !!}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="changePassword" class="col-sm-4 control-label">Change Password :</label>
                                                <div class="col-sm-4">
                                                    <!--<input type="text" class="form-control" id="password" placeholder="New Password">-->
                                                    {!! Form::password('password',array('class'=>'form-control', 'placeholder' => 'New Password')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="reTypePassword" class="col-sm-4 control-label">Re Type Password :</label>
                                                <div class="col-sm-4">
                                                    <!--<input type="text" class="form-control" id="reTypePassword" placeholder="Retype New Password">-->
                                                    {!! Form::password('reTypePassword',array('class'=>'form-control', 'placeholder' => 'Retype New Password')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="addBirthDate" class="col-sm-4 control-label">Birth Date :</label>
                                                <div class="col-sm-4">
                                                  <!--<input type="text" class="form-control" id="addBirthDate" placeholder="Birth Date">-->
                                                    {!! Form::text('birthdate',Input::old('value',isset($user->birthdate) ? $user->birthdate : '') ,array('class'=>'form-control default-date-picker', 'placeholder' => 'Birth Date')) !!}
                                                </div>
                                            </div>     
                                            <div class="form-group">
                                                <label for="addImage" class="col-sm-4 control-label">Image :</label>                           
                                                <div class="col-sm-4">                              
                                                   <!--  <input id="addImage" type="file"> -->
                                                    {!! Form::file('image', '') !!}
                                                </div>`
                                            </div>
                                            <div class="form-group" align="center">
                                                <div class="col-sm-11">
                                                    <!--<a href="#" class="btn btn-primary"> </a>-->
                                                    <!--<span class="fa fa-save">-->
                                                    {!! Form::submit('Save',array('class'=>'fa fa-save','class'=>'btn btn-primary')) !!}
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <a href="#" class="btn btn-primary"> Cancel</a>
                                                </div>
                                                <div class="col-sm-8">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <!--</form>-->
                            {!! Form::close() !!}
                        </div>
                    </div>                       
                </div>

            </section>
        </div>
    </div>
</div>
</div>

@endsection