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
        <div class="col-md-12">
          <span style="margin-left: 10px;"">
            <i class="fa fa-filter" aria-hidden="true"></i> Filter
            <?php echo Form::select('account_id', $journal, $journal_id, ['class'=>'btn btn-red', 'id'=>'journal_id']); ?>

            <?php echo Form::select('category_id', $category, $category_id, ['class'=>'btn btn-red', 'id'=>'category_id']); ?>

            <?php if(Gate::check('memo.super')): ?>
              <?php echo Form::select('branch_id', $branch, $branch_id, ['class'=>'btn btn-red', 'id'=>'branch_id']); ?>

              <?php echo Form::select('department_id', $department, $dept_id, ['class'=>'btn btn-red', 'id'=>'department_id']); ?>

            <?php else: ?>
              <?php echo Form::select('branch_id', $branch, $branch_id, ['class'=>'btn btn-red', 'id'=>'branch_id', 'disabled'=>'disabled']); ?>

              <?php echo Form::select('department_id', $department, $dept_id, ['class'=>'btn btn-red', 'id'=>'department_id','disabled'=>'disabled']); ?>

            <?php endif; ?>
          </span>
          <button type="button" class="btn btn-red" id="reportrange">
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
            <span>
              <?php if($begin): ?>
                <?php echo e($begin->format('M d, Y')); ?>

                -
                <?php echo e($end->format('M d, Y')); ?>

            <?php endif; ?>
            </span>
            <b class="caret"></b>
          </button>
        </div>

        <div class="col-md-4">
          <?php /* <input type="text" id="searchDtbox" class="form-control" placeholder="search..."> */ ?>
        </div>
      </div>
      <table class="table table-striped table-color">
        <thead>
          <th>No</th>
          <th>Memo No.</th>
          <th>Branch</th>
          <th>Notes</th>
          <th>Date</th>
          <th>Debet</th>
          <th>Credit</th>
          <th>Saldo</th>
        </thead>

        <tbody>
        <?php
          $no = 0;
          $saldo = 0;
          $debet = 0;
          $credit = 0;
        ?>
        <?php foreach($mt as $mTran): ?>
          <?php 
            $debet += $mTran->debet;
            $credit += $mTran->credit;
          ?>

          <tr>
            <td><?php echo e($no +=1); ?></td>
            <td>
              <?php if($mTran->memo()->count() > 0): ?>
                <a href="<?php echo e(route('memo.memo.show', $mTran->memo->token)); ?>">
                  <?php echo e($mTran->memo->no_memo); ?>

                </a>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
            <td><?php echo e($mTran->branch->name); ?></td>
            <td><?php echo e($mTran->notes); ?></td>
            <td><?php echo e(date('d/M/Y', strtotime($mTran->created_at))); ?></td>
            <?php if($no == 1 && $mTran->debet != 0): ?>
              <td><?php echo e(number_format($mTran->debet)); ?></td>
              <td><?php echo e(number_format($mTran->credit)); ?></td>  
              <td><?php echo e(number_format($saldo += $mTran->debet)); ?></td>
            <?php else: ?>
              <?php if($mTran->debet != 0): ?>
                <td><?php echo e(number_format($mTran->debet)); ?></td>
                <td><?php echo e(number_format($mTran->credit)); ?></td>  
                <td><?php echo e(number_format($saldo = $saldo + $mTran->debet)); ?></td>
              <?php else: ?>
                <td><?php echo e(number_format($mTran->debet)); ?></td>
                <td><?php echo e(number_format($mTran->credit)); ?></td>  
                <td><?php echo e(number_format($saldo = $saldo - $mTran->credit)); ?></td>
              <?php endif; ?>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
        </tbody>
        
        <tfoot>
          <tr style="text-align: left">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo e(number_format($debet)); ?></td>
            <td><?php echo e(number_format($credit)); ?></td>
            <td><?php echo e(number_format($debet - $credit)); ?></td>
          </tr>
        </tfoot>
      </table>
		</div>
	</div>

  <?php /* <?php echo $__env->make('memo.approval._modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> */ ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <?php echo $__env->make('memo.transaction._js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>