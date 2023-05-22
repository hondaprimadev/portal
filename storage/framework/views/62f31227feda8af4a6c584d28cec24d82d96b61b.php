<?php $__env->startSection('content-header'); ?>
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> HRD Management
      <small>Emplyoee / User Data Manajemen</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Hrd</a></li>
      <li><a href="<?php echo e(route('hrd.employee.index')); ?>">Employee</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php echo Form::model($user, ['class'=>'form-horizontal', 'id'=>'formEditEmployee', 'method'=>'PUT', 'action'=>['HrdEmployeeController@update', $user->id]]); ?>

    <?php echo $__env->make('hrd.employee._form',['nikStat' => false], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="box-footer">
      <button type="submit" class="btn btn-success">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> Update
      </button>
      <button type="submit" class="btn btn-default">Cancel</button>
    </div>
  <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <?php echo $__env->make('hrd.employee._js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>