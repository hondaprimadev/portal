<?php $__env->startSection('content-header'); ?>
	<section class="content-header">
      <h1>
        <i class="fa fa-newspaper-o"></i> User Management
        <small>User Role Manajemen</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">User</a></li>
        <li class="active">Role</li>
      </ol>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="box box-danger">
		<div class="box-header">
			<h3 class="box-title">
				Tables Role
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
            <button type="button" class="btn btn-red" onclick="addRole()">
              <i class="fa fa-user-plus" aria-hidden="true"></i> New
            </button>
            <button type="button" class="btn btn-red" onclick="DeleteRole()">
              <i class="fa fa-trash" aria-hidden="true"></i> Delete
            </button>
        </div>

        <div class="col-md-4">
          <input type="text" id="searchDtbox" class="form-control" placeholder="search...">
        </div>
      </div>

			<?php echo Form::open(['url'=>'admin/user/role/delete','id'=>'formRoleDelete']); ?>

				<table id="tableRole" class="table table-striped table-color">
					<thead>
						<tr>
							<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
              <th>ID</th>
              <th>Name</th>
              <th>Date</th>
						</tr>
					</thead>
					<tbody>
            <?php foreach($roles as $r): ?>
              <tr>
                <td>
                    <input type="checkbox" id="idTableRole" value="<?php echo e($r->id); ?>" name="id[]" class="checkin">
                </td>
                <td>
                  <?php echo e($r->id); ?>

                </td>
                <td>
                  <?php echo e($r->name); ?>

                  <input type="hidden" id="nameTableRole" value="<?php echo e($r->name); ?>">
                </td>
                <td><?php echo e($r->created_at); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
				</table>
			<?php echo Form::close(); ?>

		</div>
	</div>

	<?php echo $__env->make('user.role.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		var tableRole = $("#tableRole").DataTable({
      "sDom": 'rt',
      "scrollY":        "50vh",
      "scrollCollapse": true,
      "paging":         false
    });

		$("#searchDtbox").keyup(function() {
        	tableRole.search($(this).val()).draw();
    });

      	

  	$('#tableRole tbody').on('dblclick', 'tr', function () {
  		if ( $(this).hasClass('selected') ) {
  			$(this).removeClass('selected');
  		}
  		else {
  			tableRole.$('tr.selected').removeClass('selected');
  			$(this).addClass('selected');
          var id = $(this).find('#idTableRole').val();
          var name = $(this).find('#nameTableRole').val();

          editRole(id, name);
      }
  	});

    function addRole() {
      $("#createRoleModal").modal("show");
    }

    function editRole(id, name) {
      $("#editRole").attr('action', '/admin/user/role/' + id);
      $("#idRole").val(id);
      $("#nameRole").val(name);
      $("#editRoleModal").modal("show");
    }

  	function DeleteRole() {
  		if ($('.checkin').is(':checked')) 
    		{
      		$('#deleteRoleModal').modal("show");
    		}
    		else
    		{
      		$('#deleteNoModal').modal("show");
    		}
  	}

  	function deleteRole() {
  		$('#formRoleDelete').submit();
  	}
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>