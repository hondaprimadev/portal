<?php /* Create Modal */ ?>
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
				<?php echo Form::open(['route'=> 'memo.approval.store']); ?>

					<div class="form-group">
						<?php echo Form::label('Approval', 'Approval:'); ?>

						<?php echo Form::text('approval_path',old('approval_path'),['class'=>'form-control']); ?>


						<?php echo Form::label('category_id', 'Category:'); ?>

						<?php echo Form::select('category_id',$category,null,['class'=>'form-control']); ?>


						<?php echo Form::label('branch_id', 'Branch:'); ?>

						<?php echo Form::select('branch_id',$branch,null,['class'=>'form-control']); ?>


						<?php echo Form::label('user_approval', 'User:'); ?>

						<?php echo Form::select('user_approval',$userPosition,null,['class'=>'form-control']); ?>

						
						<?php echo Form::label('budget', 'Budget:'); ?>

						<?php echo Form::text('budget_total', old('budget'), ['class'=>'form-control']); ?>


						<?php echo Form::label('inv_date1', 'Date 1:'); ?>

						<?php echo Form::date('inv_date1', null, ['class'=>'form-control']); ?>


						<?php echo Form::label('inv_date2', 'Date 2:'); ?>

						<?php echo Form::date('inv_date2', null, ['class'=>'form-control']); ?>


						<div class="checkbox">
  							<label>
    							<?php echo Form::checkbox('prepayment', '1'); ?>

    							Prepayment
  							</label>
						</div>
					</div>
					<?php echo Form::submit('save' , ['class' =>'btn btn-primary']); ?>

				<?php echo Form::close(); ?>

			</div>
		</div>
	</div>
</div>

<?php /* Edit Modal */ ?>
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
				<?php echo Form::open(['url'=> '/memo/approval','method'=>"PATCH",'id'=>'editApproval']); ?>

					<div class="form-group">
						<?php echo Form::label('Approval', 'Approval:'); ?>

						<?php echo Form::text('approval_path',old('approval_path'),['class'=>'form-control', 'id'=>'pathApproval']); ?>


						<?php echo Form::label('category_id', 'Category:'); ?>

						<?php echo Form::select('category_id',$category,null,['class'=>'form-control','id'=>'categoryApproval']); ?>


						<?php echo Form::label('branch_id', 'Branch:'); ?>

						<?php echo Form::select('branch_id',$branch,null,['class'=>'form-control','id'=>'branchApproval']); ?>


						<?php echo Form::label('user_approval', 'User:'); ?>

						<?php echo Form::select('user_approval',$userPosition,null,['class'=>'form-control','id'=>'userApproval']); ?>

						<?php echo Form::label('budget', 'Budget:'); ?>

						<?php echo Form::text('budget_total', null, ['class'=>'form-control','id'=>'budget_totalApproval']); ?>


						<?php echo Form::label('inv_date1', 'Date 1:'); ?>

						<?php echo Form::date('inv_date1', null, ['class'=>'form-control','id'=>'date1Approval']); ?>


						<?php echo Form::label('inv_date2', 'Date 2:'); ?>

						<?php echo Form::date('inv_date2', null, ['class'=>'form-control','id'=>'date2Approval']); ?>

						

						<div class="checkbox">
  							<label>
    							<?php echo Form::checkbox('prepayment', '1'); ?>

    							Prepayment
  							</label>
						</div>
					</div>
					<?php echo Form::submit('Update' , ['class' =>'btn btn-primary']); ?>

				<?php echo Form::close(); ?>

			</div>
		</div>
	</div>
</div>

<?php /* Delete Modal */ ?>
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