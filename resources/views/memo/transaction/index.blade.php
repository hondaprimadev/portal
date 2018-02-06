@extends('layout.admin')

@section('content-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-user-secret" aria-hidden="true"></i> Memo 
      <small>Inbox Memo </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('memo..index') }}">Memo</a></li>
    </ol>
  </section>
@stop

@section('content')
	<div class="box box-danger">
		<div class="box-header">
			<h3 class="box-title">
				Tables Memo
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
        <div class="col-md-12">
          <span style="margin-left: 10px;"">
            <i class="fa fa-filter" aria-hidden="true"></i> Filter
            {!! Form::select('account_id', $journal, $journal_id, ['class'=>'btn btn-red', 'id'=>'journal_id']) !!}
            {!! Form::select('category_id', $category, $category_id, ['class'=>'btn btn-red', 'id'=>'category_id']) !!}
            @if (Gate::check('memo.super'))
              {!! Form::select('branch_id', $branch, $branch_id, ['class'=>'btn btn-red', 'id'=>'branch_id']) !!}
              {!! Form::select('department_id', $department, $dept_id, ['class'=>'btn btn-red', 'id'=>'department_id']) !!}
            @else
              {!! Form::select('branch_id', $branch, $branch_id, ['class'=>'btn btn-red', 'id'=>'branch_id', 'disabled'=>'disabled']) !!}
              {!! Form::select('department_id', $department, $dept_id, ['class'=>'btn btn-red', 'id'=>'department_id','disabled'=>'disabled']) !!}
            @endif
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
          {{-- <input type="text" id="searchDtbox" class="form-control" placeholder="search..."> --}}
        </div>
      </div>
      <table class="table table-striped table-color">
        <thead>
          <th>No</th>
          <th>Memo No.</th>
          <th>Branch</th>
          <th>Notes</th>
          <th>Date</th>
          <th>Debet</th>
          <th>Credit</th>
          <th>Saldo</th>
        </thead>

        <tbody>
        <?php
          $no = 0;
          $saldo = 0;
          $debet = 0;
          $credit = 0;
        ?>
        @foreach ($mt as $mTran)
          <?php 
            $debet += $mTran->debet;
            $credit += $mTran->credit;
          ?>

          <tr>
            <td>{{ $no +=1 }}</td>
            <td>
              @if ($mTran->memo()->count() > 0)
                <a href="{{ route('memo.memo.show', $mTran->memo->token) }}">
                  {{ $mTran->memo->no_memo }}
                </a>
              @else
                -
              @endif
            </td>
            <td>{{ $mTran->branch->name }}</td>
            <td>{{ $mTran->notes }}</td>
            <td>{{ date('d/M/Y', strtotime($mTran->created_at)) }}</td>
            @if ($no == 1 && $mTran->debet != 0)
              <td>{{ number_format($mTran->debet) }}</td>
              <td>{{ number_format($mTran->credit) }}</td>  
              <td>{{ number_format($saldo += $mTran->debet) }}</td>
            @else
              @if ($mTran->debet != 0)
                <td>{{ number_format($mTran->debet) }}</td>
                <td>{{ number_format($mTran->credit) }}</td>  
                <td>{{ number_format($saldo = $saldo + $mTran->debet) }}</td>
              @else
                <td>{{ number_format($mTran->debet) }}</td>
                <td>{{ number_format($mTran->credit) }}</td>  
                <td>{{ number_format($saldo = $saldo - $mTran->credit) }}</td>
              @endif
            @endif
          </tr>
        @endforeach
        </tbody>
        
        <tfoot>
          <tr style="text-align: left">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ number_format($debet) }}</td>
            <td>{{ number_format($credit) }}</td>
            <td>{{ number_format($debet - $credit) }}</td>
          </tr>
        </tfoot>
      </table>
		</div>
	</div>

  {{-- @include('memo.approval._modal') --}}
@stop

@section('scripts')
  @include('memo.transaction._js')
@stop