@extends('app')

@section('breadcrumb')
	<ol class="breadcrumb">
		<li>Hrm</li>
		<li class="active">Position</li>
	</ol>
@stop

@section('action1')
	<div class="btn-group" role="group" aria-label="...">
		<button type="button" class="btn btn-default btn-new" data-toggle="tooltip" data-placement="top" title="Create Brand" onclick=AddPost()>
			<i class="fa fa-plus"></i> New
		</button>
		
		<button type="submit" class="btn btn-default btn-delete" data-toggle="tooltip" data-placement="top" title="Delete Brand" onclick=DeletePosts()>
			<i class="fa fa-times"></i> Delete
		</button> 
	</div>
@stop
@section('content')
	<div class="container-fluid main-content">
		<div class="row">
			<div class="col-md-12">
				{!! Form::open(['url'=> '/hrm/position/delete','id'=>'formPositionDelete','method'=>'POST']) !!}
				<table class="table table-striped" id="tablePosition">
					<thead>
						<tr>
							<th><input type="checkbox" id="check_all"/></th>
							<th>ID</th>
							<th>Name</th>
							<th>Department</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($posts as $post)
							<tr>
								<td>
									<input type="checkbox" id="idTablePosition" name="id[]" class="checkin" value="{{ $post->id }}"/>
								</td>
								<td>{{$post->id}}</td>
								<td>
									{{ $post->name }}
									<input type="hidden" id="nameTablePosition" value="{{ $post->name }}">
								</td>
								<td>
									{{$post->department->name }}
									<input type="hidden" id="departmentTablePosition" value="{{ $post->department_id }}">
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				{!! Form::close() !!}
			</div>
		</div>
	</div>

	@include('hrm.position.modal')
@stop

@section('scripts')
	<script type="text/javascript">
		var tablePosition = $("#tablePosition").DataTable({
			scrollY:        '50vh',
        	scrollCollapse: false,
        	paging:         true,
        	"pageLength": 50,
		});

		$('#tablePosition tbody').on('dblclick', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tablePosition.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var id = $(this).find('#idTablePosition').val();
				var name = $(this).find('#nameTablePosition').val();
				var dept = $(this).find('#departmentTablePosition').val();

				EditPosts(id,name,dept);
			}
		});

		function AddPost() 
		{
			$("#createPositionModal").modal("show");
		}
		function EditPosts(id,name,dept)
		{
			$("#editPosts").attr('action', '/hrm/position/' + id);
			$("#idPosts").val(id);
			$("#namePosts").val(name);
			$("#deptPosts").val(dept);
			$("#editPositionModal").modal("show");
		}
		function DeletePosts(id) 
		{
			if ($('.checkin').is(':checked')) 
			{
				$('#deletePositionModal').modal("show");
			}
			else
			{
				$('#deleteNoModal').modal("show");
			}
		}
		function deletePosition() {
			$('#formPositionDelete').submit();
		}
	</script>
@stop