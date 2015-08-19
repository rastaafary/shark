@extends('layouts.main')
@section('content')
{!! HTML::script('js/production_sequence.js') !!}
<script>
    var whichPage = '<?php echo isset($part->id) ? 'Edit' : 'Add'; ?>';
</script>
<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        <li><a href="{!!url('/sequence')!!}">List</a></li>
                        <li class="active"><a href="{!!url('#')!!}" data-toggle="tab"><?php echo isset($part->id) ? 'Edit' : 'Add'; ?></a></li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">                                       

                        <div class="tab-pane active" id="Add">                            
                            {!! Form::open(array('url'=>'/sequence/add','files' => true)) !!}
                            {!! Form::hidden('id', Input::old('id')) !!}

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">                                        
                                        {!! HTML::ul($errors->all()) !!}
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-bars"></i> Add / Edit Production Sequence</h3>
                                        </div>
                                        <div class="panel-body">

                                            <div class="row">
                                                @if(Session::has('success'))
                                                <div class="alert alert-success">{!! Session::get('success') !!}</div>
                                                @elseif(Session::has('error'))
                                                <div class="alert alert-success">{!! Session::get('error') !!}</div>
                                                @endif
                                                <div style="color: red">
                                                    {!! HTML::ul($errors->all()) !!}
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="description" class="col-sm-4 control-label">Name:</label>
                                                        <div class="col-sm-8">
                                                            {!! Form::text('title', Input::old('title')) !!}   
                                                        </div>
                                                    </div>   
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 text-center">
                                                        {!! Form::submit('Save',array('class'=>'btn btn-primary')) !!}
                                                    </div>
                                                </div>
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