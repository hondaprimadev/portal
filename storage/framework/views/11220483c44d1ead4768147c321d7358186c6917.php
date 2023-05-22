<?php $__env->startSection('content-header'); ?>
	<section class="content-header">
      <h1>
        <i class="fa fa-newspaper-o"></i> User Management
        <small>User Permission Manajemen</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">User</a></li>
        <li class="active">Permission</li>
      </ol>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="box box-danger">
		<div class="box-header">
			<h3 class="box-title">
				Tables Permission
			</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse">
					<i class="fa fa-minus"></i>
				</button>
				<button type="button" class="btn btn-box-tool" data-widget="remove">
					<i class="fa fa-remove"></i>
				</button>
			</div>
		</div>

		<div class="box-body">
			<div class="col-md-12 box-body-header">  
        		<div class="col-md-8">
            		<button type="button" class="btn btn-red" onclick="addPermission()">
              			<i class="fa fa-user-plus" aria-hidden="true"></i> New
            		</button>
            		<button type="button" class="btn btn-red" onclick="DeletePermission()">
              			<i class="fa fa-trash" aria-hidden="true"></i> Delete
            		</button>
        		</div>

        		<div class="col-md-4">
          			<input type="text" id="searchDtbox" class="form-control" placeholder="search...">
        		</div>
      		</div>

			<?php echo Form::open(['url'=>'admin/user/permission/delete','id'=>'formPermissionDelete']); ?>

				<table id="tablePermission" class="table table-striped table-color">
					<thead>
						<tr>
							<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
							<th>Name</th>
							<th>Role</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($permissions as $p): ?>
							<tr>
								<td>
                  					<input type="checkbox" id="idTablePermission" value="<?php echo e($p->id); ?>" name="id[]" class="checkin">
                				</td>
								<td>
									<?php echo e($p->name); ?>

									<input type="hidden" id="nameTablePermission" value="<?php echo e($p->name); ?>"/>
									<input type="hidden" id="roleTablePermission" value="<?php echo e($p->roles->lists('id')); ?>"/>
								</td>
								<td>
									<?php foreach($p->roles as $role): ?>
										<?php echo e($role->name); ?>, 
									<?php endforeach; ?>
								</td>
								<td><?php echo e($p->created_at); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php echo Form::close(); ?>

		</div>
	</div>

	<?php echo $__env->make('user.permission.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		var tablePermission = $("#tablePermission").DataTable({
			"sDom": 'rt',
      		"scrollY":        "50vh",
      		"scrollCollapse": true,
      		"paging":         false
		});
		$("#searchDtbox").keyup(function() {
        	tablePermission.search($(this).val()).draw();
    	});

    	$('#tablePermission tbody').on('dblclick', 'tr', function () {
    		if ( $(this).hasClass('selected') ) {
    			$(this).removeClass('selected');
    		}
    		else {
    			tablePermission.$('tr.selected').removeClass('selected');
    			$(this).addClass('selected');
        		
        		var id = $(this).find('#idTablePermission').val();
        		var name = $(this).find('#nameTablePermission').val();
        		var role = $(this).find('#roleTablePermission').val();

        		editPermission(id, name, role);
    		}
    	});

    	function addPermission() {
    		$("#createPermissionModal").modal("show");
    	}

    	function editPermission(id, name, role) {
    		$("#editPermission").attr('action', '/admin/user/permission/' + id);
      		$("#idPermission").val(id);
      		$("#namePermission").val(name);
      		$("#rolePermission").val(JSON.parse(role));

      		$("#editPermissionModal").modal("show");
    	}

    	function DeletePermission() {
    		if ($('.checkin').is(':checked')) 
      		{
        		$('#deletePermissionModal').modal("show");
      		}
      		else
      		{
        		$('#deleteNoModal').modal("show");
      		}
    	}

    	function deletePermission() {
    		$('#formPermissionDelete').submit();
    	}
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>