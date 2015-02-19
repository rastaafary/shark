<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="ThemeBucket">
        <link rel="shortcut icon" href="#" type="image/png">

        <title>Login</title>

        <link href="css/style.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet">       
      

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
                <h1 class="sign-title">Sign In</h1>
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
                {!! HTML::ul($errors->all()) !!}
                {!! Form::open(array('url' => '/login','method'=>'POST','id'=>'login')) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="text" class="form-control" name ='email' placeholder="User ID" autofocus>
                <input type="password" class="form-control" name='password' placeholder="Password">
                <button class="btn btn-lg btn-login btn-block" type="submit">
                    <i class="fa fa-check"></i>
                </button> 
                {!! Form::close() !!}


                <div class="registration">

                </div>
                <label class="checkbox">
                    <!--<input type="checkbox" value="remember-me"> Remember me-->
                    <span class="pull-right">
                        <a data-toggle="modal" href="{{ action('LoginController@forgotPassword') }}"> Forgot Password?</a>

                    </span>
                </label>

            </div>

            <!-- Modal -->
<!--            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                
                <div class="modal-dialog">
                    {!! Form::open(array('url' => '/forgotpassword','method'=>'POST','id'=>'frmForgotPassword')) !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Forgot Password ?</h4>
                        </div>
                        <div class="modal-body">
                            <p>Enter your e-mail address below to reset your password.</p>                          
                            {!! Form::text('email','' ,array('class'=>'form-control', 'placeholder' => 'Email ID')) !!}
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="reset">Cancel</button>
                             {!! Form::submit('Submit',array('class'=>'btn btn-primary','id'=>'btnSubmit')) !!}                          
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>-->
            <!-- modal -->

            <?php /*      </form> */ ?>

        </div>



        <!-- Placed js at the end of the document so the pages load faster -->

        <!-- Placed js at the end of the document so the pages load faster -->
        <script src="js/setActiveLink.js"></script>
        <script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/modernizr.min.js"></script>     

    </body>
</html>
