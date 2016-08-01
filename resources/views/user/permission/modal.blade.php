{{-- Create Modal --}}
<div class="modal fade" id="createPermissionModal" tabindex="-1" Permission="dialog" aria-labelledby="Create Permission">
	<div class="modal-dialog" Permission="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="CreateColor">Create Permission</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(['url'=> '/admin/user/permission']) !!}
					<div class="form-group">
						{!! Form::label('name', 'Name:') !!}
						{!! Form::text('name',null,['class'=>'form-control']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('role', 'Role:') !!}
						{!! Form::select('role[]',$roles, null, ['class'=>'form-control','id'=>'idRole', 'multiple'=>'multiple']) !!}
					</div>
					{!! Form::submit('save' , ['class' =>'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editPermissionModal" tabindex="-1" Permission="dialog" aria-labelledby="Edit Permission">
	<div class="modal-dialog" Permission="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="EditType">Edit Permission</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(['url'=> '/admin/user/permission','method'=>"PATCH",'id'=>'editPermission']) !!}
					<div class="form-group">
						{!! Form::label('name', 'Name:') !!}
						{!! Form::text('name',null,['class'=>'form-control','id'=>'namePermission']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('role', 'Role:') !!}
						{!! Form::select('role[]',$roles, null, ['class'=>'form-control','id'=>'rolePermission', 'multiple'=>'multiple']) !!}
					</div>
					{!! Form::submit('Update' , ['class' =>'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deletePermissionModal" tabindex="-1" Permission="dialog" aria-labelledby="Delete Permission">
	<div class="modal-dialog" Permission="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="CreateMerk">Please Confirm</h4>
			</div>
			<div class="modal-body">
				<p class="lead">
            	<i class="fa fa-question-circle fa-lg"></i>  
            		Are you sure you want to delete this Permission?
          		</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            	<button type="submit" class="btn btn-danger" onclick=deletePermission()><i class="fa fa-times-circle"></i> Yes
			</div>
		</div>
	</div>
</div>