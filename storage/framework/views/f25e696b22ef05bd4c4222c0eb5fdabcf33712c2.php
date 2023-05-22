
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Portal Honda Prima</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo e(asset('/admin-lte/bootstrap/css/bootstrap.min.css')); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('/admin-lte/dist/css/AdminLTE.min.css')); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo e(asset('/admin-lte/plugins/iCheck/square/blue.css')); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
    .login-page {
        padding-top: 0;
        background: #485563; /* fallback for old browsers */
      background: -webkit-linear-gradient(to left, #485563 , #29323c); /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to left, #485563 , #29323c); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */      
    }       
    .login-box-body{
        /*padding: 100px 50px 170px 50px;  */
        background-color: rgba(0,0,0,0);
    }
    .form-control{
        background-color: #fff;
        border: 1px solid #3F444A;
    }
    .form-control:focus{
        border: 1px solid #EB3349;
    }
    .btn-login{
        background-color: #EB3349;
        border: 1px solid #EB3349;
        color: #ffffff;
    }
    .btn-login:hover{
        background-color: rgba(0,0,0,0);
        color: #EB3349;
    }
    .login-header{
        font-size: 35px;
        margin-bottom: 25px;
        font-weight: 300;

    }
    .login-header a{
        color: #fff;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-header">
    <a href="/login" ">
        <b>Portal </b><span>HondaPrima</span>
    </a>
  </div>
  <span style="color: #7f8c8d;text-align:center;">Dear user, log in to access the admin area!</span>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/login')); ?>">
        <?php echo e(csrf_field()); ?>

        <div class="form-group has-feedback<?php echo e($errors->has('id') ? ' has-error' : ''); ?> ">
            <input type="Nik" name="id" class="form-control" placeholder="Nik" value="<?php echo e(old('id')); ?>">
            <?php if($errors->has('id')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('id')); ?></strong>
                </span>
            <?php endif; ?>
        </div>
        <div class="form-group has-feedback<?php echo e($errors->has('password') ? ' has-error' : ''); ?> ">
            <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo e(old('email')); ?>">
            <?php if($errors->has('password')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('password')); ?></strong>
                </span>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-login btn-block btn-flat">Sign In</button>
            </div>
            <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.0 -->
<script src="<?php echo e(asset('/admin-lte/plugins/jQuery/jQuery-2.2.0.min.js')); ?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo e(asset('/admin-lte/bootstrap/js/bootstrap.min.js')); ?>"></script>
<!-- iCheck -->
<script src="<?php echo e(asset('/admin-lte/plugins/iCheck/icheck.min.js')); ?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>