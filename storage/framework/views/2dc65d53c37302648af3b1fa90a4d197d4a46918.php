<?php $__env->startSection('content-header'); ?>
  <section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> HRD Management
      <small>Department Data Manajemen</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Hrd</a></li>
      <li class="active"><a href="<?php echo e(route('hrd.department.index')); ?>">Department</a></li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">
				Tables Department
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
		          	<button class="btn btn-red" onclick="AddDept()" data-toggle="tooltip" data-placement="bottom" title="Add New Department">
		          		<i class="fa fa-plus" aria-hidden="true"></i> New
		          	</button>
		            <button type="button" class="btn btn-red" onclick="deleteDept()" data-toggle="tooltip" data-placement="bottom" title="Delete Deparment">
		              <i class="fa fa-trash" aria-hidden="true"></i> Delete
		            </button>
		        </div>
        		<div class="col-md-4">
          			<input type="text" id="searchDtbox" class="form-control" placeholder="search...">
        		</div>
      		</div>
      		<?php echo Form::open(['url'=> '/hrd/department/delete','id'=>'formDeptDelete','method'=>'POST']); ?>

				<table class="table table-striped" id="tableDepartment">
					<thead>
						<tr>
							<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
							<th>ID</th>
							<th>Name</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($depts as $dept): ?>
							<tr>
								<td>
									<input type="checkbox" id="idTableDept" name="id[]" class="checkin" value="<?php echo e($dept->id); ?>"/>
								</td>
								<td>
									<?php echo e($dept->id); ?>

								</td>
								<td>
									<?php echo e($dept->name); ?>

									<input type="hidden" id="nameTableDept" value="<?php echo e($dept->name); ?>">
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php echo Form::close(); ?>

		</div>
	</div>
	<?php echo $__env->make('hrd.department.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		var tableDepartment = $("#tableDepartment").DataTable({
			"sDom": 'rt',
      		"scrollY":        "50vh",
      		"scrollCollapse": true,
      		"paging":         false
		});	
		$("#searchDtbox").keyup(function() {
        	tableDepartment.search($(this).val()).draw() ;
    	});
		$('#tableDepartment tbody').on('dblclick', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tableDepartment.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var id = $(this).find('#idTableDept').val();
				var name = $(this).find('#nameTableDept').val();
				EditDept(id,name);
			}
		});

		function AddDept() 
		{
			$('#createDepartmentModal').modal("show");
		}
		function EditDept (id, name) 
		{
			$("#editDept").attr('action', '/hrd/department/' + id);
			$('#idDept').val(id);
			$("#nameDept").val(name);
			$("#editDeptModal").modal("show");
		}
		function deleteDept() {
			if ($('.checkin').is(':checked')) 
			{
				$('#deleteDeptModal').modal("show");
			}
			else
			{
				$('#deleteNoModal').modal("show");
			}
		}
		function DeleteDepartment(id)
		{
			$("#formDeptDelete").submit();
		}
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>