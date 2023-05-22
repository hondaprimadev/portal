<?php $__env->startSection('content-header'); ?>
  <section class="content-header">
    <h1>
      <i class="fa fa-user-secret" aria-hidden="true"></i> Supplier
      <small>Data Supplier</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Supplier</a></li>
      <li class="active"><a href="#">Index</a></li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>		
	<div class="box box-danger">
		<div class="box-header">
			<h3 class="box-title">
				Tables Supplier
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
        			<a href="<?php echo e(route('supplier.create')); ?>" class="btn btn-red" data-toggle="tooltip" data-placement="bottom" title="Add Supplier">
            			<i class="fa fa-plus" aria-hidden="true"></i>
          			</a>
          			<button type="button" class="btn btn-red" onclick="DeleteVs()" data-toggle="tooltip" data-placement="bottom" title="Delete Vehicle Sles">
            			<i class="fa fa-trash" aria-hidden="true"></i>
          			</button>
          			<span style="margin-left: 10px;"">
            			<i class="fa fa-filter" aria-hidden="true"></i> Filter
        				<?php echo Form::select('branch_id', $branch, $bid, ['class'=>'btn btn-red', 'id'=>'branch_id']); ?>

          			</span>
        		</div>

		        <div class="col-md-4">
		          <input type="text" id="searchDtbox" class="form-control" placeholder="search...">
		        </div>
      		</div>

			<?php echo Form::open(['url'=>'/supplier/delete','id'=>'formSupplierDelete']); ?>

				<table id="tableSupplier" class="table table-striped table-color">
					<thead>
						<tr>
							<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
              				<th>Supplier No.</th>
              				<th>Branch</th>
              				<th>Category</th>
              				<th>Name</th>
              				<th>Phone</th>
              				<th>PIC</th>
              				<th>PIC Phone.</th>
              				<th>Bank</th>
              				<th>Account No.</th>
              				<th>Active</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($supplier as $s): ?>
							<tr>
								<td>
									<input type="checkbox" id="idTableSupplier" name="id[]" class="checkin" value="<?php echo e($s->id); ?>"/>
								</td>
								<td><?php echo e($s->no_supplier); ?></td>
								<td><?php echo e($s->branch->name); ?></td>
								<td><?php echo e($s->category->name); ?></td>
								<td><?php echo e($s->name); ?></td>
								<td><?php echo e($s->phone); ?></td>
								<td><?php echo e($s->name_pic); ?></td>
								<td><?php echo e($s->phone_pic); ?></td>
								<td>
									<?php if($s->bank_id != 0): ?>
										<?php echo e($s->bank->name); ?>

									<?php endif; ?>
								</td>
								<td><?php echo e($s->account_number); ?></td>
								<td>
									<?php if($s->active): ?>
										<i class="fa fa-check-circle" aria-hidden="true"></i>
									<?php else: ?>
										<i class="fa fa-times" aria-hidden="true"></i>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php echo Form::close(); ?>

		</div>
	</div>
	<?php echo $__env->make('vehicle.sales.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
		var tableSupplier = $("#tableSupplier").DataTable({
      		"sDom": 'rt',
      		"scrollY":        "50vh",
      		"scrollCollapse": true,
      		"paging":         false
    	});

    	$('#tableSupplier tbody').on('dblclick', 'tr', function () {
    		if ( $(this).hasClass('selected') ) {
    			$(this).removeClass('selected');
    		}
    		else {
    			tableSupplier.$('tr.selected').removeClass('selected');
    			$(this).addClass('selected');
        		
        		var id = $(this).find('#idTableSupplier').val();
            	window.location="<?php echo e(request()->url()); ?>/"+id+"/edit";
    		}
    	});

		$("#searchDtbox").keyup(function() {
        	tableSupplier.search($(this).val()).draw();
    	});
    	$('#branch_id').change(function() {
  			tableSupplier.columns(1).search( this.value ).draw();
		});

		function DeleteVs()
		{
			if ($('.checkin').is(':checked')) 
			{
				$('#deleteVsModal').modal("show");
			}
			else
			{
				$('#deleteNoModal').modal("show");
			}
		}

		function deleteVs()
		{
			$('#formSupplierDelete').submit();
		}
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>