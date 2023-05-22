<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">
      Memo Information - <b>{{ $memo->no_memo }}</b>
      {!! Form::hidden('memo_no', $memo->no_memo) !!}
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
        {!! Form::label('from', 'From',['class'=>'col-sm-2 control-label']) !!}  
        <div class="col-sm-10">
          {!! Form::text('from_memo', $memo->userFrom->name, ['class'=> 'form-control', 'disabled'=>'disabled']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('date', 'Date',['class'=>'col-sm-2 control-label']) !!}  
        <div class="col-sm-10">
          {!! Form::text('created_at', date('d F Y'), ['class'=> 'form-control', 'disabled'=>'disabled']) !!}
        </div>
      </div>

      <div class="form-group">
        {!! Form::label('company_id', 'Company', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('company_id', $company, null,['class'=> 'form-control','id'=>'company_id']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('branch_id', 'Branch', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('branch_id', $branch, null,['class'=> 'form-control','id'=>'branch_id']) !!}
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
        {!! Form::label('subject_memo', 'Activity Name', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('subject_memo', $memo->subject_memo,['class'=> 'form-control','disabled'=>'disabled']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('department_id', 'Department', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('department_id', $depts,null,['class'=> 'form-control']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('category_id', 'Category', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('category_id', $category,null,['class'=> 'form-control']) !!}
        </div>
      </div>
      @if ($stat != 'show')
      <div class="form-group">
        {!! Form::label('to_memo', 'Approval', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('to_memo', $user_app,null,['class'=> 'form-control']) !!}
          {{-- {!! Form::hidden('approval_memo', ) !!} --}}
        </div>
      </div>
      @endif
      
      {{-- @if ($budget)
      <div class="form-group">
        {!! Form::label('budget', 'Budget Outstanding', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('budget',$budget,['class'=> 'form-control','disabled'=>'disabled']) !!}
        </div>
      </div>
      @endif --}}
    </div>

    <div class="col-md-6">
      @if ($memo->prepayment_no)
        <div class="form-group has-feedback{{ $errors->has('prepayment_no') ? ' has-error' : '' }}">
          {!! Form::label('prepayment_no', 'Prepayment No', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {!! Form::text('prepayment_no',$memo_prepayment->no_memo,['class'=> 'form-control','readonly']) !!}
            @if ($errors->has('prepayment_no'))
                  <span class="help-block">
                      <strong>{{ $errors->first('prepayment_no') }}</strong>
                  </span>
            @endif
          </div>
        </div>

        <div class="form-group has-feedback{{ $errors->has('prepayment_total') ? ' has-error' : '' }}">
          {!! Form::label('prepayment_total', 'Prepayment Total', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {!! Form::text('prepayment_total',number_format($memo_prepayment->prepayment_total),['class'=> 'form-control','readonly']) !!}
            @if ($errors->has('prepayment_total'))
                  <span class="help-block">
                      <strong>{{ $errors->first('prepayment_total') }}</strong>
                  </span>
            @endif
          </div>
        </div>

        <div class="form-group has-feedback{{ $errors->has('remaining') ? ' has-error' : '' }}">
          {!! Form::label('remaining', 'Remaining Total', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {!! Form::text('remaining',number_format($remaining),['class'=> 'form-control','readonly']) !!}
            @if ($errors->has('remaining'))
                  <span class="help-block">
                      <strong>{{ $errors->first('remaining') }}</strong>
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
    <h3 class="box-title">Detail Memo</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body">
    @if ($memo->prepayment_total > 0)
      @include('memo.inbox._detailPrepaymentTable')
    @else
      @include('memo.inbox._detailDefaultTable')
    @endif
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
    {{-- Upload List --}}
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
      @if ($memo->supplier_id != 0)
        @if ($memo->supplier_type == 'employee')
          <tr>
            <td><b>Name</b></td>
            <td>{{ $memo->supplierUser->name }}</td>
          </tr>
          <tr>
            <td><b>Account No.</b></td>
            <td>{{ $memo->supplierUser->bank_account }}</td>
          </tr>
          <tr>
            <td><b>Bank</b></td>
            <td>{{ $memo->supplierUser->bank_name }}</td>
          </tr>
          <tr>
            <td><b>Branch</b></td>
            <td>{{ $memo->supplierUser->bank_branch }}</td>
          </tr>
          <tr>
            <td><b>NPWP</b></td>
            <td>{{ $memo->supplierUser->npwp }}</td>
          </tr>
        @else
	  <tr>
	    <td><b>Name:</b></td>
	    <td>{{ $memo->supplier ? $memo->supplier->name : null }}</td>
	  </td>
          <tr>
            <td><b>Account Name</b></td>
            <td>
		{{ $memo->supplier ? $memo->supplier->account_name : null }}
	    </td>
          </tr>
          <tr>
            <td><b>Account No.</b></td>
            <td>{{ $memo->supplier ? $memo->supplier->account_number : null }}</td>
          </tr>
          <tr>
            <td><b>Bank</b></td>
            <td>
		@if ($memo->supplier->bank)
			{{ $memo->supplier->bank->name }}
		@endif
	    </td>
          </tr>
          <tr>
            <td><b>Branch</b></td>
            <td>
		{{ $memo->supplier ? $memo->supplier->bank_branch : null }}
	    </td>
          </tr>
          <tr>
            <td><b>NPWP</b></td>
            <td>{{ $memo->supplier ? $memo->supplier->npwp : null }}</td>
          </tr>
        @endif
      @endif
      </table>
    </div>
  </div>
</div>

@if ($memo->finances->count() > 0)
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
        @foreach ($memo->finances as $fin)
          <?php $total_fin += $fin->total;?>
          <tr>
            <td>{{ $fin->group_leasing }}</td>
            <td>{{ number_format($fin->total) }}</td>
            <td>{{ $fin->notes }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td>Total</td>
          <td style="text-align: left;">{{ number_format($total_fin) }}</td>
          <td></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
@endif

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
      @foreach ($memo_sent as $key => $ms)
        @if ($key == 0)
          <div class="callout callout-success col-md-3">
            <h5>{{ $ms->from_memo }} | {{ $ms->userFrom ? $ms->userFrom->name : null }}</h5>
            <p>{{ $ms->notes_memo }}</p>
	   <?php $fromMemo = $ms->from_memo; $fromName = $ms->userFrom ? $ms->userFrom->name : null; ?>
          </div>
        @else
          @if ($ms->last_approval_memo != 0)
            <div class="callout callout-success col-md-3">
              <h5>
                {{ $ms->last_approval_memo }} | {{ App\User::where('id', $ms->last_approval_memo)->first()->name }}
              </h5>
              <p>{{ $ms->notes_memo }}</p>
            </div>
          @elseif($ms->last_revise_memo != 0)
            <div class="callout callout-warning col-md-3">
              <h5>
                {{ $ms->last_revise_memo }} | {{ App\User::where('id', $ms->last_revise_memo)->first()->name }}
              </h5>
              <p>{{ $ms->notes_memo }}</p>
            </div>
	  @elseif ($ms->last_revise_memo == "" || $ms->last_approve_memo == "")
	    <div class="callout callout-success col-md-3">
		<h5>{{ $fromMemo }} | {{ $fromName }}</h5>
                <p>{{ $ms->notes_memo }}</p>
            </div>
          @endif
        @endif
      @endforeach
      
      @if ($stat == 'process')
        <div class="form-group">
          <textarea name="notes_memo" class="form-control" cols="50" rows="10"></textarea>
        </div>
      @endif
    </div>
  </div>
</div>
