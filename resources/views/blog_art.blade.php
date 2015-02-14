@extends('layouts.main')
@section('content')
<!--
<a href="{{ action('PartController@partList')}}">List</a> 
<a href="{{ action('PartController@addPart')}}">Add</a> 
<a href="{{ action('PartController@editPart')}}">Edit</a> 
{!! Form::open(array('url'=>'/part/add/', 'id'=>'addpart')) !!}
{!! Form::hidden('id', Input::old('value',isset($part->id) ? $part->id : '')) !!}
{!! Form::label('SKU','SKU',array('id'=>'','class'=>'')) !!}
{!! Form::text('SKU', Input::old('value',isset($part->SKU) ? $part->SKU : '')) !!}<br/>
{!! Form::label('description','description',array('id'=>'','class'=>'')) !!}
{!! Form::text('description', Input::old('value',isset($part->description) ? $part->description : '')) !!}<br/>
{!! Form::label('cost','cost',array('id'=>'','class'=>'')) !!}
{!! Form::text('cost', Input::old('value',isset($part->cost) ? $part->cost : '')) !!}<br/>
{!! Form::label('currency','currency',array('id'=>'','class'=>'')) !!}
{!! Form::select('currency', array('USD' => 'USD', 'MXN' => 'MXN')) !!}<br/>
{!! Form::submit('save') !!}
{!! Form::close() !!}
-->
<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <section class="panel panel-default">
                <header class="panel-heading">
                    <h3 class="panel-title">Blog Art</h3>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">PO#:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="chats normal-chat">
                        <li class="in">
                            <img src="images/photos/user1.png" alt="" class="avatar">
                            <div class="message ">
                                <span class="arrow"></span>
                                <a class="name" href="#">Jone Doe</a>
                                <span class="datetime">at Apr 28, 2014 1:33</span>
                                <span class="body">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. dolore magna aliquam erat volutpat. dolore magna aliquam erat volutpat.
                                </span>
                            </div>
                            <div class="attach">
                                <span class="name" href="#">Image Preview:</span>
                                <img class="attach-img" src="images/photos/user1.png">
                                <img class="attach-img" src="images/photos/user1.png">
                                <img class="attach-img" src="images/photos/user1.png">
                            </div>
                        </li>
                        <li class="out">
                            <img src="images/photos/user2.png" alt="" class="avatar">
                            <div class="message">
                                <span class="arrow"></span>
                                <a class="name" href="#">Margarita Rose</a>
                                <span class="datetime">at Apr 28, 2014 1:35</span>
                                <span class="body">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                </span>
                            </div>
                            <div class="attach">
                                <span class="name" href="#">Image Preview:</span>
                                <img class="attach-img" src="images/photos/user1.png">
                                <img class="attach-img" src="images/photos/user1.png">
                                <img class="attach-img" src="images/photos/user1.png">
                            </div>
                        </li>
                        <li class="in">
                            <img src="images/photos/user1.png" alt="" class="avatar">
                            <div class="message">
                                <span class="arrow"></span>
                                <a class="name" href="#">Jone Doe</a>
                                <span class="datetime">at Apr 28, 2014 1:36</span>
                                <span class="body">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                </span>
                            </div>
                        </li>
                    </ul>
                    <div class="chat-form ">
                        <form role="form" class="form-inline">
                            <div class="form-group">
                                <textarea placeholder="Type a message here..." class="form-control" style="width: 100%"></textarea>
<!--                                <input type="text" style="width: 100%" placeholder="Type a message here..." class="form-control">-->
                            </div>
                            <!--                            <button class="btn btn-primary" type="submit">Send</button>-->
                            <div class="attachment">
                                <div class="form-group">
                                    <div class="form-control">
                                        <input type="file">
                                    </div>
                                    <button class="btn btn-primary"><i class="fa fa-plus"></i> </button>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <input type="file">
                                    </div>
                                    <button class="btn btn-danger"><i class="fa fa-minus"></i> </button>
                                </div>
                                
                            </div>
                            <button class="btn btn-primary" type="submit">Send</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>

</div>
<!--body wrapper end-->
@endsection