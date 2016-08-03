@extends('layout.admin')

@section('content-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-user-secret" aria-hidden="true"></i> Customer Management
      <small>Customer Data</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Crm</a></li>
      <li class="active"><a href="{{ route('crm.index') }}">Index</a></li>
    </ol>
  </section>
@stop

@section('content')		
	<div class="box box-danger">
		<div class="box-header">
			<h3 class="box-title">
				Tables Customer
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
          			<a href="{{ route('crm.create') }}" class="btn btn-red" data-toggle="tooltip" data-placement="bottom" title="Create Customer">
            			<i class="fa fa-plus" aria-hidden="true"></i>
          			</a>

          			<button type="button" class="btn btn-red" onclick="DeleteCrm()" data-toggle="tooltip" data-placement="bottom" title="Delete Customer">
            			<i class="fa fa-trash" aria-hidden="true"></i>
          			</button>
          			
          			@if (!$branch_select)
          			<span style="margin-left: 10px;"">
            			<i class="fa fa-filter" aria-hidden="true"></i> Filter
        					{!! Form::select('branch_id', $branch_filter, $branch_select, ['class'=>'btn btn-red', 'id'=>'branch_id']) !!}
          			</span>
          			@endif
        </div>

        <div class="col-md-4">
          <input type="text" id="searchDtbox" class="form-control" placeholder="search...">
        </div>
      </div>

			{!! Form::open(['url'=>'/crm/delete','id'=>'formCrmDelete']) !!}
				<table id="tableCrm" class="table table-striped table-color">
					<thead>
						<tr>
							<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
              				<th>Customer Group</th>
							<th>Supplier No.</th>
							<th>Name Customer</th>
							<th>Name Company/Group</th>
							<th>Branch</th>
							<th>Sales Count</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($crms as $crm)
							<tr>
								<td>
									<input type="checkbox" id="idTableCrm" name="id[]" class="checkin" value="{{ $crm->id }}"/>
								</td>
								<td>{{$crm->type_customer}}</td>
								<td>{{$crm->nomor_crm }}</td>
								<td>{{$crm->name_personal }}</td>
								<td>{{$crm->name_group}}</td>
								<td>{{ $crm->branch->name }}</td>
								<td>{{ $crm->vs()->count() }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			{!! Form::close() !!}
		</div>
	</div>

	@include('crm.modal')
@stop

@section('scripts')
	<script>
		var tableCrm = $("#tableCrm").DataTable({
      		"sDom": 'rt',
      		"scrollY":        "50vh",
      		"scrollCollapse": true,
      		"paging":         false
    	});
		$("#searchDtbox").keyup(function() {
        	tableCrm.search($(this).val()).draw();
    	});
    	$('#type_id').on('change', function () {
      		tableCrm.columns(2).search( this.value ).draw();
    	});
    	$('#branch_id').on('change', function () {
      		tableCrm.columns(5).search( this.value ).draw();
    	});
		
		$('#tableCrm tbody').on('dblclick', 'tr', function () {
    		if ( $(this).hasClass('selected') ) {
    			$(this).removeClass('selected');
    		}
    		else {
    			tableCrm.$('tr.selected').removeClass('selected');
    			$(this).addClass('selected');
        		
        		var id = $(this).find('#idTableCrm').val();
            	window.location="{{  request()->url() }}/"+id+"/edit";
    		}
    	});

		function DeleteCrm(id)
		{
			$("#deleteSupplier").attr('action', '/master/supplier/' + id);
			$("#deleteSupplierModal").modal("show");
		}
		function addSupplier () 
		{
			$("#createSupplierModal").modal("show");
		}

		function DeleteCrm()
		{
			if ($('.checkin').is(':checked')) 
			{
				$('#deleteCRMModal').modal("show");
			}
			else
			{
				$('#deleteNoModal').modal("show");
			}
		}

		function deleteCrm()
		{
			$('#formCrmDelete').submit();
		}
	</script>
@stop