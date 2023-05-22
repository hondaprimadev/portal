<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">
        <?php 
            $no = '';
         ?>
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
        <?php echo Form::label('date', 'Date',['class'=>'col-sm-2 control-label']); ?>  
        <div class="col-sm-10">
          <?php echo Form::text('created_at', date('d F Y'), ['class'=> 'form-control', 'disabled'=>'disabled']); ?>

        </div>
      </div>

      <?php /* cek user authorization */ ?>
      <?php if(Gate::check('memo.super')): ?>
        <div class="form-group">
          <?php echo Form::label('company_id', 'Company', ['class'=>'col-sm-2 control-label']); ?>

          <div class="col-sm-10">
              <?php echo Form::select('company_id', $company, $company_id,['class'=> 'form-control','id'=>'company_id','disabled'=>'disabled']); ?>

          </div>
        </div>
        <div class="form-group">
          <?php echo Form::label('branch_id', 'Branch', ['class'=>'col-sm-2 control-label']); ?>

          <div class="col-sm-10">
            <?php echo Form::select('branch_id', $branch, $branch_id,['class'=> 'form-control','id'=>'branch_id','disabled'=>'disabled']); ?>

          </div>
        </div>
        <div class="form-group">
          <?php echo Form::label('department_id', 'Department', ['class'=>'col-sm-2 control-label']); ?>

          <div class="col-sm-10">
            <?php echo Form::select('department_id', $dept_user, $dept_id_user,['class'=>'form-control','id'=>'department_id', 'disabled'=>'disabled']); ?>

          </div>
        </div>
      <?php else: ?>
        <div class="form-group">
          <?php echo Form::label('company_id', 'Company', ['class'=>'col-sm-2 control-label']); ?>

          <div class="col-sm-10">
              <?php echo Form::select('company_id', $company, $company_id,['class'=> 'form-control','id'=>'company_id','disabled'=>'disabled']); ?>

          </div>
        </div>
        <div class="form-group">
          <?php echo Form::label('branch_id', 'Branch', ['class'=>'col-sm-2 control-label']); ?>

          <div class="col-sm-10">
            <?php echo Form::select('branch_id', $branch, $branch_id,['class'=> 'form-control','id'=>'branch_id','disabled'=>'disabled']); ?>

          </div>
        </div>
        <div class="form-group">
          <?php echo Form::label('department_id', 'Department', ['class'=>'col-sm-2 control-label']); ?>

          <div class="col-sm-10">
            <?php echo Form::select('department_id', $dept_user, $dept_id_user,['class'=>'form-control','id'=>'department_id', 'disabled'=>'disabled']); ?>

          </div>
        </div>
      <?php endif; ?>
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
      <div class="form-group has-feedback<?php echo e($errors->has('department_id_approval') ? ' has-error' : ''); ?>">
        <?php echo Form::label('department_id_approval', 'Department', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('department_id_approval', $depts, $dept_id,['class'=> 'form-control']); ?>

          <?php if($errors->has('department_id_approval')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('department_id_approval')); ?></strong>
                </span>
          <?php endif; ?>
        </div>
      </div>
      <div class="form-group has-feedback<?php echo e($errors->has('category_id') ? ' has-error' : ''); ?>">
        <?php echo Form::label('category_id', 'Category', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('category_id', $category,$category_id,['class'=> 'form-control']); ?>

          <?php if($errors->has('category_id')): ?>
            <span class="help-block">
                <strong><?php echo e($errors->first('category_id')); ?></strong>
            </span>
          <?php endif; ?>
        </div>
      </div>

      <div class="form-group has-feedback<?php echo e($errors->has('to_memo') ? ' has-error' : ''); ?>">
        <?php echo Form::label('to_memo', 'Approval', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('to_memo', $user_app,null,['class'=> 'form-control']); ?>

          <?php echo Form::hidden('approval_memo', $approval_path); ?>

          <?php if($errors->has('to_memo')): ?>
            <span class="help-block">
                <strong><?php echo e($errors->first('to_memo')); ?></strong>
            </span>
          <?php endif; ?>
        </div>
      </div>
      
      <?php if($budget): ?>
      <div class="form-group has-feedback<?php echo e($errors->has('budget') ? ' has-error' : ''); ?>">
        <?php echo Form::label('budget', 'Budget Outstanding', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('budget',number_format($saldo),['class'=> 'form-control','disabled'=>'disabled']); ?>

          <?php if($errors->has('budget')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('budget')); ?></strong>
                </span>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>

      <div class="form-group has-feedback<?php echo e($errors->has('subject_memo') ? ' has-error' : ''); ?>">
        <?php echo Form::label('subject_memo', 'Activity Name', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('subject_memo',old('subject_memo'),['class'=> 'form-control']); ?>

          <?php if($errors->has('subject_memo')): ?>
                <span class="help-block">
                    <strong><?php echo e($errors->first('subject_memo')); ?></strong>
                </span>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <?php if($memo_prepayment): ?>
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
    <?php if($memo->details->count() > 0): ?>
    <table class="table table-striped detail-table" id="tableDetail">
      <thead>
        <th>Date</th>
        <th>Description</th>
        <th>Qty</th>
        <th>Amount</th>
        <th>Sub Total</th>
        <th>
          <button type="button" class="btn btn-success btn-md" onclick=addrow()>
            <i class="fa fa-plus-circle"></i>
          </button>
        </th>
      </thead>
      <tbody>
          <?php foreach($memo->details as $d): ?>
            <?php $no += 100 ?>
            <tr>
              <td>
                <?php echo Form::input('date','date_detail[]', $d->date,['class'=> 'form-control date_detail detail-table','id'=>'date_detail'.$no, 'placeholder'=> 'Date']); ?>

                <?php echo Form::hidden('id_detail[]',$d->id, ['class'=>'detail-table id_detail']); ?>

              </td>
              <td>
                <?php echo Form::text('description[]', $d->description,['class'=> 'form-control detail-table description_detail', 'id'=>'description_detail'.$no,'placeholder'=> 'Description']); ?>

              </td>
              <td>
                <?php echo Form::text('qty[]', $d->qty,['class'=> 'form-control qty_detail detail-table','id'=>'qty_detail'.$no,'placeholder'=> 'qty']); ?>

              </td>
              <td>
                <?php echo Form::text('sub_total_memo[]', number_format($d->total), ['class'=>'form-control amount_detail detail-table','id'=>'amount_detail'.$no,"onkeyup"=>"number(this)", "onkeypress"=>"number(this)"]); ?>

              </td>
              <td>
                <?php echo Form::text('subtotal[]', number_format($d->qty * $d->total),['class'=> 'form-control total_detail detail-table','id'=>'total_detail'.$no,'disabled'=>'disabled']); ?>

              </td>
              <td>
                  <a href="#" class="del_rinc_edit"><i class="fa fa-times" style="color: red"></i></a>
                </td>
              </td>
            </tr>
          <?php endforeach; ?>
      </tbody>
    </table>
    <div class="col-md-6 pull-right" style="margin-top: 25px;">
      <div class="form-group">
        <?php echo Form::label('subject_memo', 'Total', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('all_total_detail', null, ['class'=>'form-control all_total_detail','id'=>'all_total_detail','disabled'=>'disabled']); ?>

          <?php if($errors->has('all_total_detail')): ?>
            <span class="help-block">
                <strong><?php echo e($errors->first('all_total_detail')); ?></strong>
            </span>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php else: ?>
      <?php echo $__env->make('memo._detaildefault', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
  </div>
</div>

<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Attachment</h3>
    <input type="text" class="dial" value="0" data-width="48" data-height="48" data-fgColor="#0788a5" data-bgColor="#3e4043" style="display: none;" />
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>

  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
          <button type="button" class="btn btn-success start upload-button">
            <i class="fa fa-upload" aria-hidden="true"></i> Upload
          </button>
          <hr>
      </div>
    </div>

    <?php /* Alert */ ?>
    <div class="row">
      <div class="col-md-6">
        <div class="alert alert-warning alert-dismissible alert-upload" role="alert" style="display: none;">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Warning!</strong> <span id="message-upload"></span>
        </div>
      </div>
    </div>

    <?php /* Upload List */ ?>
    <div class="row">
      <div class="col-md-12">
        <div id="UploadMemo">
          <ul class="list-inline">
          <?php /* Upload list file */ ?>
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
      <div class="form-group">
        <?php echo Form::label('supplier_type','Type',['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
        <?php echo Form::select('supplier_type', [''=>'--Supplier--','supplier'=>'Supplier','employee'=>'Employee'],null, ['class'=>'form-control','id'=>'supplier_type']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('supplier_id', 'Supplier', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('supplier_id', $supplier,$memo->supplier_id, ['class'=>'form-control','id'=>'supplier_id']); ?>

        </div>
      </div>
      <div id="get_supp"></div>
    </div>
  </div>
</div>

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
    <table class="table table-striped detail-table" id="tableFinance">
      <thead>
        <th>Leasing</th>
        <th>Total</th>
        <th>Notes</th>
        <th>
          <button type="button" class="btn btn-success btn-md" onclick=addRowFinance()>
            <i class="fa fa-plus-circle"></i>
          </button>
        </th>
      </thead>
      <tbody>
        <?php  $total_fin = 0;  ?>
        <?php if($memo->finances->count() > 0): ?>
          <?php foreach($memo->finances as $fin): ?>
            <?php 
              $no += 300; 
              $total_fin += $fin->total;
            ?>
            <tr>
              <td>
                <?php echo Form::select('group_leasing[]',$leasing, $fin->group_leasing,['class'=> 'form-control leasing_detail detail-table','id'=>'group_leasing'.$no]); ?>

                <?php echo Form::hidden('id_leasing[]', $fin->id, ['class'=>'detail-table id_finance']); ?>

              </td>
              <td>
                <?php echo Form::text('sub_total_finance[]', number_format($fin->total), ['class'=>'form-control total_finance_detail detail-table','id'=>'total'.$no,"onkeyup"=>"numberFinance(this)", "onkeypress"=>"numberFinance(this)"]); ?>

              </td>
              <td>
                <?php echo Form::text('notes[]', $fin->notes,['class'=>'form-control notes_detail detail-table', 'id'=>'notes'.$no]); ?>

              </td>
              <td>
                  <a href="#" class="del_fin"><i class="fa fa-times" style="color: red"></i></a>
                </td>
              </td>
            </tr>  
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td>
              <?php echo Form::select('group_leasing[]',$leasing, null,['class'=> 'form-control leasing_detail detail-table','id'=>'group_leasing']); ?>

            </td>
            <td>
              <?php echo Form::text('sub_total_finance[]', null, ['class'=>'form-control total_finance_detail detail-table','id'=>'total',"onkeyup"=>"numberFinance(this)", "onkeypress"=>"numberFinance(this)"]); ?>

            </td>
            <td>
              <?php echo Form::text('notes[]', null,['class'=>'form-control notes_detail detail-table', 'id'=>'notes']); ?>

            </td>
            <td>
                <a href="#" class="del_fin"><i class="fa fa-times" style="color: red"></i></a>
              </td>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
    <div class="col-md-6 pull-right" style="margin-top: 25px;">
      <div class="form-group">
        <?php echo Form::label('subject_memo', 'Total', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('total[]', number_format($total_fin), ['class'=>'form-control all_total_finance','id'=>'all_total_finance','disabled'=>'disabled']); ?>

        </div>
      </div>
    </div>
  </div>
</div>

<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Note</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>

  <div class="box-body">
    <div class="col-md-12">
      <div class="callout callout-success col-md-3">
        <h5><?php echo e($memo_sent->last()->to_memo); ?> | <?php echo e($memo_sent->last()->userTo->name); ?></h5>
        <p><?php echo e($memo_sent->last()->notes_memo); ?></p>
      </div>  
      <div class="form-group">
        <?php /* <?php echo Form::textarea('notes_memo',null, ['class'=>'form-control']); ?> */ ?>
        <textarea name="notes_memo" class="form-control" cols="50" rows="10"><?php echo e($memo_sent->first()->notes_memo); ?></textarea>
      </div>
    </div>
  </div>
</div>