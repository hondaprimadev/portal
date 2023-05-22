<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">
      Memo Information - <b><?php echo e($memo->no_memo); ?></b>
      <?php echo Form::hidden('memo_no', $memo->no_memo); ?>

    </h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>

  <div class="box-body">
    <div class="col-md-6">
      <div class="form-group">
        <?php echo Form::label('from', 'From',['class'=>'col-sm-2 control-label']); ?>  
        <div class="col-sm-10">
          <?php echo Form::text('from_memo', $memo->userFrom->name, ['class'=> 'form-control', 'disabled'=>'disabled']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('date', 'Date',['class'=>'col-sm-2 control-label']); ?>  
        <div class="col-sm-10">
          <?php echo Form::text('created_at', date('d F Y'), ['class'=> 'form-control', 'disabled'=>'disabled']); ?>

        </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('company_id', 'Company', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('company_id', $company, null,['class'=> 'form-control','id'=>'company_id']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('branch_id', 'Branch', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('branch_id', $branch, null,['class'=> 'form-control','id'=>'branch_id']); ?>

        </div>
      </div>
    </div>
  </div>
</div>

<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Activity - Budget & Approval Information</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>

  <div class="box-body">
    <div class="col-md-6">
      <div class="form-group">
        <?php echo Form::label('subject_memo', 'Activity Name', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('subject_memo', $memo->subject_memo,['class'=> 'form-control','disabled'=>'disabled']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('department_id', 'Department', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('department_id', $depts,null,['class'=> 'form-control']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('category_id', 'Category', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('category_id', $category,null,['class'=> 'form-control']); ?>

        </div>
      </div>
      <?php if($stat != 'show'): ?>
      <div class="form-group">
        <?php echo Form::label('to_memo', 'Approval', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('to_memo', $user_app,null,['class'=> 'form-control']); ?>

          <?php /* <?php echo Form::hidden('approval_memo', ); ?> */ ?>
        </div>
      </div>
      <?php endif; ?>
      
      <?php /* <?php if($budget): ?>
      <div class="form-group">
        <?php echo Form::label('budget', 'Budget Outstanding', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('budget',$budget,['class'=> 'form-control','disabled'=>'disabled']); ?>

        </div>
      </div>
      <?php endif; ?> */ ?>
    </div>

    <div class="col-md-6">
      <?php if($memo->prepayment_no): ?>
        <div class="form-group has-feedback<?php echo e($errors->has('prepayment_no') ? ' has-error' : ''); ?>">
          <?php echo Form::label('prepayment_no', 'Prepayment No', ['class'=>'col-sm-2 control-label']); ?>

          <div class="col-sm-10">
            <?php echo Form::text('prepayment_no',$memo_prepayment->no_memo,['class'=> 'form-control','readonly']); ?>

            <?php if($errors->has('prepayment_no')): ?>
                  <span class="help-block">
                      <strong><?php echo e($errors->first('prepayment_no')); ?></strong>
                  </span>
            <?php endif; ?>
          </div>
        </div>

        <div class="form-group has-feedback<?php echo e($errors->has('prepayment_total') ? ' has-error' : ''); ?>">
          <?php echo Form::label('prepayment_total', 'Prepayment Total', ['class'=>'col-sm-2 control-label']); ?>

          <div class="col-sm-10">
            <?php echo Form::text('prepayment_total',number_format($memo_prepayment->prepayment_total),['class'=> 'form-control','readonly']); ?>

            <?php if($errors->has('prepayment_total')): ?>
                  <span class="help-block">
                      <strong><?php echo e($errors->first('prepayment_total')); ?></strong>
                  </span>
            <?php endif; ?>
          </div>
        </div>

        <div class="form-group has-feedback<?php echo e($errors->has('remaining') ? ' has-error' : ''); ?>">
          <?php echo Form::label('remaining', 'Remaining Total', ['class'=>'col-sm-2 control-label']); ?>

          <div class="col-sm-10">
            <?php echo Form::text('remaining',number_format($remaining),['class'=> 'form-control','readonly']); ?>

            <?php if($errors->has('remaining')): ?>
                  <span class="help-block">
                      <strong><?php echo e($errors->first('remaining')); ?></strong>
                  </span>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Detail Memo</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body">
    <?php if($memo->prepayment_total > 0): ?>
      <?php echo $__env->make('memo.inbox._detailPrepaymentTable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php else: ?>
      <?php echo $__env->make('memo.inbox._detailDefaultTable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
  </div>
</div>

<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Attachment</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>

  <div class="box-body">
    <?php /* Upload List */ ?>
    <div class="row">
      <div class="col-md-12">
        <div id="UploadMemo">
          <ul class="list-inline">
            <li class="upload-null" style="display: none;"><i>*No Attachment</i></li>
          </ul>
        </div>
      </div> 
    </div>
  </div>
</div>

<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Supplier</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>

  <div class="box-body">
    <div class="col-md-6">
      <table class="table">
      <?php if($memo->supplier_id != 0): ?>
        <?php if($memo->supplier_type == 'employee'): ?>
          <tr>
            <td><b>Name</b></td>
            <td><?php echo e($memo->supplierUser->name); ?></td>
          </tr>
          <tr>
            <td><b>Account No.</b></td>
            <td><?php echo e($memo->supplierUser->bank_account); ?></td>
          </tr>
          <tr>
            <td><b>Bank</b></td>
            <td><?php echo e($memo->supplierUser->bank_name); ?></td>
          </tr>
          <tr>
            <td><b>Branch</b></td>
            <td><?php echo e($memo->supplierUser->bank_branch); ?></td>
          </tr>
          <tr>
            <td><b>NPWP</b></td>
            <td><?php echo e($memo->supplierUser->npwp); ?></td>
          </tr>
        <?php else: ?>
	  <tr>
	    <td><b>Name:</b></td>
	    <td><?php echo e($memo->supplier ? $memo->supplier->name : null); ?></td>
	  </td>
          <tr>
            <td><b>Account Name</b></td>
            <td>
		<?php echo e($memo->supplier ? $memo->supplier->account_name : null); ?>

	    </td>
          </tr>
          <tr>
            <td><b>Account No.</b></td>
            <td><?php echo e($memo->supplier ? $memo->supplier->account_number : null); ?></td>
          </tr>
          <tr>
            <td><b>Bank</b></td>
            <td>
		<?php if($memo->supplier->bank): ?>
			<?php echo e($memo->supplier->bank->name); ?>

		<?php endif; ?>
	    </td>
          </tr>
          <tr>
            <td><b>Branch</b></td>
            <td>
		<?php echo e($memo->supplier ? $memo->supplier->bank_branch : null); ?>

	    </td>
          </tr>
          <tr>
            <td><b>NPWP</b></td>
            <td><?php echo e($memo->supplier ? $memo->supplier->npwp : null); ?></td>
          </tr>
        <?php endif; ?>
      <?php endif; ?>
      </table>
    </div>
  </div>
</div>

<?php if($memo->finances->count() > 0): ?>
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Support Leasing</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>

  <div class="box-body">
    <table class="table table-striped table-color detail-table" id="tableFinance">
      <thead>
        <th>Leasing</th>
        <th>Total</th>
        <th>Notes</th>
      </thead>
      <tbody>
        <?php $total_fin=0;?>
        <?php foreach($memo->finances as $fin): ?>
          <?php $total_fin += $fin->total;?>
          <tr>
            <td><?php echo e($fin->group_leasing); ?></td>
            <td><?php echo e(number_format($fin->total)); ?></td>
            <td><?php echo e($fin->notes); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td>Total</td>
          <td style="text-align: left;"><?php echo e(number_format($total_fin)); ?></td>
          <td></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<?php endif; ?>

<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Notes</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>

  <div class="box-body">
    <div class="col-md-12">
      <?php
	$fromMemo = null;
	$fromName = null;
      ?>
      <?php foreach($memo_sent as $key => $ms): ?>
        <?php if($key == 0): ?>
          <div class="callout callout-success col-md-3">
            <h5><?php echo e($ms->from_memo); ?> | <?php echo e($ms->userFrom ? $ms->userFrom->name : null); ?></h5>
            <p><?php echo e($ms->notes_memo); ?></p>
	   <?php $fromMemo = $ms->from_memo; $fromName = $ms->userFrom ? $ms->userFrom->name : null; ?>
          </div>
        <?php else: ?>
          <?php if($ms->last_approval_memo != 0): ?>
            <div class="callout callout-success col-md-3">
              <h5>
                <?php echo e($ms->last_approval_memo); ?> | <?php echo e(App\User::where('id', $ms->last_approval_memo)->first()->name); ?>

              </h5>
              <p><?php echo e($ms->notes_memo); ?></p>
            </div>
          <?php elseif($ms->last_revise_memo != 0): ?>
            <div class="callout callout-warning col-md-3">
              <h5>
                <?php echo e($ms->last_revise_memo); ?> | <?php echo e(App\User::where('id', $ms->last_revise_memo)->first()->name); ?>

              </h5>
              <p><?php echo e($ms->notes_memo); ?></p>
            </div>
	  <?php elseif($ms->last_revise_memo == "" || $ms->last_approve_memo == ""): ?>
	    <div class="callout callout-success col-md-3">
		<h5><?php echo e($fromMemo); ?> | <?php echo e($fromName); ?></h5>
                <p><?php echo e($ms->notes_memo); ?></p>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      <?php endforeach; ?>
      
      <?php if($stat == 'process'): ?>
        <div class="form-group">
          <textarea name="notes_memo" class="form-control" cols="50" rows="10"></textarea>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
