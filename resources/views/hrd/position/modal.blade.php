{{-- Create Modal --}}
<div class="modal fade" id="createPositionModal" tabindex="-1" role="dialog" aria-labelledby="Create Position">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="CreateColor">Create Position</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(['url'=> '/hrd/position']) !!}
					<div class="form-group">
						{!! Form::label('id', 'ID :') !!}
						{!! Form::text('id', null,['class'=> 'form-control']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('name', 'Name:') !!}
						{!! Form::text('name',null,['class'=>'form-control']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('department_id', 'Department:') !!}
						{!! Form::select('department_id',$depts, null, ['class'=>'form-control']) !!}
					</div>

					{!! Form::submit('save' , ['class' =>'btn btn-red']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editPositionModal" tabindex="-1" role="dialog" aria-labelledby="Edit Position">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="EditType">Edit Position</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(['id'=>'editPosts', 'method'=>"PATCH"]) !!}
					<div class="form-group">
						{!! Form::label('id', 'ID :') !!}
						{!! Form::text('id', null,['class'=> 'form-control','id'=>'idPosts']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('name', 'Name:') !!}
						{!! Form::text('name',null,['class'=>'form-control','id'=>'namePosts']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('department_id', 'Department:') !!}
						{!! Form::select('department_id',$depts, null, ['class'=>'form-control','id'=>'deptPosts']) !!}
					</div>

					{!! Form::submit('Update' , ['class' =>'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deletePositionModal" tabindex="-1" role="dialog" aria-labelledby="Delete Position">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</spapdate Merkn>
				</button>
				<h4 class="modal-title" id="CreateMerk">Please Confirm</h4>
			</div>
			<div class="modal-body">
				<p class="lead">
            	<i class="fa fa-question-circle fa-lg"></i>  
            		Are you sure you want to delete this Position?
          		</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            	<button type="submit" class="btn btn-danger" onclick=deletePosition()><i class="fa fa-times-circle"></i> Yes
			</div>
		</div>
	</div>
</div>