<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">
        Memo Information - <b>{{ $memo->ofMaxno($branch_id, $company_id, $dept_id_user) }}</b>
        {!! Form::hidden('memo_no', $memo->ofMaxno($branch_id, $company_id, $dept_id_user)) !!}  
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
        {!! Form::label('date', 'Date',['class'=>'col-sm-2 control-label']) !!}  
        <div class="col-sm-10">
          {!! Form::text('created_at', date('d F Y'), ['class'=> 'form-control', 'disabled'=>'disabled']) !!}
        </div>
      </div>

      {{-- cek user authorization --}}
      @if (Gate::check('memo.super'))
        <div class="form-group">
          {!! Form::label('company_id', 'Company', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
              {!! Form::select('company_id', $company, $company_id,['class'=> 'form-control','id'=>'company_id']) !!}
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('branch_id', 'Branch', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {!! Form::select('branch_id', $branch, $branch_id,['class'=> 'form-control','id'=>'branch_id']) !!}
          </div>
        </div>
        <div class="form-group has-feedback{{ $errors->has('department_id') ? ' has-error' : '' }}">
        {!! Form::label('department_id', 'Department', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          @if ($branch_id == 100)
            {!! Form::select('department_id', $dept_user, $dept_id_user,['class'=> 'form-control','id'=>'department_id','disabled'=>'disabled']) !!}
          @else
            {!! Form::select('department_id', $dept_user, $dept_id_user,['class'=> 'form-control','id'=>'department_id']) !!}
          @endif
          @if ($errors->has('department_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('department_id') }}</strong>
                </span>
          @endif
        </div>
      @else
        <div class="form-group">
          {!! Form::label('company_id', 'Company', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
              {!! Form::select('company_id', $company, $company_id,['class'=> 'form-control','id'=>'company_id','disabled'=>'disabled']) !!}
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('branch_id', 'Branch', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {!! Form::select('branch_id', $branch, $branch_id,['class'=> 'form-control','id'=>'branch_id','disabled'=>'disabled']) !!}
          </div>
        </div>
        <div class="form-group has-feedback{{ $errors->has('department_id') ? ' has-error' : '' }}">
        {!! Form::label('department_id', 'Department', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('department_id', $depts, $dept_id,['class'=> 'form-control','disabled'=>'disabled']) !!}
          @if ($errors->has('department_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('department_id') }}</strong>
                </span>
          @endif
        </div>
      </div>
      @endif
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
      <div class="form-group has-feedback{{ $errors->has('department_id_approval') ? ' has-error' : '' }}">
        {!! Form::label('department_id_approval', 'Department', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('department_id_approval', $depts, $dept_id,['class'=> 'form-control']) !!}
          @if ($errors->has('department_id_approval'))
                <span class="help-block">
                    <strong>{{ $errors->first('department_id_approval') }}</strong>
                </span>
          @endif
        </div>
      </div>
      <div class="form-group has-feedback{{ $errors->has('category_id') ? ' has-error' : '' }}">
        {!! Form::label('category_id', 'Category', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('category_id', $category,$category_id,['class'=> 'form-control']) !!}
          @if ($errors->has('category_id'))
            <span class="help-block">
                <strong>{{ $errors->first('category_id') }}</strong>
            </span>
          @endif
        </div>
      </div>

      <div class="form-group has-feedback{{ $errors->has('to_memo') ? ' has-error' : '' }}">
        {!! Form::label('to_memo', 'Approval', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('to_memo', $user_app,null,['class'=> 'form-control']) !!}
          {!! Form::hidden('approval_memo', $approval_path) !!}
          @if ($errors->has('to_memo'))
            <span class="help-block">
                <strong>{{ $errors->first('to_memo') }}</strong>
            </span>
          @endif
        </div>
      </div>
      
      @if ($budget)
      <div class="form-group has-feedback{{ $errors->has('budget') ? ' has-error' : '' }}">
        {!! Form::label('budget', 'Budget Outstanding', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('budget',number_format($saldo),['class'=> 'form-control','disabled'=>'disabled']) !!}
          @if ($errors->has('budget'))
                <span class="help-block">
                    <strong>{{ $errors->first('budget') }}</strong>
                </span>
          @endif
        </div>
      </div>
      @endif

      <div class="form-group has-feedback{{ $errors->has('subject_memo') ? ' has-error' : '' }}">
        {!! Form::label('subject_memo', 'Activity Name', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('subject_memo',old('subject_memo'),['class'=> 'form-control']) !!}
          @if ($errors->has('subject_memo'))
                <span class="help-block">
                    <strong>{{ $errors->first('subject_memo') }}</strong>
                </span>
          @endif
        </div>
      </div>
      
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
    @if ($prepayment)
      @include('memo._detailprepayment')
    @else
      @include('memo._detaildefault')
    @endif

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
          <button type="button" class="btn btn-primary start upload-button">
            <i class="fa fa-upload" aria-hidden="true"></i> Upload
          </button>
          <hr>
      </div>
    </div>

    {{-- Alert --}}
    <div class="row">
      <div class="col-md-6">
        <div class="alert alert-warning alert-dismissible alert-upload" role="alert" style="display: none;">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Warning!</strong> <span id="message-upload"></span>
        </div>
      </div>
    </div>

    {{-- Upload List --}}
    <div class="row">
      <div class="col-md-6">
        <div id="UploadMemo">
          <ul class="list-inline">
          {{-- Upload list file --}}
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
        {!! Form::label('supplier_type','Type',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
        {!! Form::select('supplier_type', [''=>'--Supplier--','supplier'=>'Supplier','employee'=>'Employee'],null, ['class'=>'form-control','id'=>'supplier_type']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('supplier_id', 'Supplier', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('supplier_id', $supplier,null, ['class'=>'form-control','id'=>'supplier_id']) !!}
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
        <tr>
          <td>
            {!! Form::select('group_leasing[]',$leasing, null,['class'=> 'form-control leasing_detail detail-table','id'=>'group_leasing']) !!}
          </td>
          <td>
            {!! Form::text('sub_total_finance[]', null, ['class'=>'form-control total_finance_detail detail-table','id'=>'total',"onkeyup"=>"numberFinance(this)", "onkeypress"=>"numberFinance(this)"]) !!}
          </td>
          <td>
            {!! Form::text('notes[]', null,['class'=>'form-control notes_detail detail-table', 'id'=>'notes']) !!}
          </td>
          <td>
              <a href="#" class="del_fin"><i class="fa fa-times" style="color: red"></i></a>
            </td>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="col-md-6 pull-right" style="margin-top: 25px;">
      <div class="form-group">
        {!! Form::label('subject_memo', 'Total', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('total[]', null, ['class'=>'form-control all_total_finance','id'=>'all_total_finance']) !!}
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
      <div class="form-group">
        <textarea name="notes_memo" class="form-control" cols="50" rows="10">{{ old('notes_memo') }}</textarea>
      </div>
    </div>
  </div>
</div>