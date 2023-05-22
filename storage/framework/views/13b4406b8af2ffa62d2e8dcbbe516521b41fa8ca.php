<?php $__env->startSection('content-header'); ?>
  <section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> HRD Management
      <small>Position Data Manajemen</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Hrd</a></li>
      <li class="active"><a href="<?php echo e(route('hrd.position.index')); ?>">Position</a></li>
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
		          	<button class="btn btn-red" onclick="AddPost()" data-toggle="tooltip" data-placement="bottom" title="Add New Position">
		          		<i class="fa fa-plus" aria-hidden="true"></i> New
		          	</button>
		            <button type="button" class="btn btn-red" onclick="DeletePosts()" data-toggle="tooltip" data-placement="bottom" title="Delete Position">
		              <i class="fa fa-trash" aria-hidden="true"></i> Delete
		            </button>
		            <?php echo Form::select('department_id_sort', $dept_select, null, ['class'=>'btn btn-red', 'id'=>'department_id_sort']); ?>

		        </div>
        		<div class="col-md-4">
          			<input type="text" id="searchDtbox" class="form-control" placeholder="search...">
        		</div>
      		</div>

      		<?php /* Table */ ?>

      		<?php echo Form::open(['url'=> '/hrd/position/delete','id'=>'formPositionDelete','method'=>'POST']); ?>

				<table class="table table-striped" id="tablePosition">
					<thead>
						<tr>
							<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
							<th>ID</th>
							<th>Name</th>
							<th>Department</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($posts as $post): ?>
							<tr>
								<td>
									<input type="checkbox" id="idTablePosition" name="id[]" class="checkin" value="<?php echo e($post->id); ?>"/>
								</td>
								<td><?php echo e($post->id); ?></td>
								<td>
									<?php echo e($post->name); ?>

									<input type="hidden" id="nameTablePosition" value="<?php echo e($post->name); ?>">
								</td>
								<td>
									<?php echo e($post->department->name); ?>

									<input type="hidden" id="departmentTablePosition" value="<?php echo e($post->department_id); ?>">
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php echo Form::close(); ?>

		</div>
	</div>
	<?php echo $__env->make('hrd.position.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		var tablePosition = $("#tablePosition").DataTable({
			"sDom": 'rt',
      		"scrollY":        "50vh",
      		"scrollCollapse": true,
      		"paging":         false
		});

		$("#searchDtbox").keyup(function() {
        	tablePosition.search($(this).val()).draw() ;
    	});
    	$('#department_id_sort').on('change', function(){
      		tablePosition.columns(3).search(this.value).draw();
    	});
		$('#tablePosition tbody').on('dblclick', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tablePosition.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var id = $(this).find('#idTablePosition').val();
				var name = $(this).find('#nameTablePosition').val();
				var dept = $(this).find('#departmentTablePosition').val();

				EditPosts(id,name,dept);
			}
		});

		function AddPost() 
		{
			$("#createPositionModal").modal("show");
		}
		function EditPosts(id,name,dept)
		{
			$("#editPosts").attr('action', '/hrd/position/' + id);
			$("#idPosts").val(id);
			$("#namePosts").val(name);
			$("#deptPosts").val(dept);
			$("#editPositionModal").modal("show");
		}
		function DeletePosts(id) 
		{
			if ($('.checkin').is(':checked')) 
			{
				$('#deletePositionModal').modal("show");
			}
			else
			{
				$('#deleteNoModal').modal("show");
			}
		}
		function deletePosition() {
			$('#formPositionDelete').submit();
		}
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>