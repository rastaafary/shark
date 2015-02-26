@extends('layouts.main')
@section('content')

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
                                        <label class="control-label">{!! $po_id !!}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="chats normal-chat">
                        @foreach($data as $value)
                        <li class="in">
                             
                            <input type="image" height="45px" width="45px" class="avatar" src="/images/user/{{ $value->image }}"> 
                            <div class="message ">
                                <span class="arrow"></span>
                                <a class="name" href="#">{{ $value->name }}</a>                               
                                <span class="body">
                                    {{ $value->comments }}
                                </span>
                            </div>
                            <div class="attach">
                                <span class="name" href="#">Image Preview:</span>
                                <a href="#" data-toggle="modal" data-target="#lightbox"> 
                                    <img class="attach-img" src="images/photos/user1.png">
                                </a>
                                <a href="#" data-toggle="modal" data-target="#lightbox"> 
                                    <img class="attach-img" src="images/photos/user2.png">
                                </a>
                                <a href="#" data-toggle="modal" data-target="#lightbox"> 
                                    <img class="attach-img" src="images/photos/user3.png">
                                </a>
                            </div>
                        </li>
                        @endforeach
<!--                        <li class="in">
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
                                <a href="#" data-toggle="modal" data-target="#lightbox"> 
                                    <img class="attach-img" src="images/photos/user1.png">
                                </a>
                                <a href="#" data-toggle="modal" data-target="#lightbox"> 
                                    <img class="attach-img" src="images/photos/user2.png">
                                </a>
                                <a href="#" data-toggle="modal" data-target="#lightbox"> 
                                    <img class="attach-img" src="images/photos/user3.png">
                                </a>
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
                                <a href="#" data-toggle="modal" data-target="#lightbox"> 
                                    <img class="attach-img" src="images/photos/user1.png">
                                </a>
                                <a href="#" data-toggle="modal" data-target="#lightbox"> 
                                    <img class="attach-img" src="images/photos/user2.png">
                                </a>
                                <a href="#" data-toggle="modal" data-target="#lightbox"> 
                                    <img class="attach-img" src="images/photos/user3.png">
                                </a>
                            </div>
                        </li>                       -->
                    </ul>
                    <div class="chat-form ">
                        <!--                        <form role="form" class="form-inline" id="frmBlogArt" method="post">-->
                        {!! Form::open(array('class'=>'form-inline', 'name'=>'frmBlogArt','id'=>'frmBlogArt','files' => true)) !!}
                        {!! Form::hidden('id',Input::old('id',isset($id) ? $id : '')) !!}
                        <div class="form-group">
                            <textarea placeholder="Type a message here..." class="form-control" style="width: 100%" name="txtMessage" id="txtMessage"></textarea>
<!--                                <input type="text" style="width: 100%" placeholder="Type a message here..." class="form-control">-->
                        </div>                            
                        <div class="attachment">
                            <script type="text/template" id="element-template">
                                <div class="addpo" style="margin-top: 5px;">                               
                                <div class="form-control">
                                <input type="file" autocomplete="off" id="images" class="input" name="images[]">
                                </div>
                                <a class="btn btn-danger remove" onclick="removediv(this)" value="remove"><i class="fa fa-minus"></i> </a>                                    
                                </div>
                            </script>
                            <div id="maindiv"></div>
                            <div class="form-group" style="margin-top: 5px;">
                                <div class="form-control">
                                    <input type="file" name="images[]" id="images">
                                </div>
                                <a class="btn btn-primary add-Onemore" id='addImage'><i class="fa fa-plus"></i> </a>
                            </div>
                        </div>
                        <!--<button class="btn btn-primary" type="submit" id="submit">Send</button>-->
                        <button class="btn btn-primary" type="submit" value="remove" id="submit">Send</button>                                    
                        {!! Form::close() !!}
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<div id="lightbox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">×</button>
        <div class="modal-content">
            <div class="modal-body">
                <img src="" alt="" />
            </div>
        </div>
    </div>
</div>
<!--body wrapper end-->
@endsection