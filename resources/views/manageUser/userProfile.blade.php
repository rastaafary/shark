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
                                                <h3 class="panel-title"><i class="fa fa-bars"></i> User Profile</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label for="userName" class="col-sm-4 control-label">Name :</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="userName" placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="userEmail" class="col-sm-4 control-label">Email :</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="userEmail" placeholder="Email ID">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="userPhone" class="col-sm-4 control-label">Phone No :</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="userPhone" placeholder="Phone No">
                                                    </div>
                                                </div> 
                                                <div class="form-group">
                                                    <label for="userRole" class="col-sm-4 control-label">Role :</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="userRole">
                                                            <option>Admin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group" align="center">
                                                    <div class="col-sm-11">
                                                    <a href="#" class="btn btn-primary"><span class="fa fa-save"> Save</span> </a>
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