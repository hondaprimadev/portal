<?php $__env->startSection('content-header'); ?>
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> Supplier
      <small>Create Supplier</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Supplier</a></li>
      <li class="active">Create</li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php echo Form::model($supplier = new \App\Supplier, ['route'=>'supplier.store','class'=>'form-horizontal']); ?>

    <?php echo $__env->make('supplier._form',['editSupplier'=>false], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="box-footer">
      <button type="submit" class="btn btn-success">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
      </button>
      <button type="submit" class="btn btn-default">Cancel</button>
    </div>
  </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <?php echo $__env->make('supplier._js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>