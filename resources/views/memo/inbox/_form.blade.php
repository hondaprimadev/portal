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

      <div class="form-group">
        {!! Form::label('to_memo', 'Approval', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('to_memo', $user_app,null,['class'=> 'form-control']) !!}
          {{-- {!! Form::hidden('approval_memo', ) !!} --}}
        </div>
      </div>
      
      {{-- @if ($budget)
      <div class="form-group">
        {!! Form::label('budget', 'Budget Outstanding', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('budget',$budget,['class'=> 'form-control','disabled'=>'disabled']) !!}
        </div>
      </div>
      @endif --}}
      
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
    <table class="table table-striped table-color detail-table" id="tableDetail">
      <thead>
        <th>Date</th>
        <th>Description</th>
        <th>Qty</th>
        <th>Amount</th>
        <th>Sub Total</th>
      </thead>
      <tbody>
        <?php $sum = 0;?>
        @foreach ($memo->details as $me)
          <tr>
            <td>{{ date('d/M/Y', strtotime($me->date)) }}</td>
            <td>{{ $me->description }}</td>
            <td>{{ $me->qty }}</td>
            <td>{{ number_format($me->total) }}</td>
            <td>{{ number_format($me->qty * $me->total) }}</td>
            <?php $sum += $me->qty * $me->total;?>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4">Total</td>
          <td style="text-align: left;">{{ number_format($sum) }}</td>
        </tr>
      </tfoot>
    </table>
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
        @if ($memo->supplier_type == 'employee')
          @if ($memo->supplierUser->count() > 0)
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
          @endif
        @else
          @if ($memo->supplier->count() > 0)
          <tr>
            <td><b>Name</b></td>
            <td>{{ $memo->supplier->account_name }}</td>
          </tr>
          <tr>
            <td><b>Account No.</b></td>
            <td>{{ $memo->supplier->account_number }}</td>
          </tr>
          <tr>
            <td><b>Bank</b></td>
            <td>{{ $memo->supplier->bank->name }}</td>
          </tr>
          <tr>
            <td><b>Branch</b></td>
            <td>{{ $memo->supplier->bank_branch }}</td>
          </tr>
          <tr>
            <td><b>NPWP</b></td>
            <td>{{ $memo->supplier->npwp }}</td>
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
      @foreach ($memo_sent as $key => $ms)
        @if ($key == 0)
          <div class="callout callout-success col-md-3">
            <h5>{{ $ms->from_memo }} | {{ $ms->userFrom->name }}</h5>
            <p>{{ $ms->notes_memo }}</p>
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