<?php $__env->startSection('content-header'); ?>
  <section class="content-header">
    <h1>
      <i class="fa fa-user-secret" aria-hidden="true"></i> Customer Management
      <small>Customer Data</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Crm</a></li>
      <li class="active"><a href="<?php echo e(route('crm.index')); ?>">Index</a></li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>		
	<div class="box box-danger">
		<div class="box-header">
			<h3 class="box-title">
				Tables Customer
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
          			<a href="<?php echo e(route('crm.create')); ?>" class="btn btn-red" data-toggle="tooltip" data-placement="bottom" title="Create Customer">
            			<i class="fa fa-plus" aria-hidden="true"></i>
          			</a>

          			<button type="button" class="btn btn-red" onclick="DeleteCrm()" data-toggle="tooltip" data-placement="bottom" title="Delete Customer">
            			<i class="fa fa-trash" aria-hidden="true"></i>
          			</button>
          			
          			<?php if(!$branch_select): ?>
          			<span style="margin-left: 10px;"">
            			<i class="fa fa-filter" aria-hidden="true"></i> Filter
        					<?php echo Form::select('branch_id', $branch_filter, $branch_select, ['class'=>'btn btn-red', 'id'=>'branch_id']); ?>

          			</span>
          			<?php endif; ?>

          			<button type="button" class="btn btn-red" id="reportrange">
				    	<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
						<span>
							<?php if($begin): ?>
								<?php echo e($begin->format('M d, Y')); ?>

								-
								<?php echo e($end->format('M d, Y')); ?>

							<?php endif; ?>
						</span>
						<b class="caret"></b>
				    </button>
        		</div>

        		<div class="col-md-4">
          			<input type="text" id="searchDtbox" class="form-control" placeholder="search...">
        		</div>
      		</div>

			<?php echo Form::open(['url'=>'/crm/delete','id'=>'formCrmDelete']); ?>

				<table id="tableCrm" class="table table-striped table-color">
					<thead>
						<tr>
							<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
							<th>Customer No.</th>
							<th>Name Customer</th>
							<th>Branch</th>
							<th>Ktp</th>
							<th>No Telpon</th>
							<th>City</th>
							<th>Kecamatan</th>
							<th>Sales Count</th>
							<th>Sales Name</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($crms as $crm): ?>
							<?php if($crm->crmtypes->count() > 0): ?>
							<tr>
								<td>
									<input type="checkbox" id="idTableCrm" name="id[]" class="checkin" value="<?php echo e($crm->id); ?>"/>
								</td>
								<td><?php echo e($crm->nomor_crm); ?></td>
								<td><?php echo e($crm->name_personal); ?></td>
								<td><?php echo e($crm->branch->name); ?></td>
								<td><?php echo e($crm->identity_number); ?></td>
								<td><?php echo e($crm->ponsel_number); ?></td>
								<td><?php echo e($crm->city); ?></td>
								<td><?php echo e($crm->kecamatan); ?></td>
								<td><?php echo e($crm->vs()->count()); ?></td>
								<td>
									<?php foreach($crm->vs as $vs): ?>
										<?php echo e($vs->sales_name); ?>,
									<?php endforeach; ?>
								</td>
								<td><?php echo e(date('d M Y', strtotime($crm->created_at))); ?></td>
							</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php echo Form::close(); ?>

		</div>
	</div>

	<?php echo $__env->make('crm.modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
		var tableCrm = $("#tableCrm").DataTable({
      		"sDom": 'rt',
      		"sScrollY": "50vh",
      		"scrollCollapse": true,
      		"paging":         false
    	});
		$("#searchDtbox").keyup(function() {
        	tableCrm.search($(this).val()).draw();
    	});
    	$('#type_id').on('change', function () {
      		tableCrm.columns(2).search( this.value ).draw();
    	});
    	$('#branch_id').on('change', function () {
      		tableCrm.columns(3).search( this.value ).draw();
    	});
    	$(window).bind('resize', function () {
    		tableCrm.fnAdjustColumnSizing();
  		});
		
		$('#tableCrm tbody').on('dblclick', 'tr', function () {
    		if ( $(this).hasClass('selected') ) {
    			$(this).removeClass('selected');
    		}
    		else {
    			tableCrm.$('tr.selected').removeClass('selected');
    			$(this).addClass('selected');
        		
        		var id = $(this).find('#idTableCrm').val();
            	window.location="<?php echo e(request()->url()); ?>/"+id+"/edit";
    		}
    	});

		$('#reportrange').daterangepicker({
			buttonClasses: ['btn', 'btn-sm'],
			applyClass: 'btn-red',
			cancelClass: 'btn-default',
			startDate: '<?php echo e($begin->format('m/d/y')); ?>',
			endDate: '<?php echo e($end->format('m/d/y')); ?>',
			locale: {
				applyLabel: 'Submit',
				cancelLabel: 'Cancel',
				fromLabel: 'From',
				toLabel: 'To',
			},
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			}
		}, function(start, end, label){
			console.log(start.toISOString(), end.toISOString(), label);

			$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			window.location="<?php echo e(request()->url()); ?>?b="+ start.format('Y-MM-DD') +"&e=" + end.format('Y-MM-DD');

		});

		function DeleteCrm(id)
		{
			$("#deleteSupplier").attr('action', '/master/supplier/' + id);
			$("#deleteSupplierModal").modal("show");
		}
		function addSupplier () 
		{
			$("#createSupplierModal").modal("show");
		}

		function DeleteCrm()
		{
			if ($('.checkin').is(':checked')) 
			{
				$('#deleteCRMModal').modal("show");
			}
			else
			{
				$('#deleteNoModal').modal("show");
			}
		}

		function deleteCrm()
		{
			$('#formCrmDelete').submit();
		}
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>