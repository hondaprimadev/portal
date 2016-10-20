@extends('layout.admin')

@section('content-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-user-secret" aria-hidden="true"></i> Marketing
      <small>Marketing Agenda</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Marketing</a></li>
      <li class="active"><a href="{{ route('marketing.agenda.index') }}">Agenda</a></li>
    </ol>
  </section>
@stop

@section('content')		
	<div class="box box-danger">
		<div class="box-header">
			<h3 class="box-title">
				Table Agenda
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
          			<button type="button" class="btn btn-red" onclick="DeleteVs()" data-toggle="tooltip" data-placement="bottom" title="Delete Vehicle Sles">
            			<i class="fa fa-trash" aria-hidden="true"></i>
          			</button>
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

			{!! Form::open(['url'=>'/marketing/vehicle/sales/delete','id'=>'formVsDelete']) !!}
				<table id="tableVs" class="table table-striped table-color">
					<thead>
						<tr>
							<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
              				<th>No Faktur</th>
              				<th>Branch</th>
              				<th>Credit/Cash</th>
              				<th>Leasing</th>
              				<th>Sales</th>
              				<th>Customer</th>
              				<th>Date</th>
						</tr>
					</thead>
					
				</table>
			{!! Form::close() !!}
		</div>
	</div>
	@include('vehicle.sales.modal')
@stop

@section('scripts')
	<script>
		var tableVs = $("#tableVs").DataTable({
      		"sDom": 'rt',
      		"scrollY":        "50vh",
      		"scrollCollapse": true,
      		"paging":         false
    	});
		$("#searchDtbox").keyup(function() {
        	tableVs.search($(this).val()).draw();
    	});
    	$('#branch_id').on('change', function () {
      		tableVs.columns(2).search( this.value ).draw();
    	});
    	$('#type_id').on('change', function () {
      		tableVs.columns(3).search( this.value ).draw();
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
			window.location="{{  request()->url() }}?b="+ start.format('Y-MM-DD') +"&e=" + end.format('Y-MM-DD');

		});

		function DeleteVs()
		{
			if ($('.checkin').is(':checked')) 
			{
				$('#deleteVsModal').modal("show");
			}
			else
			{
				$('#deleteNoModal').modal("show");
			}
		}

		function deleteVs()
		{
			$('#formVsDelete').submit();
		}
	</script>
@stop
