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
            @can('memo.super')
              {{-- <button type="button" class="btn btn-red" onclick="ApproveMemo()">
                <i class="fa fa-check-square" aria-hidden="true"></i> Approve
              </button>
              <button type="button" class="btn btn-red" onclick="ReviseMemo()">
                <i class="fa fa-reply" aria-hidden="true"></i> Revise
              </button>
              <button type="button" class="btn btn-red" onclick="RejectMemo()">
                <i class="fa fa-trash" aria-hidden="true"></i> Reject
              </button> --}}
            @endcan
        </div>

        <div class="col-md-4">
          <input type="text" id="searchDtbox" class="form-control" placeholder="search...">
        </div>
      </div>
      {!! Form::open(['id'=>'formInbox','method'=>'POST']) !!}
			<table id="tableInbox" class="table table-striped table-color">
				<thead>
					<tr>
						<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
            <th>&nbsp;</th>
            <th>Memo No.</th>
            <th>From</th>
            <th>Approval</th>
            <th>Branch</th>
            <th>Subject</th>
            <th>Total</th>
            <th>Status</th>
            <th>Prepayment</th>
            <th>Action</th>
					</tr>
				</thead>
				<tbody>
          @foreach ($memos as $memo)
            <tr>
              <td>
                  <input type="checkbox" id="idTableInbox" value="{{ $memo->id }}" name="id[]" class="checkin">
              </td>
              <td>
                @if (is_array($memo->userFrom->pictures))
                  <img src="{{ url('hrd/employee/profile') }}/{{ $memo->userFrom->pictures[0]->filename }}" class="img-circle" alt="User Image" id="picture-profile-memo">
                @else 
                  <img src="/admin-lte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" id="picture-profile-memo">
                @endif
                
              </td>
              <td>{{ $memo->no_memo }}</td>
              <td>{{ $memo->userFrom->name }} | {{ $memo->from_memo }}</td>
              <td>
                <?php
                  // $approval_path = explode("+", $memo->approval_memo);
                  // $search = array_search(auth()->user()->position_id, $approval_path);
                  // $key = $search + 1;

                  // if(isset($approval_path[$key])){
                  //   $user = App\User::where('position_id', $approval_path[$key])->first();
                  //   echo $user->name." | ".$user->id;  
                  // }
                ?>
                {{-- @if (!empty($user)) --}}
                  {{-- {{ Form::hidden('to_memo', $user->id) }} --}}
                {{-- @else --}}
                  {{-- <span>Finish</span>
                  {{ Form::hidden('to_memo', '0') }} --}}
                {{-- @endif --}}
              </td>
              <td>{{ $memo->branch->name }}</td>
              <td>{{ $memo->subject_memo }}</td>
              <td>
                @if ($memo->prepayment_total>0)
                  {{ number_format($memo->prepayment_total) }}
                @else 
                  {{ number_format($memo->total_memo) }}  
                @endif
                
              </td>
              <td>{{ $memo->status_memo }}</td>
              <td>
                @if ($memo->prepayment_total>0)
                  <i class="fa fa-check-circle" aria-hidden="true" style="color: #2ecc71"></i>
                @else
                  <i class="fa fa-times" aria-hidden="true" style="color: #c0392b"></i>
                @endif
              </td>
              <td>
                <a href="{{ route('memo.process.process', $memo->token) }}" class="btn btn-success">
                  <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Process
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
			</table>
      {!! Form::close() !!}
		</div>
	</div>

  @include('memo.inbox._modal')
@stop

@section('scripts')
  <script type="text/javascript">
    function ApproveMemo() {
      if ($('.checkin').is(':checked')) 
      {
        $('#approveMemo').modal("show");
      }
      else
      {
        $('#deleteNoModal').modal("show");
      }
    }

    function RejectMemo() {
      if ($('.checkin').is(':checked')) 
      {
        $('#rejectMemo').modal("show");
      }
      else
      {
        $('#deleteNoModal').modal("show");
      } 
    }

    function ReviseMemo(){
      if ($('.checkin').is(':checked')) 
      {
        $('#reviseMemo').modal("show");
      }
      else
      {
        $('#deleteNoModal').modal("show");
      }
    }

    function approveMemo(){
      $("#formInbox").attr('action', '/memo/inbox/process/approval');
      $('#formInbox').submit();
    }
    function rejectMemo(){
      $("#formInbox").attr('action', '/memo/inbox/process/reject');
      $('#formInbox').submit();
    }
    function reviseMemo(){
      $("#formInbox").attr('action', '/memo/inbox/process/revise');
      $('#formInbox').submit();
    }
  </script>
@stop