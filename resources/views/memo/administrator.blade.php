@extends('layout.admin')

@section('content-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-user-secret" aria-hidden="true"></i> Memo 
      <small>Inbox Memo Approval</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('memo..index') }}">Memo</a></li>
      <li class="active"><a href="{{ route('memo..index') }}">Index</a></li>
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
                <a href="{{ route('memo..create') }}" class="btn btn-red" data-toggle="tooltip" data-placement="bottom" title="Add Memo">
                  <i class="fa fa-plus" aria-hidden="true"></i> New
                </a>

                <span style="margin-left: 10px;"">
                  <i class="fa fa-filter" aria-hidden="true"></i> Filter
                  {!! Form::select('statusMemo', [''=>'--Status--','ON PROCESS'=>'ON PROCESS','REVISE BY'=>'REVISE','REJECT'=>'REJECT','FINISHED'=>'FINISHED'],null, ['class'=>'btn btn-red', 'id'=>'statusMemo']) !!}
                  {!! Form::select('branch_id',$branch, null, ['class'=>'btn btn-red', 'id'=>'branch_id']) !!}
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

				<table id="tableMemo" class="table table-striped table-color">
					<thead>
						<tr>
              <th>Memo No.</th>
              <th>To</th>
              <th>Category</th>
              <th>Branch</th>
              <th>Subject</th>
              <th>Total</th>
              <th>Status</th>
              <th>Date</th>
              <th>Action</th>
						</tr>
					</thead>
					<tbody>
            @foreach ($memos as $memo)
              <tr>
                <td>{{ $memo->no_memo }}</td>
                <td>
                @if ($memo->to_memo != 0)
                  {{ $memo->userTo->name }} | {{ $memo->to_memo }}
                @endif
                </td>
                <td>{{ $memo->category->name }}</td>
                <td>{{ $memo->branch->name }}</td>
                <td>{{ $memo->subject_memo }}</td>
                <td>{{ number_format($memo->total_memo) }}</td>
                <td>{{ $memo->status_memo }}</td>
                <td>
                  {{ date("d F Y",strtotime($memo->created_at)) }}
                </td>
                <td>
                  <a href="{{ route('memo.memo.show', $memo->token) }}" class="btn btn-success btn-xs">
                    <i class="fa fa-arrow-circle-down" aria-hidden="true"></i> Show
                  </a>
                  <a href="{{ route('memo.process.process', $memo->id) }}" class="btn btn-success btn-xs">
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
  <script type="text/javascript">
    var params = '';
    var tableMemo = $("#tableMemo").DataTable({
      "sDom": 'rt',
          "scrollY":        "50vh",
          "scrollCollapse": true,
          "paging":         false
    }); 

    $("#searchDtbox").keyup(function() {
          tableMemo.search($(this).val()).draw() ;
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

    $('#statusMemo').change(function(){
      tableMemo.columns(6).search( this.value ).draw();
    });

    $('#branch_id').change(function(){
      tableMemo.columns(3).search( this.value).draw();
    })
    function updateQueryStringParam(key, value) {
      var baseUrl = [location.protocol, '//', location.host, location.pathname].join(''),
      urlQueryString = document.location.search,
      newParam = key + '=' + value,
      params = '?' + newParam;

      // If the "search" string exists, then build params from it
      if (urlQueryString) {

          updateRegex = new RegExp('([\?&])' + key + '[^&]*');
          removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');

          if( typeof value == 'undefined' || value == null || value == '' ) { // Remove param if value is empty

              params = urlQueryString.replace(removeRegex, "$1");
              params = params.replace( /[&;]$/, "" );

          } else if (urlQueryString.match(updateRegex) !== null) { 
            // If param exists already, update it
              params = urlQueryString.replace(updateRegex, "$1" + newParam);
          } else { // Otherwise, add it to end of query string

              params = urlQueryString + '&' + newParam;
          }
      }
      var iurl = window.history.replaceState({}, "", baseUrl + params);
      window.location = baseUrl + params;
    };
  </script>
@stop