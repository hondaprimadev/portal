{{-- Create Modal --}}
<div class="modal fade" id="createSettingModal" tabindex="-1" role="dialog" aria-labelledby="Create User">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="CreateColor">Create Memo Setting</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(['route'=> 'memo.approval.store']) !!}
					<div class="form-group">
						{!! Form::label('Approval', 'Approval:') !!}
						{!! Form::text('approval_path',old('approval_path'),['class'=>'form-control']) !!}

						{!! Form::label('category_id', 'Category:') !!}
						{!! Form::select('category_id',$category,null,['class'=>'form-control']) !!}

						{!! Form::label('branch_id', 'Branch:') !!}
						{!! Form::select('branch_id',$branch,null,['class'=>'form-control']) !!}

						{!! Form::label('user_approval', 'User:') !!}
						{!! Form::select('user_approval',$userPosition,null,['class'=>'form-control']) !!}
						
						{!! Form::label('budget', 'Budget:') !!}
						{!! Form::text('budget_total', old('budget'), ['class'=>'form-control']) !!}

						{!! Form::label('inv_date1', 'Date 1:') !!}
						{!! Form::date('inv_date1', null, ['class'=>'form-control']) !!}

						{!! Form::label('inv_date2', 'Date 2:') !!}
						{!! Form::date('inv_date2', null, ['class'=>'form-control']) !!}

						<div class="checkbox">
  							<label>
    							{!! Form::checkbox('prepayment', '1') !!}
    							Prepayment
  							</label>
						</div>
					</div>
					{!! Form::submit('save' , ['class' =>'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editApprovalModal" tabindex="-1" role="dialog" aria-labelledby="Edit User">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="EditType">Edit Memo Setting</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(['url'=> '/memo/approval','method'=>"PATCH",'id'=>'editApproval']) !!}
					<div class="form-group">
						{!! Form::label('Approval', 'Approval:') !!}
						{!! Form::text('approval_path',old('approval_path'),['class'=>'form-control', 'id'=>'pathApproval']) !!}

						{!! Form::label('category_id', 'Category:') !!}
						{!! Form::select('category_id',$category,null,['class'=>'form-control','id'=>'categoryApproval']) !!}

						{!! Form::label('branch_id', 'Branch:') !!}
						{!! Form::select('branch_id',$branch,null,['class'=>'form-control','id'=>'branchApproval']) !!}

						{!! Form::label('user_approval', 'User:') !!}
						{!! Form::select('user_approval',$userPosition,null,['class'=>'form-control','id'=>'userApproval']) !!}
						{!! Form::label('budget', 'Budget:') !!}
						{!! Form::text('budget_total', null, ['class'=>'form-control','id'=>'budget_totalApproval']) !!}

						{!! Form::label('inv_date1', 'Date 1:') !!}
						{!! Form::date('inv_date1', null, ['class'=>'form-control','id'=>'date1Approval']) !!}

						{!! Form::label('inv_date2', 'Date 2:') !!}
						{!! Form::date('inv_date2', null, ['class'=>'form-control','id'=>'date2Approval']) !!}
						

						<div class="checkbox">
  							<label>
    							{!! Form::checkbox('prepayment', '1') !!}
    							Prepayment
  							</label>
						</div>
					</div>
					{!! Form::submit('Update' , ['class' =>'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteApprovalModal" tabindex="-1" role="dialog" aria-labelledby="Delete User">
	<div class="modal-dialog" role="document">
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
            		Are you sure you want to delete this Approval?
          		</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            	<button type="submit" class="btn btn-danger" onclick=DeleteApproval()><i class="fa fa-times-circle"></i> Yes
			</div>
		</div>
	</div>
</div>