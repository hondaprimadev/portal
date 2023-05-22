<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">
      <?php if($editSupplier): ?>
        Supplier <b><?php echo e($supplier->no_supplier); ?></b>
        <?php $branch_id = $supplier->branch_id; ?>
      <?php else: ?>
        Supplier <b><?php echo e($supplier->ofMaxno($branch_id, $category_id)); ?></b>
      <?php endif; ?>
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
        <?php echo Form::label('branch_id', 'Branch', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php if($editSupplier): ?>
            <?php echo Form::select('branch_id', $branch, $branch_id,['class'=> 'form-control','id'=>'branch_id', 'disabled'=>'disabled']); ?>

          <?php else: ?>
            <?php echo Form::select('branch_id', $branch, $branch_id,['class'=> 'form-control','id'=>'branch_id']); ?>

          <?php endif; ?>
        </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('category_id', 'Category', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('category_id', $category, $category_id, ['class'=>'form-control','id'=>'category_id']); ?>

        </div>
      </div>

      <?php if($editSupplier): ?>
      <div class="form-group">
        <?php echo Form::label('active', 'Active', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('active', ['1'=>'Active','0'=>'Deactive'], null, ['class'=>'form-control']); ?>

        </div>
      </div>
      <?php endif; ?>

    </div>
  </div>
</div>

<?php /* Data Supplier */ ?>
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">
      Data Supplier
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
        <?php echo Form::label('name', 'Name', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('name', old('name'),['class'=> 'form-control']); ?>

        </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('npwp', 'NPWP', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('npwp', old('npwp'),['class'=> 'form-control']); ?>

        </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('pkp', 'PKP', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('pkp', old('pkp'),['class'=> 'form-control']); ?>

        </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('address', 'Address', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('address', old('address'),['class'=> 'form-control']); ?>

        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <?php echo Form::label('business_field', 'Bussiness Field', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('business_field', old('business_field'),['class'=> 'form-control']); ?>

        </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('phone', 'Phone', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('phone', old('phone'),['class'=> 'form-control']); ?>

        </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('fax', 'Fax', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('fax', old('fax'),['class'=> 'form-control']); ?>

        </div>
      </div>
    </div>
  </div>
</div>
<?php /* Data Supplier end */ ?>

<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">
      Data PIC
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
        <?php echo Form::label('name_pic', 'Name PIC', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('name_pic', old('name_pic'),['class'=> 'form-control']); ?>

        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <?php echo Form::label('phone_pic', 'Phone PIC', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('phone_pic', old('phone_pic'),['class'=> 'form-control']); ?>

        </div>
      </div>
    </div>
  </div>
</div>

<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">
      Data BANK Account
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
        <?php echo Form::label('account_number', 'Account No.', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('account_number', old('account_number'),['class'=> 'form-control']); ?>

        </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('account_name', 'Account Name', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('account_name', old('account_name'),['class'=> 'form-control']); ?>

        </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('bank_id', 'Bank Name', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('bank_id',$bank, old('bank_id'),['class'=> 'form-control']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('bank_branch', 'Bank Branch', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('bank_branch', old('bank_branch'),['class'=> 'form-control']); ?>

        </div>
      </div>
    </div>
  </div>
</div>