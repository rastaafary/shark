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
                                                                    <a href="#" class="btn btn-danger"><span class="fa fa-trash-o"></span> </a> 
                                                                    <a href="{{ action('ManageUserController@editUser')}}/{{$value->id}}" class="btn btn-primary"><span class="fa fa-pencil"></span></a>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                               @endforeach
                                                            <!--   
                                                            <tr class="gradeX">
                                                                <td>XYZ</td>
                                                                <td>XYZ@gmail.com</td>
                                                                <td><a href="#" class="btn btn-danger"><span class="fa fa-trash-o"></span> </a> 
                                                                    <a href="{{action('ManageUserController@userProfile')}}" class="btn btn-primary"><span class="fa fa-pencil"></span></a></td>

                                                            </tr>
                                                            <tr class="gradeX">
                                                                <td>PQR</td>
                                                                <td>pqr@gmail.com</td>
                                                                <td><a href="#" class="btn btn-danger"><span class="fa fa-trash-o"></span> </a> 
                                                                    <a href="{{action('ManageUserController@userProfile')}}" class="btn btn-primary"><span class="fa fa-pencil"></span></a></td>

                                                            </tr>-->
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

@endsection