<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="ThemeBucket">
        <link rel="shortcut icon" href="#" type="image/png">

        <title>Forgot Password</title>

        <link href="css/style.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet">
        
        {!! HTML::script('js/scripts.js') !!} 
        {!! HTML::script('js/jquery/jquery.min.js') !!}
        {!! HTML::script('js/validation/jquery.validate.js') !!} 
        
        <script src="js/forgotpassword.js"></script>
    </head>
    <body class="login-body">
        <div class="container form-signin">
            <?php //echo Session::get('message') ; /* <form class="form-signin" action="{{action('PartController@partList')}}"> */ ?>
            <div class="form-signin-heading text-center">
                <h1 class="sign-title">Forgot Password</h1>
                <img src="images/login-logo.png" alt=""/>
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
                {!! Form::open(array('url' => '/forgotpassword','method'=>'POST','id'=>'frmForgotPassword')) !!}
                <p>Enter e-mail address to reset password :</p> 
                {!! Form::text('email','' ,array('class'=>'form-control', 'placeholder' => 'Email ID')) !!}
                <div class="modal-footer">                  
                    <a href="{{ action('WelcomeController@index') }}" class="btn btn-default" style="color: #444444">Cancle</a>
                    {!! Form::submit('Submit',array('class'=>'btn btn-primary','id'=>'btnSubmit')) !!}                          
                </div>
                {!! Form::close() !!}             
            </div>    
        </div>
        <script src="js/bootstrap.min.js"></script>  
    </body>
</html>
