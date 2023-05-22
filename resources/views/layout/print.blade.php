<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('/admin-lte/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Material Design -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css">
  <!-- Datatables -->
  {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"> --}}
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('/admin-lte/plugins/datatables/extensions/TableTools/css/dataTables.tableTools.css') }}">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- typicons -->
  <link rel="stylesheet" type="text/css" href="{{ asset('/admin-lte/plugins/typicons.font/src/font/typicons.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/admin-lte/dist/css/AdminLTE.css') }}">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="{{ asset('/admin-lte/dist/css/skins/skin-red-white.css') }}">
  <!-- include summernote css/js-->
  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
  <!-- date rang picker style -->
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

  {{-- select2 --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

  @yield('head')

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
    .box-body-header{
      border: 1px solid #ccc;
      padding: 5px;
      background: #485563; /* fallback for old browsers */
      background: -webkit-linear-gradient(to left, #485563 , #29323c); /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to left, #485563 , #29323c); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */      
      color: white;
    }
    .table-color thead th{
      background: #16a085; /* fallback for old browsers */
      color: white;
    }
    .table-color tfoot td{
      background: #ddd;
      font-weight: bold;
    }
    .table-color tfoot{
      text-align: center;
    }
    .content-header-create{
      line-height: 10px;
      top: 51px;
      position: fixed;
      width: 100%;
      background-color: #fff;
      padding:10px;
      z-index: 999;
    }
    .content-create-form{
      padding-top: 300px;
      background-color: white;
      padding-top: 20px;
    }
    /*profile hrm*/
    .outer-div{
        height: 210px;
        width: 210px;
        background-color: #fff;
        border: 2px dashed #ccc;
        position: relative;
        border-radius: 10px;
    }
    .inner-div{
        height: 200px;
        width: 200px;
        background-color: #ccc;
        position: absolute;

        margin: -100px 0 0 -100px;
        left: 50%;
        top: 50%;
    }
    .outer-div-lg{
        height: 210px;
        background-color: #fff;
        border: 2px dashed #ccc;
        position: relative;
        border-radius: 10px;
    }
    .inner-div-lg{
        height: 200px;
        /*width: 100%;*/
        background-color: #fff;
        position: absolute;

        margin: -100px 0 0 -100px;
        left: 50%;
        top: 50%;
    }
    .progress{
        position: relative;
        top: 50%;
        z-index: 999;
        display: none;
    }
    .progress-bar{
        background-color: #5F3A74;
    }
    .btn-upload-profile{
        position: absolute;
        color: white;
        border:0;
        width: 40px;
        height: 40px;
        margin: -20px 0 0 -20px;
        left: 50%;
        top: 50%;
    }
    .btn-upload-profile:hover{
        background-color: rgba(0,0,0, 0.3);
    }
    .btn-delete-profile{
        display: none;
        position: absolute;
        top: -10px;
        right: -10px;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background-color: #5F3A74;
        color: white;
        border:0;
    }   
    .btn-delete-profile:hover{
        background-color: #7F6091;
    }
    /*end profile hrm*/
  </style>
</head>
<body>
<div class="wrapper">
  <div class="content-wrapper">
    <section class="content">
      @yield ('content')
    </section>

  </div>
</div>
</body>
</html>
