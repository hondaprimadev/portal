{{-- Create Modal Category --}}
<div class="modal fade" id="createCatModal" tabindex="-1" role="dialog" aria-labelledby="Create Category">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="CreateColor">Create Category</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(['url'=> '/memo/category']) !!}
					<div class="form-group">
						{!! Form::label('name', 'Name:') !!}
						{!! Form::text('name',null,['class'=>'form-control']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('department_id', 'Department:') !!}
						{!! Form::select('department_id',$dept, null, ['class'=>'form-control', 'id'=>'department_id']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('account_id', 'Account:') !!}
						{!! Form::select('account_id', $jaccount,null, ['class'=>'form-control', 'id'=>'account_id']) !!}
					</div>
					{!! Form::submit('save' , ['class' =>'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

{{-- Edit Modal Category --}}
<div class="modal fade" id="editCatModal" tabindex="-1" role="dialog" aria-labelledby="EditCategory">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="EditType">Edit Category</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(['id'=>'editCat', 'method'=>"PATCH"]) !!}
					<div class="form-group">
						{!! Form::label('name', 'Name:') !!}
						{!! Form::text('name',null,['class'=>'form-control', 'id'=>'nameCat']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('department_id', 'Department:') !!}
						{!! Form::select('department_id',$dept, null, ['class'=>'form-control', 'id'=>'departmentCat']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('account_id', 'Account:') !!}
						{!! Form::select('account_id', $jaccount,null, ['class'=>'form-control', 'id'=>'accountCat']) !!}
					</div>
					{!! Form::submit('Update' , ['class' =>'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

{{-- Delete Modal Category--}}
<div class="modal fade" id="deleteCatModal" tabindex="-1" role="dialog" aria-labelledby="Delete Category">
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
            		Are you sure you want to delete this Memo's Category?
          		</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            	<button type="submit" class="btn btn-danger" onclick=DeleteCat()><i class="fa fa-times-circle"></i> Yes
			</div>
		</div>
	</div>
</div>




{{-- Create Modal Account --}}
<div class="modal fade" id="createAccountModal" tabindex="-1" role="dialog" aria-labelledby="Create ACcount">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="CreateColor">Create Account</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(['url'=> '/memo/account']) !!}
					<div class="form-group">
						{!! Form::label('id', 'ID:') !!}
						{!! Form::text('id',null,['class'=>'form-control']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('account_name', 'Name:') !!}
						{!! Form::text('account_name', null, ['class'=>'form-control']) !!}
					</div>
					{!! Form::submit('save' , ['class' =>'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

{{-- Edit Modal Account --}}
<div class="modal fade" id="editAccountModal" tabindex="-1" role="dialog" aria-labelledby="Edit Account">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="EditType">Edit Account</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(['id'=>'editAccount', 'method'=>"PATCH"]) !!}
					<div class="form-group">
						{!! Form::label('id', 'ID:') !!}
						{!! Form::text('id',null,['class'=>'form-control','id'=>'idAccount']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('account_name', 'Name:') !!}
						{!! Form::text('account_name', null, ['class'=>'form-control','id'=>'nameAccount']) !!}
					</div>
					{!! Form::submit('Update' , ['class' =>'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

{{-- Delete Modal Account--}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="Delete Account">
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
            		Are you sure you want to delete this Account?
          		</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            	<button type="submit" class="btn btn-danger" onclick=DeleteAccount()><i class="fa fa-times-circle"></i> Yes
			</div>
		</div>
	</div>
</div>