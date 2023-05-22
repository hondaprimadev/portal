<?php /* Create Modal */ ?>
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="Create User">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="CreateColor">Create User</h4>
			</div>
			<div class="modal-body">
				<?php echo Form::open(['url'=> '/admin/user/user']); ?>

					<div class="form-group">
						<?php echo Form::label('name', 'Name:'); ?>

						<?php echo Form::text('name',null,['class'=>'form-control']); ?>

						
						<?php echo Form::label('email', 'Email:'); ?>

						<?php echo Form::text('email',null,['class'=>'form-control']); ?>

						
						<?php echo Form::label('branch_id', 'Dealer:'); ?>

						<?php echo Form::select('branch_id',$branch,null,['class'=>'form-control']); ?>


						<?php echo Form::label('role', 'Role:'); ?>

						<?php echo Form::select('role[]',$roles, null, ['class'=>'form-control','id'=>'idRole', 'multiple'=>'multiple']); ?>


						<?php echo Form::label('password', 'Password:'); ?>

						<?php echo Form::input('password','password',null,['class'=>'form-control']); ?>


						<?php echo Form::label('password_confirmation', 'Password Confirmation:'); ?>

						<?php echo Form::input('password','password_confirmation',null,['class'=>'form-control']); ?>

					</div>
					<?php echo Form::submit('save' , ['class' =>'btn btn-primary']); ?>

				<?php echo Form::close(); ?>

			</div>
		</div>
	</div>
</div>

<?php /* Edit Modal */ ?>
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="Edit User">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="EditType">Edit User</h4>
			</div>
			<div class="modal-body">
				<?php echo Form::open(['url'=> '/admin/user/user','method'=>"PATCH",'id'=>'editUser']); ?>

					<div class="form-group">
						<?php echo Form::label('name', 'Name:'); ?>

						<?php echo Form::text('name',null,['class'=>'form-control','id'=>'nameUser']); ?>

						
						<?php echo Form::label('email', 'Email:'); ?>

						<?php echo Form::text('email',null,['class'=>'form-control','id'=>'emailUser']); ?>

						

						<?php echo Form::label('branch_id', 'Dealer:'); ?>

						<?php echo Form::select('branch_id',$branch,null,['class'=>'form-control','id'=>'branchUser']); ?>


						<?php echo Form::label('role', 'Role:'); ?>

						<?php echo Form::select('role[]',$roles, null, ['class'=>'form-control','id'=>'roleUser', 'multiple'=>'multiple']); ?>


						<?php echo Form::label('password', 'Password:'); ?>

						<?php echo Form::input('password','password',null,['class'=>'form-control']); ?>


						<?php echo Form::label('password_confirmation', 'Password Confirmation:'); ?>

						<?php echo Form::input('password','password_confirmation',null,['class'=>'form-control']); ?>

					</div>
					<?php echo Form::submit('Update' , ['class' =>'btn btn-primary']); ?>

				<?php echo Form::close(); ?>

			</div>
		</div>
	</div>
</div>

<?php /* Delete Modal */ ?>
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="Delete User">
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
            		Are you sure you want to delete this User?
          		</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            	<button type="submit" class="btn btn-danger" onclick=deleteUser()><i class="fa fa-times-circle"></i> Yes
			</div>
		</div>
	</div>
</div>