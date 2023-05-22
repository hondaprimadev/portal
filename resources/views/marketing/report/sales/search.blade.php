@extends('layout.admin')

@section('content-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-bar-chart" aria-hidden="true"></i> Marketing Daily Report
      <small>Honda Prima Marketing Daily Report</small>
    </h1>
    <ol class="breadcrumb">
      
    </ol>
  </section>
@stop

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header"></div>
        <form class="form-horizontal">
        <div class="box-body">
          <div class="form-group">
            <label for="branch_id" class="col-sm-2 control-label">Branch</label>
            <div class="col-sm-4">
              {!! Form::select('branch_id', $branches, $branch, ['class'=>'form-control','id'=>'branch_id']) !!}
            </div>
          </div>

          <div class="form-group">
            <label for="user_id" class="col-sm-2 control-label">Sales</label>
            <div class="col-sm-4">
              {!! Form::select('user_id', $sales, null, ['class'=>'form-control user-id']) !!}
            </div>
          </div>
          
          <div class="form-group">
            <label for="date" class="col-sm-2 control-label">Date</label>  
            <div class="col-sm-4">
              <button type="button" class="btn btn-default" id="reportrange">
                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                <span>
                  @if ($begin)
                    {{ $begin->format('M d, Y') }}
                    -
                    {{ $end->format('M d, Y') }}
                  @endif
                </span>
                <b class="caret"></b>
              </button>
              <input type="hidden" id="begin">
              <input type="hidden" id="end">
            </div>     
          </div>

          <div class="form-group">
            <div class="col-sm-2"></div>  
            <div class="col-sm-4">
              <button type="button" class="btn btn-red" onclick="search()">
                <i class="fa fa-search" aria-hidden="true"></i> Search
              </button>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
@stop

@section('scripts')
  <script type="text/javascript">
    $('#branch_id').on('change', function(){
      window.location = "{{  request()->url() }}?b="+this.value;
    });
    $('.user-id').select2();

    $('#reportrange').daterangepicker({
      buttonClasses: ['btn', 'btn-sm'],
      applyClass: 'btn-success',
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
      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      $('#begin').val(start.format('YYYY-MM-DD'));
      $('#end').val(end.format('YYYY-MM-DD'));
    });

    function search() {
      var user = $('.user-id').val();
      var begin = $('#begin').val();
      var end = $('#end').val();
      window.location="{{  route('marketing.report.branch.sales.get') }}?s="+user+"&begin="+begin+"&end="+end;
    }
  </script>
@stop