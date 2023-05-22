<?php $__env->startSection('content-header'); ?>
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> Memo
      <small>Memo approval budget</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Memo</a></li>
      <li class="active">Create</li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php echo Form::model($memo = new \App\Memo, ['route'=>'memo.prepayment.store','class'=>'form-horizontal','id'=>'formMemo']); ?>

    <?php echo $__env->make('memo._form', ['edit'=>false,'prepayment'=>true], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="box-footer">
      <button type="submit" class="btn btn-success">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
      </button>
      <button type="button" class="btn btn-default">Cancel</button>
    </div>
  </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <?php echo $__env->make('memo._js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>