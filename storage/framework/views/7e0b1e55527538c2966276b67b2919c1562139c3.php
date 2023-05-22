<?php $__env->startSection('head'); ?>
  <!-- dropzone css -->
  <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content-header'); ?>
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> Memo Revise
      <small>Memo Revise</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="/memo">Memo</a></li>
      <li class="active">Create</li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php echo Form::model($memo, array('route'=>['memo.revise.update',$memo->token], 'class'=>'form-horizontal', 'id'=>'formMemo' )); ?>

    <?php echo $__env->make('memo._editForm', ['edit'=>true], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="box-footer">
      <button type="submit" class="btn btn-success">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
      </button>
      <button type="button" class="btn btn-default" onclick="window.location='<?php echo e(url("/memo")); ?>';">Cancel</button>
    </div>
  <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <?php echo $__env->make('memo._js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <script type="text/javascript">
    getSupplier($('#supplier_type').val(), <?php echo e($memo->branch_id); ?>,<?php echo e($memo->supplier_id); ?>);
    getSupplierId(<?php echo e($memo->supplier_id); ?>, $('#supplier_type').val());
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>