<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Honda Prima | Admin Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo e(asset('/admin-lte/bootstrap/css/bootstrap.min.css')); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Material Design -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css">
  <!-- Datatables -->
  <?php /* <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"> */ ?>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo e(asset('/admin-lte/plugins/datatables/extensions/TableTools/css/dataTables.tableTools.css')); ?>">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- typicons -->
  <link rel="stylesheet" type="text/css" href="<?php echo e(asset('/admin-lte/plugins/typicons.font/src/font/typicons.css')); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('/admin-lte/dist/css/AdminLTE.css')); ?>">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link rel="stylesheet" href="<?php echo e(asset('/admin-lte/dist/css/skins/skin-red-white.css')); ?>">
  <!-- include summernote css/js-->
  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
  <!-- date rang picker style -->
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

  <?php /* select2 */ ?>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

  <?php /* custom css */ ?>
  <link rel="stylesheet" type="text/css" href="<?php echo e(asset('/assets/css/admin.css')); ?>">


  <?php echo $__env->yieldContent('head'); ?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <?php echo $__env->yieldContent('styles'); ?>
  <style type="text/css">
    #picture-profile-memo{
      width: 60px;
      height: 60px;
    }
  </style>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-red-white fixed sidebar-mini sidebar-collapse">
<div class="wrapper">

  <?php echo $__env->make('partials.admin.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  
  <?php echo $__env->make('partials.admin.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php echo $__env->yieldContent('content-header'); ?>
    
    <!-- Main content -->
    <section class="content">
      <!-- Your Page Content Here -->
      <?php echo $__env->yieldContent('content'); ?>
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

  <?php echo $__env->make('partials.admin.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript::;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript::;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php echo $__env->make('partials.admin.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



<!-- REQUIRED JS SCRIPTS -->
<script src="<?php echo e(asset('/assets/js/admin.js')); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('/admin-lte/dist/js/app.min.js')); ?>"></script>
<!-- ChartJs -->
<script src="<?php echo e(asset('/admin-lte/plugins/chartjs/Chart.min.js')); ?>"></script>
<!-- Slimscroll -->
<script src="<?php echo e(asset('/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js')); ?>"></script>
<!-- Datatables -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<!-- Summernote -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>
<!-- dropzone -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.js"></script>
<?php /* socket io */ ?>
<script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
<?php /* date range picker */ ?>
<script src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<?php /* alert notif */ ?>
<script src="//cdn.jsdelivr.net/alertifyjs/1.7.1/alertify.min.js"></script>
<?php /* select2 */ ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<?php /* Knob.Js */ ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js"></script>

<?php /* nofity  */ ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.js"></script>

<?php echo $__env->yieldContent('scripts'); ?>
<?php /* CK Editor */ ?>
<script src="https://cdn.ckeditor.com/ckeditor5/1.0.0-alpha.2/classic/ckeditor.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<script type="text/javascript">
  getInboxCount();
  getInbox();
  function getInboxCount(){
    $.ajax({
      type: 'GET',
      url: '<?php echo e(url('api/memo/inbox/count/')); ?>/<?php echo e(Auth::id()); ?>',
      success: function(data){
                  $("#memo-inbox-header").text('You have '+data.count+' memo in Inbox');
                  $("#memo-inbox-count").text(data.count);
                  $("#memo-inbox-sidebar-count").text(data.count);
              }
    });
  }

  function getInbox() {
    $.ajax({
      type: 'Get',
      url: '<?php echo e(url('api/memo/inbox/')); ?>/<?php echo e(Auth::id()); ?>',
      success: function(response){
        $.each(response.data, function(key, value){
          // console.log(value.user_from.pictures[0].filename);
          var pic = value.user_from.pictures;
          if(pic != ''){
            var profile_picture = value.user_from.pictures[0].filename;
            $('#memo-inbox-list').append('<li ><a href="<?php echo e(url('memo/process/')); ?>/'+value.token+'/approve"><div class="pull-left"><img src="<?php echo e(url('hrd/employee/profile')); ?>/'+profile_picture+'" class="img-circle" alt="User Image"></div><h4>'+value.user_from.name+'</h4><p>'+value.no_memo+'</p><p>'+value.subject_memo+'</p></a></li>');
          }else{
            var profile_picture = '/admin-lte/dist/img/user2-160x160.jpg'
            $('#memo-inbox-list').append('<li ><a href="<?php echo e(url('memo/process/')); ?>/'+value.token+'/approve"><div class="pull-left"><img src="/admin-lte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"></div><h4>'+value.user_from.name+'</h4><p>'+value.no_memo+'</p><p>'+value.subject_memo+'</p></a></li>');
          }
        });
      }
    })
  }
</script>
</body>
</html>
