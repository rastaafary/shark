@extends('layouts.main')

@section('content')
<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li><a href="#List" data-toggle="tab">List</a></li>
                        <li><a href="#Add" data-toggle="tab">Add</a></li>
                        <li class="active"><a href="#View" data-toggle="tab">Edit</a></li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="edit">
                            <form class="form-horizontal">
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
                                                            <input type="text" class="form-control" id="companyName" placeholder="Company Name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="zipCode" class="col-sm-4 control-label">ZipCode:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="zipCode" placeholder="ZipCode">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="buildingNumber" class="col-sm-4 control-label">Building Number:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="buildingNumber" placeholder="Building Number">
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="countryMethod" class="col-sm-4 control-label">Country:</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="countryMethod">
                                                                <option>USA</option>
                                                                <option>Germany</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="streetAddress" class="col-sm-4 control-label">Street Address:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="streetAddress" placeholder="Street Address">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phoneNumber" class="col-sm-4 control-label">Phone Number:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="phoneNumber" placeholder="Phone Number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="interiorNumber" class="col-sm-4 control-label">Interior Number:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="interiorNumber" placeholder="Interior Number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="faxNumber" class="col-sm-4 control-label">Fax Number:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="faxNumber" placeholder="Fax Number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="city" class="col-sm-4 control-label">City:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="city" placeholder="City">
                                                        </div>                                                               
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="website" class="col-sm-4 control-label">Website:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="website" placeholder="Website">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="state" class="col-sm-4 control-label">State:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="state" placeholder="State">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="col-md-14">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><i class="fa fa-truck"></i> Contact Details</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contactName" class="col-sm-4 control-label">Contact Name:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="contactName" placeholder="Contact Name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="position" class="col-sm-4 control-label">Position:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="position" placeholder="Position">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contactEmail" class="col-sm-4 control-label">Contact Email:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="contactEmail" placeholder="Contact Email">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contactMobile" class="col-sm-4 control-label">Contact Mobile:</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="contactMobile" placeholder="Contact Mobile">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="contactBirthdate" class="col-sm-4 control-label">Contact BirthDate:</label>
                                                            <div class="col-sm-8">
                                                                <input id="contactBirthdate" type="text" value="" size="16" class="form-control default-date-picker">
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="form-group" align="center">
                                                    <input type="submit" value="Submit" id="btnSubmit" class="btn btn-primary" style="margin-top: 10px;">
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!--body wrapper end-->
@endsection