<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="ThemeBucket">
        <link rel="shortcut icon" href="#" type="image/png">

        <title>Reset Password</title>

        {!! HTML::style('css/style.css') !!}
        {!! HTML::style('css/style-responsive.css') !!}
        {!! HTML::script('js/scripts.js') !!} 
        {!! HTML::script('js/jquery/jquery.min.js') !!}
        {!! HTML::script('js/validation/jquery.validate.js') !!} 
        {!! HTML::script('js/forgotpassword.js') !!} 
       
    </head>
    <body class="login-body">
        <div class="container form-signin">
            <?php //echo Session::get('message') ; /* <form class="form-signin" action="{{action('PartController@partList')}}"> */ ?>
            <div class="form-signin-heading text-center">
                <h1 class="sign-title">Reset Password</h1>
               |
                {!! HTML::image('images/login-logo.png', '') !!}
            </div>
            @if(Session::has('messagelogin'))
            <div class="alert alert-block alert-danger" style="display: block;">
                <button data-dismiss="alert" class="close close-sm" type="button">
                    <i class="fa fa-times"></i>
                </button>                
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('messagelogin') }}</p>
            </div>
            @endif
            <div>   
                {!! Form::open(array('url' => '/resetpassword','method'=>'POST','id'=>'frmResetPassword')) !!}
                {!! Form::hidden('id',Input::old('id',isset($userforgetdata['id']) ? $userforgetdata['id'] : '')) !!}
                {!! Form::hidden('email_token',Input::old('email_token',isset($userforgetdata['email_token']) ? $userforgetdata['email_token'] : '')) !!}
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="password" class="col-sm-4 control-label">Password:</label>
                        <div class="col-sm-8">                          
                            {!! Form::password('password',array('class'=>'form-control', 'placeholder' => 'New Password.')) !!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="repasseord" class="col-sm-4 control-label">Re-Type Password:</label>
                        <div class="col-sm-8">
                            {!! Form::password('repassword',array('class'=>'form-control', 'placeholder' => 'ReType New Password.')) !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-12" align='center'>              
                    <a href="{{ action('WelcomeController@index') }}" class="btn btn-default" style="color: #444444">Cancle</a>
                    {!! Form::submit('Submit',array('class'=>'btn btn-primary','id'=>'btnSubmit')) !!}   <br><br>             
                </div>
                {!! Form::close() !!}             
            </div>    
        </div>
       
         {!! HTML::script('js/bootstrap.min.js') !!} 
       
    </body>
</html>
