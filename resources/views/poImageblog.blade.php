@extends('layouts.main')
@section('content')
{!! HTML::script('js/blogArt.js') !!}
<div class="wrapper">
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <section class="panel panel-default">
                <header class="panel-heading">
                    <h3 class="panel-title">Image Blog Art</h3>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">PO#:</label>
                                    <div class="col-sm-7">
                                        <label class="control-label">{!! $po_image_data->po_id !!}</label>
                                        <a class="btn btn-link" href="{!!url('/')!!}/po/edit/{!! $po_image_data->po_id !!}" role="button"><strong>Back To PO</strong></a> 
                                    </div>
                                    <div class="col-sm-1 pull-right">
                                        <a href="{!!url('/')!!}/files/poMultiImage/<?php echo $po_image_data->fileName; ?>" target="_new">Click To View</a>
                                    </div>
                                    
                                    @if($isValidUser)
                                    <div class="col-sm-1 pull-right" style="margin: 11px -272px 0px 4px;">
                                        <button class="btn btn-warning" onclick="$('#orderList').show();">Approve</button>
                                        &nbsp;
                                        {!! Form::open(array('method' => 'post','action'=> array('PoImageBlogController@approveImage',$id),'class'=>'form-inline', 'name'=>'frmApproved','id'=>'frmApproved')) !!}
                                        {!! Form::hidden('id',Input::old('id',isset($id) ? $id : '')) !!}
                                        {!! HTML::ul($errors->all()) !!}
                                        
                                            <div id="orderList" style="display: none;">
                                                <select name="order" id="selectOrderList">
                                                    @foreach($ordersList as $order)
                                                    <option value="{{ $order->order_id }}">{{ $order->sku }}</option>
                                                    @endforeach                                            
                                                </select>
                                                &nbsp;
                                                <button type="submit" class="btn btn-primary">Done</button>
                                            </div>
                                        
                                        {!! Form::close() !!}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="chats normal-chat">
                        <?php
                        $arr = array();
                        foreach ($comments as $value)
                        {
                            array_push($arr, array('id' => $value->id, 'customer_id' => $value->customer_id, 'name' => $value->name, 'comments' => $value->comments, 'image' => $value->image));
                        }
                        $data = $arr;
                        $cnt = count($data);
                        //  var_dump($data);
                        // echo $data[1]['name'];
                        //  for($cnt = $cnt - 1; $cnt >= 0;$cnt--){
                        // }
                        ?>
                        @for($cnt = $cnt - 1; $cnt >= 0; $cnt--)
                        @if($data[$cnt]['customer_id'] == Auth::user()->id)
                        <li class="out">
                            @else
                        <li class="in">
                            @endif
                            <img height="45px" width="45px" class="avatar" src="{!!url('/')!!}/images/user/{{ $data[$cnt]['image'] }}"> 
                            <div class="message ">
                                <span class="arrow"></span>
                                <a class="name" href="#">{{ $data[$cnt]['name'] }}</a>                               
                                <span class="body">
                                    {{ $data[$cnt]['comments'] }}
                                </span>
                            </div>
                            <div class="attach">                              
<?php $flag = 0; ?>
                                @foreach($image_data as $val)                               
                                @if($val->comment_id == $data[$cnt]['id'])
                                @if($flag == 0)
                                <span class="name" href="#">Image Preview:</span>
<?php $flag = 1; ?>                                        
                                @endif
                                <a href="#" data-toggle="modal" data-target="#lightbox"> 
                                    <img class="attach-img" height="30px" width="45px" src="{!!url('/')!!}/images/blog/{{ $val->filename }}">
                                </a>  
                                @endif
                                @endforeach
                            </div>
                        </li>
                        @endfor
                    </ul>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <ul class="pagination">
                                <?php
//   $lastPage = $data->lastPage();
// $curr = $data->currentPage($lastPage);                           
                                echo $comments->render();
                                ?>
                            </ul>
                            <!--                            <ul class="pagination">
                                                            <li><a href="#">«</a></li>
                                                            <li class="active"><a href="#">1</a></li>
                                                            <li><a href="#">2</a></li>
                                                            <li><a href="#">3</a></li>
                                                            <li><a href="#">4</a></li>
                                                            <li><a href="#">5</a></li>
                                                            <li><a href="#">»</a></li>
                            -->
                        </div>
                    </div>
                    <div class="chat-form ">
                        <!--<form role="form" class="form-inline" id="frmBlogArt" method="post">-->
                        {!! Form::open(array('class'=>'form-inline', 'name'=>'frmBlogArt','id'=>'frmBlogArt','files' => true)) !!}
                        {!! Form::hidden('id',Input::old('id',isset($id) ? $id : '')) !!}
                        {!! HTML::ul($errors->all()) !!}
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
<!--                                <a class="btn btn-primary add-Onemore" id='addImage'><i class="fa fa-plus"></i> </a>-->
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