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
        <script src="js/forgotpassword.js"></script>


        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
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
            <div class="login-wrap">                

                {!! Form::open(array('url' => '/forgotpassword','method'=>'POST','id'=>'frmForgotPassword')) !!}
                <p>Enter your e-mail address below to reset your password.</p> 
<!--                <input type="text" class="form-control" name ='email' placeholder="Email ID" autofocus>-->
                {!! Form::text('email','' ,array('class'=>'form-control', 'placeholder' => 'Email ID')) !!}

                <div class="modal-footer">
                    <button class="btn btn-default" type="reset">Cancel</button>
                    {!! Form::submit('Submit',array('class'=>'btn btn-primary','id'=>'btnSubmit')) !!}                          
                </div>

                {!! Form::close() !!}
<!--                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="text" class="form-control" name ='email' placeholder="User ID" autofocus>
                <input type="password" class="form-control" name='password' placeholder="Password">
                <button class="btn btn-lg btn-login btn-block" type="submit">
                    <i class="fa fa-check"></i>
                </button>-->              
            </div>    
        </div>
        <!-- Placed js at the end of the document so the pages load faster -->

        <!-- Placed js at the end of the document so the pages load faster -->
        <script src="js/setActiveLink.js"></script>
        <script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/modernizr.min.js"></script>     

    </body>
</html>
