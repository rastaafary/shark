<!doctype html>
<!DOCTYPE html>
<html lang="en">
    <head>
        @include('includes.head')
    </head>
    <body class="sticky-header">
        <section>
            @include('includes.header')
            <!-- main content start-->
            <div class="main-content" >

                <!-- header section start-->
                <div class="header-section">

                    <!--toggle button start-->
                    <a class="toggle-btn toggle-btn-mobile"><i class="fa fa-bars"></i></a>
                    <!--toggle button end-->

                </div>
                <!-- header section end-->

                <!-- page heading start-->
                <div class="page-heading">

                    <h3>{{$name}}</h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="">Home</a>
                        </li>
                        <li class="active">New Customer</li>
                    </ul>
                </div>
                <!-- page heading end-->
                @yield('content')
                @include('includes.footer')
            </div>

        </section>

        <!-- Placed js at the end of the document so the pages load faster -->
        {!! HTML::script('js/jquery-1.10.2.min.js') !!}
        {!! HTML::script('js/jquery-ui-1.9.2.custom.min.js') !!}
        {!! HTML::script('js/jquery-migrate-1.2.1.min.js') !!}
        {!! HTML::script('js/bootstrap.min.js') !!}
        {!! HTML::script('js/modernizr.min.js') !!}
        {!! HTML::script('js/jquery.nicescroll.js') !!}

        <!--pickers plugins-->
        {!! HTML::script('js/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
        {!! HTML::script('js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') !!}
        {!! HTML::script('js/bootstrap-daterangepicker/moment.min.js') !!}
        {!! HTML::script('js/bootstrap-daterangepicker/daterangepicker.js') !!}
        {!! HTML::script('js/bootstrap-colorpicker/js/bootstrap-colorpicker.js') !!}
        {!! HTML::script('js/bootstrap-timepicker/js/bootstrap-timepicker.js') !!}

        <!--pickers initialization-->
        {!! HTML::script('js/pickers-init.js') !!}

        <!--common scripts for all pages-->
        {!! HTML::script('js/scripts.js') !!}
    </body>
</html>