@extends('layout.admin')

@section('content')
<div class="container">
	{!! Form::model($crm, ['method' => 'PATCH', 'action' => ['CrmController@update', $crm->id], 'class'=>'form-horizontal', 'id'=>'formEditSupplier']) !!}
		@include('crm._form',['submitButtonText' => 'Create Supplier', 'crm_no'=>null])
	{!! Form::close() !!}
	<div class="box-footer">
		<button type="button" class="btn btn-success" onclick="updateCRM()">
			<i class="fa fa-floppy-o" aria-hidden="true"></i> Save
		</button>
		<button type="button" class="btn btn-default" onclick="resetCRM()">Reset</button>
	</div>
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

		function updateCRM() 
		{
			$('.form-control').attr('disabled',false);
			$('#formEditSupplier').submit();
		}
		function resetCRM() {
			$('.form-control').val('');
		}
	</script>
@stop