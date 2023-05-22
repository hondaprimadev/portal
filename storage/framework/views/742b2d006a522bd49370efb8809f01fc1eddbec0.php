<?php $__env->startSection('content-header'); ?>
  <section class="content-header">
    <h1>
      <i class="fa fa-user-secret" aria-hidden="true"></i> HRD Management
      <small>Emplyoee / User Data Manajemen</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Hrd</a></li>
      <li class="active"><a href="<?php echo e(route('hrd.employee.index')); ?>">Employee</a></li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="box box-danger">
		<div class="box-header">
			<h3 class="box-title">
				Tables Employee
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
          <a href="<?php echo e(route('hrd.employee.create')); ?>" class="btn btn-red" data-toggle="tooltip" data-placement="bottom" title="Create Employee">
            <i class="fa fa-plus" aria-hidden="true"></i>
          </a>

          <button type="button" class="btn btn-red" onclick="DeleteHRD()" data-toggle="tooltip" data-placement="bottom" title="Delete Employee">
            <i class="fa fa-trash" aria-hidden="true"></i>
          </button>

          <button type="button" class="btn btn-red" onclick="AddUser()" data-toggle="tooltip" data-placement="bottom" title="Add/remove Employee to user">
            <i class="fa fa-user-plus" aria-hidden="true"></i>
          </button>
          <span style="margin-left: 10px;>
            <i class="fa fa-filter" aria-hidden="true"></i> Filter
            <?php echo Form::select('branch_id', $branches, null, ['class'=>'btn btn-red', 'id'=>'branch_id']); ?>

            <?php echo Form::select('job_status', [''=>'Status','Active'=>'Active','Skorsing'=>'Skorsing','Move'=>'Move','Retired'=>'Retired','Fired'=>'Fired'], null, ['class'=>'btn btn-red', 'id'=>'job_status']); ?>

            <?php echo Form::select('grade', [''=>'Grade','BRONZE'=>'BRONZE','SILVER'=>'SILVER','GOLD'=>'GOLD','PLATINUM'=>'PLATINUM'], null, ['class'=>'btn btn-red', 'id'=>'grade']); ?>

          </span>
          <?php /* <button type="button" class="btn btn-red" id="reportrange">
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
            <span>
              <?php echo e(Carbon\Carbon::createFromFormat('Y-m-d', $begin)->format('M d, Y')); ?>

              -
              <?php echo e(Carbon\Carbon::createFromFormat('Y-m-d', $end)->format('M d, Y')); ?>

            </span>
            <b class="caret"></b>
          </button> */ ?>
        </div>

        <div class="col-md-4">
          <input type="text" id="searchDtbox" class="form-control" placeholder="search...">
        </div>
      </div>

			<?php echo Form::open(['url'=>'/hrd/employee/delete','id'=>'formHrdDelete']); ?>

				<table id="tableUser" class="table table-striped table-color">
					<thead>
						<tr>
							<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
              <th>Nik</th>
							<th>Name</th>
							<th>Email</th>
							<th>Dealer</th>
							<th>Role</th>
              <th>Grade</th>
							<th>Status</th>
              <th>User?</th>
              <th>Pic(marketing)</th>
						</tr>
					</thead>
					<tbody>
            <?php foreach($employee as $user): ?>
              <tr>
                <td>
                    <input type="checkbox" id="idTableUser" value="<?php echo e($user->id); ?>" name="id[]" class="checkin">
                </td>
                <td>
                  <?php echo e($user->id); ?>

                </td>
                <td>
                  <?php echo e($user->name); ?>

                  <input type="hidden" id="nameTableUser" value="<?php echo e($user->name); ?>"><span class="badge"></span>
                </td>
                <td>
                  <?php echo e($user->email); ?>

                  <input type="hidden" id="emailTableUser" value="<?php echo e($user->email); ?>">
                </td>
                <td> 
                  <?php if($user->branch()->count() > 0): ?>
                    <?php echo e($user->branch->name); ?>

                  <?php endif; ?>
                </td>
                <td>
                  <?php if($user->roles()->count() > 0): ?>
                    <?php foreach($user->roles as $role): ?>
                      <?php echo e($role->name); ?>, 
                    <?php endforeach; ?>
                    <input type="hidden" id="roleTableUser" value="<?php echo e($user->roles->lists('id')); ?>"/>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if($user->grade_marketing): ?>
                    <?php echo e($user->grade); ?> | <?php echo e($user->grade_marketing); ?>

                  <?php else: ?>
                    <?php echo e($user->grade); ?>

                  <?php endif; ?>
                </td>
                <td><?php echo e($user->job_status); ?></td>
                <td>
                  <?php if($user->is_user): ?>
                    <i class="fa fa-check-circle" aria-hidden="true" style="color: #2ecc71"></i>
                  <?php endif; ?>
                </td>
                <td>
                  <?php 
                    $pic = App\User::find($user->pic_id);
                   ?>
                  <?php if($pic): ?>
                    <?php echo e($pic->name); ?>

                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
				</table>
			<?php echo Form::close(); ?>

		</div>
	</div>

  <?php echo $__env->make('hrd.employee._modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
    $('#branch_id').on('change', function () {
      tableUser.columns(4).search( this.value ).draw();
    });
    $('#job_status').on('change', function(){
      tableUser.columns(7).search(this.value).draw();
    });
    $('#grade').on('change', function(){
      tableUser.columns(6).search(this.value).draw();
    });
    $('#tableUser tbody').on('dblclick', 'tr', function () {
    		if ( $(this).hasClass('selected') ) {
    			$(this).removeClass('selected');
    		}
    		else {
    			tableUser.$('tr.selected').removeClass('selected');
    			$(this).addClass('selected');
        		
        		var id = $(this).find('#idTableUser').val();
            window.location="<?php echo e(request()->url()); ?>/"+id+"/edit";
    		}
    });

    // daterangepicker
    $('#reportrange').daterangepicker({
      buttonClasses: ['btn', 'btn-sm'],
      applyClass: 'btn-primary',
      cancelClass: 'btn-default',
      startDate: '<?php echo e(Carbon\Carbon::createFromFormat('Y-m-d', $begin)->format('m/d/y')); ?>',
        endDate: '<?php echo e(Carbon\Carbon::createFromFormat('Y-m-d', $end)->format('m/d/y')); ?>',
      locale: {
        applyLabel: 'Submit',
        cancelLabel: 'Cancel',
        fromLabel: 'From',
        toLabel: 'To',
      }
    }, function(start, end, label){
      console.log(start.toISOString(), end.toISOString(), label);

      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      window.location="<?php echo e(request()->url()); ?>?begin="+ start.format('Y-MM-DD') +"&end=" + end.format('Y-MM-DD');
    });

    function DeleteHRD() {
      if ($('.checkin').is(':checked')) 
      {
        $('#deleteHrdModal').modal("show");
      }
      else
      {
        $('#deleteNoModal').modal("show");
      }
    }

    function deleteHrd(){
      $('#formHrdDelete').attr('action', '<?php echo e(route('hrd.employee.delete')); ?>');
      $('#formHrdDelete').submit();
    }

    function AddUser() {
      if ($('.checkin').is(':checked')) 
      {
        $('#addUserModal').modal("show");
      }
      else
      {
        $('#deleteNoModal').modal("show");
      }
    }
    function addUser(){
      $('#formHrdDelete').attr('action', '<?php echo e(route('hrd.user.create')); ?>');
      $('#formHrdDelete').submit();

    }
    
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>