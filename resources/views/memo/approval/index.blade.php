@extends('layout.admin')

@section('content-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-user-secret" aria-hidden="true"></i> Memo Setting
      <small>Setting Memo Approval</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('memo..index') }}">Memo</a></li>
      <li class="active"><a href="{{ route('memo.approval.index') }}">Appproval</a></li>
    </ol>
  </section>
@stop

@section('content')
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
                <button type="button" class="btn btn-red" onclick="DeleteSetting()">
                  <i class="fa fa-trash" aria-hidden="true"></i> Delete
                </button>

                <span style="margin-left: 10px;"">
                  <i class="fa fa-filter" aria-hidden="true"></i> Filter
                  {!! Form::select('branch_id', $branch, $bid, ['class'=>'btn btn-red', 'id'=>'branch_id']) !!}
                  {!! Form::select('budget', [''=>'No Budget','1'=>'Budget'], $budget, ['class'=>'btn btn-red', 'id'=>'budget']) !!}
                </span>

                @if ($budget)
                <button type="button" class="btn btn-red" id="reportrange">
                  <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                  <span>
                    @if ($begin)
                      {{ $begin->format('M d, Y') }}
                      -
                      {{  $end->format('M d, Y') }}
                    @endif  
                  </span>
                  <b class="caret"></b>
                </button>
                @endif
                
            </div>

            <div class="col-md-4">
              <input type="text" id="searchDtbox" class="form-control" placeholder="search...">
            </div>
          </div>

			{!! Form::open(['url'=>'/memo/approval/delete','id'=>'formHrdDelete']) !!}
				<table id="tableUser" class="table table-striped table-color">
					<thead>
						<tr>
							<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
              <th>Category</th>
              <th>Approval</th>
              <th>Branch</th>
              <th>User</th>
              @if ($budget > 0)
                <th>Budget</th>
                <th>Saldo</th>
                <th>Date1</th>
                <th>Date2</th>
              @endif
              <th>Prepayment</th>
              <th>Action</th>
						</tr>
					</thead>
					<tbody>
            @foreach ($memos as $memo)
              <tr>
                <td>
                    <input type="checkbox" id="idTableApproval" value="{{ $memo->id }}" name="id[]" class="checkin">
                </td>
                <td>
                    {{ $memo->category->name }}
                    <input type="hidden" id="categoryTableApproval" value="{{ $memo->category_id }}">
                </td>
                <td>
                  {{ $memo->approval_path }}
                  <input type="hidden" id="pathTableApproval" value="{{ $memo->approval_path }}">
                </td>
                <td>
                  {{ $memo->branch->name }}
                  <input type="hidden" id="branchTableApproval" value="{{ $memo->branch_id }}">
                </td>
                <td>
                  {{ $memo->user_approval }} | {{ $memo->position->name }}
                  <input type="hidden" id="userTableApproval" value="{{ $memo->user_approval }}">
                </td>
                
                @if ($budget)
                <td>
                  {{ to_currency($memo->budget_total,',') }}
                  <input type="hidden" id="budgetTableApproval" value="{{ $memo->budget }}">
                  <input type="hidden" id="budgetTotalTableApproval" value="{{ $memo->budget_total }}">
                </td> 
                <td>Saldo</td>
                <td>
                  {{ $memo->inv_date1 }}
                  <input type="hidden" id="date1TableApproval" value="{{ $memo->inv_date1 }}">
                </td>
                <td>
                  {{ $memo->inv_date2 }}
                  <input type="hidden" id="date2TableApproval" value="{{ $memo->inv_date2 }}">
                </td>
                @endif

                <td>
                  @if ($memo->prepayment >0)
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                  @else
                    <i class="fa fa-times" aria-hidden="true"></i>
                  @endif
                  <input type="hidden" id="prepaymentTableApproval" value="{{ $memo->prepayment }}">
                </td>
                @if ($budget)
                <td> 
                  <button type="button" id="addBudget" class="btn btn-success">
                    <i class="fa fa-plus-square" aria-hidden="true" ></i>
                  </button>
                </td>
                @else
                <td></td>
                @endif
              </tr>
            @endforeach
          </tbody>
				</table>
			{!! Form::close() !!}
		</div>
	</div>

  @include('memo.approval._modal')
@stop

@section('scripts')
  @include('memo.approval._js')
@stop