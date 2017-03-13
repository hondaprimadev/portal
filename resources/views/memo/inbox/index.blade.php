@extends('layout.admin')

@section('content-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-user-secret" aria-hidden="true"></i> Memo 
      <small>Inbox Memo Approval</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('memo..index') }}">Memo</a></li>
      <li><a href="{{ route('memo..index') }}">Index</a></li>
    </ol>
  </section>
@stop

@section('content')
	<div class="box box-danger">
		<div class="box-header">
			<h3 class="box-title">
				Tables Memo Inbox
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
            <button type="button" class="btn btn-red" onclick="ApproveMemo()">
              <i class="fa fa-check-square" aria-hidden="true"></i> Approve
            </button>
            <button type="button" class="btn btn-red" onclick="ReviseMemo()">
              <i class="fa fa-reply" aria-hidden="true"></i> Revise
            </button>
            <button type="button" class="btn btn-red" onclick="RejectMemo()">
              <i class="fa fa-trash" aria-hidden="true"></i> Reject
            </button>

            <span style="margin-left: 10px;"">
              <i class="fa fa-filter" aria-hidden="true"></i> Filter
            </span>
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
        </div>

        <div class="col-md-4">
          <input type="text" id="searchDtbox" class="form-control" placeholder="search...">
        </div>
      </div>

			<table id="tableInbox" class="table table-striped table-color">
				<thead>
					<tr>
						<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
            <th>Memo No.</th>
            <th>From</th>
            <th>To</th>
            <th>Branch</th>
            <th>Subject</th>
            <th>Total</th>
            <th>Status</th>
            <th>Action</th>
					</tr>
				</thead>
				<tbody>
          @foreach ($memos as $memo)
            <tr>
              <td>
                  <input type="checkbox" id="idTableInbox" value="{{ $memo->id }}" name="id[]" class="checkin">
              </td>
              <td>{{ $memo->no_memo }}</td>
              <td>{{ $memo->userFrom->name }} | {{ $memo->from_memo }}</td>
              <td>{{ $memo->userTo->name }} | {{ $memo->to_memo }}</td>
              <td>{{ $memo->branch->name }}</td>
              <td>{{ $memo->subject_memo }}</td>
              <td>{{ number_format($memo->total_memo) }}</td>
              <td>{{ $memo->status_memo }}</td>
              <td>
                <a href="{{ route('memo.process.process', $memo->id) }}" class="btn btn-success">
                  <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Process
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
			</table>
		</div>
	</div>

  {{-- @include('memo.approval._modal') --}}
@stop

@section('scripts')
  {{-- @include('memo.approval._js') --}}
@stop