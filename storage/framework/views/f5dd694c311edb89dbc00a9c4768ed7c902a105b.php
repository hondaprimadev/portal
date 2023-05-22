<?php /* Create Modal */ ?>
	<div class="modal fade" id="createDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="Create Department">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="CreateColor">Create Department</h4>
				</div>
				<div class="modal-body">
					<?php echo Form::open(['url'=> '/hrd/department']); ?>

						<div class="form-group">
							<?php echo Form::label('id', 'ID :'); ?>

							<?php echo Form::text('id', null,['class'=> 'form-control']); ?>

						</div>
						<div class="form-group">
							<?php echo Form::label('name', 'Name:'); ?>

							<?php echo Form::text('name',null,['class'=>'form-control']); ?>

						</div>
						<?php echo Form::submit('save' , ['class' =>'btn btn-primary']); ?>

					<?php echo Form::close(); ?>

				</div>
			</div>
		</div>
	</div>

	<?php /* Edit Modal */ ?>
	<div class="modal fade" id="editDeptModal" tabindex="-1" role="dialog" aria-labelledby="EditBranch">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="EditType">Edit Branch</h4>
				</div>
				<div class="modal-body">
					<?php echo Form::open(['id'=>'editDept', 'method'=>"PATCH"]); ?>

						<div class="form-group">
							<?php echo Form::label('id', 'Code :'); ?>

							<?php echo Form::text('id', null,['class'=> 'form-control', 'id'=>'idDept']); ?>

						</div>
						<div class="form-group">
							<?php echo Form::label('name', 'Name:'); ?>

							<?php echo Form::text('name',null,['class'=>'form-control', 'id'=>'nameDept']); ?>

						</div>
						<?php echo Form::submit('Update' , ['class' =>'btn btn-primary']); ?>

					<?php echo Form::close(); ?>

				</div>
			</div>
		</div>
	</div>

	<?php /* Delete Modal */ ?>
	<div class="modal fade" id="deleteDeptModal" tabindex="-1" role="dialog" aria-labelledby="Delete Type">
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
	            		Are you sure you want to delete this Department?
	          		</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            	<button type="submit" class="btn btn-danger" onclick=DeleteDepartment()><i class="fa fa-times-circle"></i> Yes
				</div>
			</div>
		</div>
	</div>