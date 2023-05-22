<?php $__env->startSection('content-header'); ?>
  <section class="content-header">
    <h1>
      <i class="fa fa-bar-chart" aria-hidden="true"></i> Dashboard
      <small>Portal Honda Prima Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="/">Dashboard</a></li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
			<h4>Welcome, <?php echo e(auth()->user()->name); ?></h4>
          	<?php if(auth()->user()->pictures()->count() > 0): ?>
				<img src="<?php echo e(route('hrd.employee.profile.get', auth()->user()->pictures()->first()->filename)); ?>" class="img-circle" alt="User Image">
           	<?php else: ?>
           		<img src="/admin-lte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
           	<?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <!-- /.Table Rank -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>