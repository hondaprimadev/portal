<?php $__env->startSection('content-header'); ?>
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> Profile
      <small>Profile edit</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="/profile/">Profile</a></li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php echo Form::model($user, ['class'=>'form-horizontal', 'id'=>'formEditEmployee', 'method'=>'PATCH', 'action'=>['DashboardController@postProfile', $user->token]]); ?>

    <?php echo $__env->make('dashboard.profile._form',['nikStat' => true], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="box-footer">
      <button type="submit" class="btn btn-success">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
      </button>
      <button type="submit" class="btn btn-default">Cancel</button>
    </div>
  </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <?php echo $__env->make('dashboard.profile._js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>