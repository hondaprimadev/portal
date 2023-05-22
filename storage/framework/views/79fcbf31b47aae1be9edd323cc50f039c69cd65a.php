<?php $__env->startSection('content-header'); ?>
  <section class="content-header">
    <h1>
      <i class="fa fa-user-secret" aria-hidden="true"></i> Memo Setting
      <small>Setting Memo Approval</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('memo..index')); ?>">Memo</a></li>
      <li class="active"><a href="<?php echo e(route('memo.approval.index')); ?>">Appproval</a></li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="box box-danger">
		<div class="box-header">
			<h3 class="box-title">
				Tables Memo Setting
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
                <button type="button" class="btn btn-red" onclick="addSetting()">
                  <i class="fa fa-plus" aria-hidden="true"></i> New
                </button>
                <button type="button" class="btn btn-red" onclick="deleteApproval()">
                  <i class="fa fa-trash" aria-hidden="true"></i> Delete
                </button>

                <span style="margin-left: 10px;"">
                  <i class="fa fa-filter" aria-hidden="true"></i> Filter
                  <?php echo Form::select('branch_id', $branch, $bid, ['class'=>'btn btn-red', 'id'=>'branch_id']); ?>

                  <?php echo Form::select('budget', [''=>'No Budget','1'=>'Budget'], $budget, ['class'=>'btn btn-red', 'id'=>'budget']); ?>

                </span>

                <?php if($budget): ?>
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
                <?php endif; ?>
                
            </div>

            <div class="col-md-4">
              <input type="text" id="searchDtbox" class="form-control" placeholder="search...">
            </div>
          </div>

			<?php echo Form::open(['route'=>'memo.approval.delete','id'=>'formApprovalDelete']); ?>

				<table id="tableUser" class="table table-striped table-color">
					<thead>
						<tr>
							<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
              <th>Category</th>
              <th>Approval</th>
              <th>Branch</th>
              <th>User</th>
              <?php if($budget > 0): ?>
                <th>Budget</th>
                <th>Saldo</th>
                <th>Date1</th>
                <th>Date2</th>
              <?php endif; ?>
              <th>Prepayment</th>
              <th>Action</th>
						</tr>
					</thead>
					<tbody>
            <?php foreach($memos as $memo): ?>
              <tr>
                <td>
                    <input type="checkbox" id="idTableApproval" value="<?php echo e($memo->id); ?>" name="id[]" class="checkin">
                </td>
                <td>
                    <?php echo e($memo->category->name); ?>

                    <input type="hidden" id="categoryTableApproval" value="<?php echo e($memo->category_id); ?>">
                </td>
                <td>
                  <?php echo e($memo->approval_path); ?>

                  <input type="hidden" id="pathTableApproval" value="<?php echo e($memo->approval_path); ?>">
                </td>
                <td>
                  <?php echo e($memo->branch->name); ?>

                  <input type="hidden" id="branchTableApproval" value="<?php echo e($memo->branch_id); ?>">
                </td>
                <td>
                  <?php echo e($memo->user_approval); ?> | <?php echo e($memo->position->name); ?>

                  <input type="hidden" id="userTableApproval" value="<?php echo e($memo->user_approval); ?>">
                </td>
                
                <?php if($budget): ?>
                <td>
                  <?php echo e(to_currency($memo->budget_total,',')); ?>

                  <input type="hidden" id="budgetTableApproval" value="<?php echo e($memo->budget); ?>">
                  <input type="hidden" id="budgetTotalTableApproval" value="<?php echo e($memo->budget_total); ?>">
                </td> 
                <td>Saldo</td>
                <td>
                  <?php echo e($memo->inv_date1); ?>

                  <input type="hidden" id="date1TableApproval" value="<?php echo e($memo->inv_date1); ?>">
                </td>
                <td>
                  <?php echo e($memo->inv_date2); ?>

                  <input type="hidden" id="date2TableApproval" value="<?php echo e($memo->inv_date2); ?>">
                </td>
                <?php endif; ?>

                <td>
                  <?php if($memo->prepayment >0): ?>
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                  <?php else: ?>
                    <i class="fa fa-times" aria-hidden="true"></i>
                  <?php endif; ?>
                  <input type="hidden" id="prepaymentTableApproval" value="<?php echo e($memo->prepayment); ?>">
                </td>
                <?php if($budget): ?>
                <td> 
                  <button type="button" id="addBudget" class="btn btn-success">
                    <i class="fa fa-plus-square" aria-hidden="true" ></i>
                  </button>
                </td>
                <?php else: ?>
                <td></td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
				</table>
			<?php echo Form::close(); ?>

		</div>
	</div>

  <?php echo $__env->make('memo.approval._modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <?php echo $__env->make('memo.approval._js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>