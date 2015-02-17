@extends('layouts.main')

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">              
                <div class="panel-body">
                    <div class="tab-content">                        
                        <div class="tab-pane active" id="List">
                            <form class="form-horizontal">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">                                                            
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> User List</h3>
                                            </div>
                                            <div class="panel-body">
                                                 <div class="row">
                                                    <div class="col-md-12">
                                                        <a href="{{ action('ManageUserController@addUser')}}" class="btn btn-primary"><span class="fa fa-plus"></span> Add  User</a>
                                                    </div>
                                                </div><br>
                                                <div class="table-responsive">
                                                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Action</th>                                                            
                                                            </tr> 
                                                        </thead>
                                                        @foreach ($userlist as $value)                                                    
                                                        <tbody>
                                                            <tr class="gradeX">
                                                                <td>{{ $value->name }}</td>
                                                                <td> {{ $value->email }}</td>
                                                                <td><!--<a href="#" class="btn btn-danger"><span class="fa fa-trash-o"></span> </a> 
                                                                    <a href="{{action('ManageUserController@userProfile')}}" class="btn btn-primary"><span class="fa fa-pencil"></span></a>-->
                                                                    @if (isset($value->id))
                                                                    <a href="{{ action('ManageUserController@deleteUser')}}/{{$value->id}}" class="btn btn-danger"><span class="fa fa-trash-o"></span> </a> 
                                                                    <a href="{{ action('ManageUserController@editUser')}}/{{$value->id}}" class="btn btn-primary"><span class="fa fa-pencil"></span></a>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                               @endforeach                                                           
                                                        </tbody>
                                                    </table>                                                                   
                                                </div>                                   
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </form>
                        </div>
                    </div>                       
                </div>

            </section>
        </div>
    </div>
</div>
</div>
<!-- Modal Start -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           <!-- <form class="form-horizontal"> -->
           {!! Form::open(array('class'=>'form-horizontal','url'=>'/userList','name'=>'addUser','id'=>'addUser')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add User</h4>
                </div>
            
                <div class="alert alert-block alert-danger" style="display: none;" id='errormsg'>
                    <span id='errorMessageSpan'></span>
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    
                </div>
               
                <div class="modal-body">
                    <div class="table-responsive">
                        <div class="form-group">
                            <label for="addEmail" class="col-sm-4 control-label">Email :</label>
                            <div class="col-sm-6">
                                <!-- <input type="text" class="form-control" id="addEmail" placeholder="Email ID"> -->
                                {!! Form::text('email','' ,array('class'=>'form-control', 'placeholder' => 'Email ID')) !!}
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
                                {!! Form::text('name', '' ,array('class'=>'form-control', 'placeholder' => 'Name')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="addBirthDate" class="col-sm-4 control-label">Birth Date :</label>
                            <div class="col-sm-6">
                               <!-- <input type="text" class="form-control" id="addBirthDate" placeholder="Birth Date"> -->
                                {!! Form::text('birthdate', '' ,array('class'=>'form-control default-date-picker', 'placeholder' => 'Birth Date')) !!}
                            </div>
                        </div>                                                    
                        <div class="form-group">
                            <label for="addMobileNo" class="col-sm-4 control-label">Mobile No :</label>
                            <div class="col-sm-6">
                                <!-- <input type="text" class="form-control" id="addMobileNo" placeholder="Mobile No"> -->
                                {!! Form::text('mobileno', '' ,array('class'=>'form-control', 'placeholder' => 'Mobile No')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="addPosition" class="col-sm-4 control-label">Position :</label>
                            <div class="col-sm-6">
                                <!-- <input type="text" class="form-control" id="addPosition" placeholder="Position"> -->
                                {!! Form::text('position', '' ,array('class'=>'form-control', 'placeholder' => 'Position')) !!}
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="addPosition" class="col-sm-4 control-label">Role :</label>
                            <div class="col-sm-6">
                                <!-- <input type="text" class="form-control" id="addPosition" placeholder="Position"> -->
                                {!! Form::select('role', array('A' => 'Admin', 'C' => 'Customer'),null ,array('class'=>'form-control', 'placeholder' => 'Role')) !!}                               
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
           {!! Form::close() !!}
           <!-- </form> -->
        </div>
    </div>
</div>
<!-- Modal End --> 
@endsection