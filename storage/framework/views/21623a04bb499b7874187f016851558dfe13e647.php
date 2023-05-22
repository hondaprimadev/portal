<?php $__env->startSection('content-header'); ?>
	<section class="content-header">
      <h1>
        <i class="fa fa-newspaper-o"></i> User
        <small>User Manajemen</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">User</a></li>
        <li class="active">Index</li>
      </ol>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="box box-warning">
		<div class="box-header">
			<h3 class="box-title">
				Tables User
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
            <button type="button" class="btn btn-red" onclick="addUser()">
              <i class="fa fa-user-plus" aria-hidden="true"></i> New
            </button>
            <button type="button" class="btn btn-red" onclick="DeleteUser()">
              <i class="fa fa-trash" aria-hidden="true"></i> Delete
            </button>
            <span style="margin-left: 10px;">
            <i class="fa fa-filter" aria-hidden="true"></i> Filter
            <?php echo Form::select('branch_id_sort', $branches, null, ['class'=>'btn btn-red', 'id'=>'branch_id_sort']); ?>

          </span>
        </div>

        <div class="col-md-4">
          <input type="text" id="searchDtbox" class="form-control" placeholder="search...">
        </div>
      </div>

			<?php echo Form::open(['url'=>'admin/user/user/delete','id'=>'formUserDelete']); ?>

				<table id="tableUser" class="table table-striped table-color">
					<thead>
						<tr>
							<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
              <th>Nik</th>
							<th>Name</th>
							<th>Email</th>
							<th>Branch</th>
							<th>Role</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
            <?php foreach($users as $user): ?>
              <tr>
                <td>
                    <input type="checkbox" id="idTableUser" value="<?php echo e($user->id); ?>" name="id[]" class="checkin">
                </td>
                <td>
                  <?php echo e($user->id); ?>

                </td>
                <td>
                  <?php echo e($user->name); ?>

                  <input type="hidden" id="nameTableUser" value="<?php echo e($user->name); ?>">
                </td>
                <td>
                  <?php echo e($user->email); ?>

                  <input type="hidden" id="emailTableUser" value="<?php echo e($user->email); ?>">
                </td>
                <td> 
                  <?php if($user->branch()->count() > 0): ?>
                    <?php echo e($user->branch->name); ?>

                    <input type="hidden" id="brachTableUser" value="<?php echo e($user->branch_id); ?>">
                  <?php endif; ?>
                </td>
                <td>
                  <?php if($user->roles()->count() > 0): ?>
                    <?php foreach($user->roles as $role): ?>
                      <?php echo e($role->name); ?>, 
                    <?php endforeach; ?>
                    <input type="hidden" id="roleTableUser" value="<?php echo e($user->roles->lists('id')); ?>"/>
                  <?php else: ?> 
                    <input type="hidden" id="roleTableUser" value="[0]">
                  <?php endif; ?>
                </td>
                <td><?php echo e($user->created_at); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
				</table>
			<?php echo Form::close(); ?>

		</div>
	</div>

	<?php echo $__env->make('user.user.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		var tableUser = $("#tableUser").DataTable({
      "sDom": 'rt',
      "scrollY":        "50vh",
      "scrollCollapse": true,
      "paging":         false
    });
		$("#searchDtbox").keyup(function() {
        	tableUser.search($(this).val()).draw();
    });
    $('#branch_id_sort').on('change', function () {
      tableUser.columns(4).search( this.value ).draw();
    });

    $('#tableUser tbody').on('dblclick', 'tr', function () {
      if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');
      }
      else {
        tableUser.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');

        var id = $(this).find('#idTableUser').val();
        var name = $(this).find('#nameTableUser').val();
        var email = $(this).find('#emailTableUser').val();
        var branch = $(this).find('#brachTableUser').val();
        var role = $(this).find('#roleTableUser').val();

        editUser(id, name, email, branch, role);
      }
    });

  	function addUser() {
  		$('.profile_img').attr('src', '');
    		$( ".btn-upload-profile" ).show();
    		$( ".btn-delete-profile" ).hide();
  		$("#createUserModal").modal("show");
  	}

  	function editUser(id, name, email ,branch, role) {
  		$("#editUser").attr('action', '/admin/user/user/' + id);
    		$("#idUser").val(id);
    		$("#nameUser").val(name);
    		$("#emailUser").val(email);
        $("#branchUser").val(branch);
    		$("#roleUser").val(JSON.parse(role));

    		$("#editUserModal").modal("show");
  	}

  	function DeleteUser() {
  		if ($('.checkin').is(':checked')) 
    		{
      		$('#deleteUserModal').modal("show");
    		}
    		else
    		{
      		$('#deleteNoModal').modal("show");
    		}
  	}

  	function deleteUser() {
  		$('#formUserDelete').submit();
  	}
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>