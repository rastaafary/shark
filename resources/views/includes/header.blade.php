<?php
/* <div class="masonry-row">
  <nav class="navbar navbar-default navbar-inverse" role="navigation">
  <div class="container-fluid">
  <div class="navbar-header">
  <a class="navbar-brand" href="#">Laravel demo</a>
  </div>
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  <ul class="nav navbar-nav navbar-right">
  <li>
  <a href="{{ action('PartController@partList') }}">Part Number</a>
  </li>
  <li>
  <a href="#/register">Create Account</a>
  </li>
  </ul>
  </div>
  </div>
  </nav>
  </div>
  @if(Session::has('message'))
  <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
  @endif
 */
?>
<!-- left side start-->
<div class="left-side sticky-left-side">

    <!--logo and iconic logo start-->
    <div class="logo">
        <a class="logo-img" href="index.html">{!! HTML::image('images/logo.png') !!}</a>

        <!--toggle button start-->
        <a class="toggle-btn"><i class="fa fa-bars"></i></a>
        <!--toggle button end-->
    </div>

    <div class="logo-icon text-center">
        <!--toggle button start-->
        <a class="toggle-btn"><i class="fa fa-bars"></i></a>
        <!--toggle button end-->
        <a href="index.html">{!! HTML::image('images/logo_icon.png') !!}</a>
    </div>
    <!--logo and iconic logo end-->

    <div class="left-side-inner">

        <!--sidebar nav start-->
        <ul class="nav nav-pills nav-stacked custom-nav">
            <li class="menu-list"><a href=""><i class="fa fa-home"></i> <span>Manage User</span></a>
                <ul class="sub-menu-list" style="display: none;">
                    <li><a href="{{action('ManageUserController@userList')}}"> User List</a></li>
                    <li><a href="{{action('ManageUserController@userProfile')}}"> Profile</a></li>
                </ul>
            </li>

            <li><a href="{{action('PartController@partList')}}"><i class="fa fa-user"></i> <span>Part Number</span></a></li>
            <li><a href="{{action('InvoiceController@listInvoice')}}"><i class="fa fa-bars"></i> <span>Invoice</span></a></li>
            <li><a href="{{action('PaymentController@listPayment')}}"><i class="fa fa-money"></i> <span>Payments</span></a></li>
            <li><a href="{{action('OrderStatusReportController@viewReport')}}"><i class="fa fa-bar-chart-o"></i> <span>PL's </span></a></li>
            <li><a href="{{action('PurchaseOrderCustomerController@listPurchaseOrder')}}"><i class="fa fa-user"></i> <span>PO Customers</span></a></li>
            <li><a href="{{action('CustomerController@listCust')}}"><i class="fa fa-users"></i> <span>Customers</span></a></li>
            <li><a href="{{action('WelcomeController@index')}}"><i class="fa fa-key"></i> <span>Log Out</span></a></li>
        </ul>
        <!--sidebar nav end-->

    </div>
</div>
<!-- left side end-->
