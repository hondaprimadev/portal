<?php /* Create Modal */ ?>
<div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="Create Role">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="CreateColor">Create Role</h4>
			</div>
			<div class="modal-body">
				<?php echo Form::open(['url'=> '/admin/user/role']); ?>

					<div class="form-group">
						<?php echo Form::label('name', 'Name:'); ?>

						<?php echo Form::text('name',null,['class'=>'form-control']); ?>

					</div>
					<?php echo Form::submit('save' , ['class' =>'btn btn-red']); ?>

				<?php echo Form::close(); ?>

			</div>
		</div>
	</div>
</div>

<?php /* Edit Modal */ ?>
<div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="Edit Role">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="EditType">Edit Role</h4>
			</div>
			<div class="modal-body">
				<?php echo Form::open(['url'=> '/admin/user/role','method'=>"PATCH",'id'=>'editRole']); ?>

					<div class="form-group">
						<?php echo Form::label('name', 'Name:'); ?>

						<?php echo Form::text('name',null,['class'=>'form-control','id'=>'nameRole']); ?>

					</div>
					<?php echo Form::submit('Update' , ['class' =>'btn btn-red']); ?>

				<?php echo Form::close(); ?>

			</div>
		</div>
	</div>
</div>

<?php /* Delete Modal */ ?>
<div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-labelledby="Delete Role">
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
            		Are you sure you want to delete this Role?
          		</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            	<button type="submit" class="btn btn-danger" onclick=deleteRole()><i class="fa fa-times-circle"></i> Yes
			</div>
		</div>
	</div>
</div>