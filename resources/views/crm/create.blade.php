@extends('layout.admin')

@section('content-header')
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> 
      <small>Employee / User Data Management</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Hrd</a></li>
      <li><a href="{{ route('hrd.employee.index') }}">Employee</a></li>
      <li class="active">Create</li>
    </ol>
  </section>
@stop


@section('content')
	<div class="container">
		{!! Form::model($crm = new \App\Crm, ['route' => 'crm.store','class'=>'form-horizontal','id'=>'formCreateCrm']) !!}
					@include('crm._form',['submitButtonText' => 'Create Supplier','crm_no'=>$crm->OfMaxno(auth()->user()->branch->id)])
		    <div class="box-footer">
		      <button type="button" class="btn btn-success" onclick="addCRM()">
		        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
		      </button>
		      <button type="button" class="btn btn-default" onclick="resetCRM()">Reset</button>
		    </div>
  		{!! Form::close() !!}
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		getCheckbox();

		function getCheckbox()
		{
			var checked_id;
			
			$('.type_customer:checked').each(function(){
				checked_id = $(this).val();
			});
			
			if (checked_id == 'Personal') {
				$(".supplier-group").attr('disabled','disabled');
			}
			else{
				$(".supplier-group").removeAttr('disabled');	
			}
		}

		function addCRM() {
			$('.form-control').attr('disabled',false);
			$('#formCreateCrm').submit();
		}
		function resetCRM() {
			$('.form-control').val('');
		}
	</script>
@stop