<?php $__env->startSection('content-header'); ?>
  <section class="content-header">
    <h1>
      <i class="fa fa-user-secret" aria-hidden="true"></i> Memo 
      <small>Inbox Memo </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('memo..index')); ?>">Memo</a></li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="box box-danger">
		<div class="box-header">
			<h3 class="box-title">
				Tables Memo
			</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse">
					<i class="fa fa-minus"></i>
				</button>
				<button type="button" class="btn btn-box-tool" data-widget="remove">
					<i class="fa fa-remove"></i>
				</button>
			</div>
		</div>

		<div class="box-body">
      <div class="col-md-12 box-body-header">  
        <div class="col-md-8">
          <?php if(Gate::check('memo.super')): ?>
            <?php echo Form::select('department_id', $department, $department_id, ['class'=>'btn btn-red pull-right', 'id'=>'department_id']); ?>

          <?php else: ?>
            <?php echo Form::select('department_id', $department, $department_id, ['class'=>'btn btn-red pull-right', 'id'=>'department_id','disabled'=>'disabled']); ?>

          <?php endif; ?>
          <?php echo Form::select('branch_id', $branch, $branch_id, ['class'=>'btn btn-red pull-right', 'id'=>'branch_id']); ?>

        </div>
        <div class="col-md-3">
          <input id="search-sent" type="text" class="form-control" placeholder="4 DIGIT NO MEMO">
        </div>
        <div class="col-md-1">
          <button type="button" class="btn btn-primary" id="search-memo">
            <i class="fa fa-search" aria-hidden="true"></i> Search
          </button>
        </div>
      </div>
      <table class="table table-striped table-color">
        <thead>
          <th>#</th>
          <th>Memo No.</th>
          <th>Memo Position</th>
          <th>Status</th>
          <th>Date</th>
          <th>Different</th>
        </thead>
        <tbody>
          <?php 
            $time ='';
            $no = '';
          ?>
          <?php foreach($memo_sent as $ms): ?>
            <?php 
              $no += 1;
            ?>
            <tr>
              <td><?php echo e($no); ?></td>
              <td><?php echo e($ms->no_memo); ?></td>
              <td><?php echo e($ms->to_memo); ?></td>
              <td><?php echo e($ms->status_memo); ?></td>
              <td><?php echo e(date('d/M/Y H:i:s', strtotime($ms->created_at))); ?></td>
              <td>
                <?php
                if ($no == 1) {
                  $time = $ms->created_at;
                  echo '-';
                }else{
                  $now = \Carbon\Carbon::createFromTimestamp(strtotime($ms->created_at));
                  $yesterday = \Carbon\Carbon::createFromTimestamp(strtotime($time));
                  $time = $ms->created_at;
                  echo $now->diffForHumans($yesterday);
                }
                ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
		</div>
	</div>

  <?php /* <?php echo $__env->make('memo.approval._modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> */ ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <?php /* <?php echo $__env->make('memo.transaction._js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> */ ?>
  <script type="text/javascript">
    $('#search-memo').click(function(){
      var branch = $('#branch_id').val();
      var department = $('#department_id').val();
      var no = $('#search-sent').val();
      var baseUrl = [location.protocol, '//', location.host, location.pathname].join('');
      window.location = baseUrl+'?branch='+branch+'&dept='+department+'&no='+no;
    });
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>