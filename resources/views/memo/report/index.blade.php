@extends('layout.admin')

@section('content-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-user-secret" aria-hidden="true"></i> Memo Report
      <small>Report print & Chart</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('memo..index') }}">Memo</a></li>
      <li class="active"><a href="{{ route('memo.report.index') }}">Report</a></li>
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
            <div class="col-md-8">
                <span style="margin-left: 10px;"">
                  <i class="fa fa-filter" aria-hidden="true"></i> Filter
                </span>
                {!! Form::select('branch_id', $branch,$branch_id, ['class'=>'btn btn-red','id'=>'branch_id']) !!}

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

        <table id="tableReport" class="table table-striped table-color">
          <thead>
            <tr>
              <th>Memo No.</th>
              <th>From</th>
              <th>Category</th>
              <th>Branch</th>
              <th>Subject</th>
              <th>Total</th>
              <th>Status</th>
              <th>Upload</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($memo as $memo)
              <tr>
                <td>
                  <a href="{{ route('memo.memo.show', $memo->token) }}">
                    {{ $memo->no_memo }}
                  </a>
                </td>
                <td>
                @if ($memo->from_memo != 0)
                  {{ $memo->userFrom->name }} | {{ $memo->from_memo }}
                @endif
                </td>
                <td>{{ $memo->category->name }}</td>
                <td>{{ $memo->branch->name }}</td>
                <td>{{ $memo->subject_memo }}</td>
                <td>{{ number_format($memo->total_memo) }}</td>
                <td>{{ $memo->status_memo }}</td>
                <td>
                  @foreach ($memo->upload as $up)
                    <div id="UploadMemo">
                      <ul class="list-inline">
                        <li>
                          <a href="{{ route('memo.upload.show',$up->file_name) }}?branch={{ $memo->branch_id }}" target="_blank">
                          {!! getMime($up->file_name) !!}
                          {{ $up->file_name }}
                          </a>
                        </li>  
                      </ul>
                    </div>
                  @endforeach
                </td>
                <td>
                  {{ date("d F Y",strtotime($memo->created_at)) }}
                </td>
                <td>
                  <a href="{{ route('memo.report.print',$memo->token) }}" target="_blank">
                    <i class="fa fa-file-pdf-o fa-red fa-2x" aria-hidden="true"></i>
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
  <script type="text/javascript">
    var params = '';
      
    var tableReport = $("#tableReport").DataTable({
      "sDom": 'rt',
          "scrollY":        "50vh",
          "scrollCollapse": true,
          "paging":         false
    }); 

    $("#searchDtbox").keyup(function() {
      tableReport.search($(this).val()).draw() ;
    });

    $('#reportrange').daterangepicker({
      buttonClasses: ['btn', 'btn-sm'],
      applyClass: 'btn-red',
      cancelClass: 'btn-default',
      startDate: '{{ $begin->format('m/d/y') }}',
      endDate: '{{ $end->format('m/d/y') }}',
      locale: {
        applyLabel: 'Submit',
        cancelLabel: 'Cancel',
        fromLabel: 'From',
        toLabel: 'To',
      },
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    }, function(start, end, label){
      console.log(start.toISOString(), end.toISOString(), label);

      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      // window.location="{{  request()->url() }}?begin="+ start.format('Y-MM-DD') +"&end=" + end.format('Y-MM-DD');
      updateQueryStringParam('begin', start.format('Y-MM-DD'));
      updateQueryStringParam('end', end.format('Y-MM-DD'));
    });

    $('#branch_id').change(function(){
      updateQueryStringParam('branch', this.value);
    });
  </script>
@stop