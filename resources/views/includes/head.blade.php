<?php
/* <meta charset="UTF-8"> 
  <title>home</title>
  {!! HTML::style('css/bootstrap/bootstrap.min.css') !!}
  {!! HTML::script('js/jquery/jquery.min.js') !!}
  {!! HTML::script('js/part.js') !!}
  {!! HTML::script('js/validation/jquery.validate.js') !!}
  {!! HTML::script('js/datatable/jquery.dataTables.min.js') !!}
  {!! HTML::style('css/datatable/jquery.dataTables.min.css') !!}
  {!! HTML::script('js/bootstrap/bootstrap.min.js') !!}
 * 
 */
?>

<meta charset="utf-8">
<?php /* <meta name="_token" content="{{ csrf_token() }}" /> */ ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="description" content="">
<meta name="author" content="ThemeBucket">
<link rel="shortcut icon" href="#" type="image/png">

<title>
    @if(isset($page_title))
    {{$page_title}}
    @endif
</title>



   <!--{!! HTML::script('js/jquery-1.10.2.min.js') !!}-->
{!! HTML::script('js/jquery/jquery.min.js') !!}
{!! HTML::style('css/bootstrap-datepicker/css/datepicker-custom.css') !!}
{!! HTML::style('css/bootstrap-timepicker/css/timepicker.css') !!}
{!! HTML::style('css/bootstrap-daterangepicker/daterangepicker-bs3.css') !!}
{!! HTML::style('css/bootstrap-datetimepicker/css/datetimepicker-custom.css') !!}
{!! HTML::style('css/bootstrap-toggle-master/css/bootstrap-toggle.css') !!}

<!--dynamic table-->
  
{!! HTML::script('js/advanced-datatable/js/jquery.dataTables.js') !!}
{!! HTML::script('js/data-tables/DT_bootstrap.js') !!}

{!! HTML::script('js/bootstrap-toggle-master/js/bootstrap-toggle.js') !!}
{!! HTML::script('js/advanced-datatable/js/datatable-reordering.js') !!}
{!! HTML::style('js/advanced-datatable/css/demo_page.css') !!}
{!! HTML::style('js/advanced-datatable/css/demo_table.css') !!}
{!! HTML::style('js/data-tables/DT_bootstrap.css') !!}

{!! HTML::style('js/select2/select2-bootstrap.css') !!}
{!! HTML::style('js/select2/select2.css') !!}

{!! HTML::style('css/style.css') !!}
{!! HTML::style('css/style-responsive.css') !!}

{!! HTML::style('js/jquery-ui-1.11.3.custom/jquery-ui.css') !!}
{!! HTML::script('js/jquery-ui-1.11.3.custom/jquery-ui.js') !!}


<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->

{!! HTML::script('js/typeahead.bundle.js') !!}

<!--pickers css-->
<!--<link href="public/css/style.css" rel="stylesheet">
<link href="public/css/style-responsive.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker/css/datepicker-custom.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-timepicker/css/timepicker.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-daterangepicker/daterangepicker-bs3.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker/css/datetimepicker-custom.css" />

 
-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->


