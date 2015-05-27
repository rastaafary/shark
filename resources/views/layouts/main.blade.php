<!DOCTYPE html>
<html lang="en">
    <head>
        @include('includes.head')
        <script type="text/javascript">
            var baseURL = "{!!url('/')!!}";            
        </script>    
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
                @if(Session::has('message'))
                    @if(Session::get('status') == 'success')
                        <div class="alert alert-block alert-success" style="display: block;">
                            <span class="alert alert-success">{{ Session::get('message') }}</span>
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
                            </button>                    
                        </div>
                    @else
                        <div class="alert alert-block alert-danger" style="display: block;">
                            <span class="alert alert-danger">{{ Session::get('message') }}</span>
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
                            </button>                    
                        </div>
                    @endif
                @endif
                <!-- page heading start-->
                <div class="page-heading">
                    <h3>
                        @if(isset($page_title))
                        {{$page_title}}
                        @endif
                    </h3>
                    <ul class="breadcrumb">
                        <li>
                            <a href="">Home</a>
                        </li>
                        <li class="active">  
                            @if(isset($page_title))
                            {{$page_title}}
                            @endif
                        </li>
                    </ul>
                </div>
                <!-- page heading end-->
                @yield('content')
                @include('includes.footer')
            </div>

        </section>

        <!-- Placed js at the end of the document so the pages load faster -->

       <?php /* {!! HTML::script('js/jquery/jquery.min.js') !!} */ ?>
        {!! HTML::script('js/validation/jquery.validate.js') !!}
        {!! HTML::script('http://jqueryvalidation.org/files/dist/additional-methods.min.js') !!}
     
<!--        {!! HTML::script('js/jquery-ui-1.9.2.custom.min.js') !!}-->
        {!! HTML::script('js/jquery.tmpl.js') !!}
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
        
        <!--select2 plugins-->
        {!! HTML::script('js/select2/select2.js') !!}
        <!--pickers initialization-->
        {!! HTML::script('js/pickers-init.js') !!}

        <!--dynamic table-->
      <?php /*  {!! HTML::script('js/advanced-datatable/js/jquery.dataTables.js') !!}
        {!! HTML::script('js/data-tables/DT_bootstrap.js') !!} */ ?>
        <!--dynamic table initialization -->
        {!! HTML::script('js/dynamic_table_init.js') !!}       

        <!--common scripts for all pages-->
        {!! HTML::script('js/scripts.js') !!}
    </body>
</html>
