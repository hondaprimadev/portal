<?php $__env->startSection('content-header'); ?>
  <section class="content-header">
    <h1>
      <i class="fa fa-user-secret" aria-hidden="true"></i> Memo 
      <small>Inbox Memo Approval</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('memo..index')); ?>">Memo</a></li>
      <li class="active"><a href="<?php echo e(route('memo..index')); ?>">Index</a></li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="box box-danger">
		<div class="box-header">
			<h3 class="box-title">
				Tables Memo
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
                <a href="<?php echo e(route('memo.prepayment.create')); ?>" class="btn btn-red" data-toggle="tooltip" data-placement="bottom" title="Add Memo">
                  <i class="fa fa-plus" aria-hidden="true"></i> New
                </a>

                <span style="margin-left: 10px;"">
                  <i class="fa fa-filter" aria-hidden="true"></i> Filter
                  <?php echo Form::select('statusMemo', [''=>'--Status--','ON PROCESS'=>'ON PROCESS','REVISE BY'=>'REVISE','REJECT'=>'REJECT','FINISHED'=>'FINISHED'],null, ['class'=>'btn btn-red', 'id'=>'statusMemo']); ?>

                </span>
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

				<table id="tableMemo" class="table table-striped table-color">
					<thead>
						<tr>
              <th>Memo No.</th>
              <th>To</th>
              <th>Category</th>
              <th>Branch</th>
              <th>Subject</th>
              <th>Total</th>
              <th>Status</th>
              <th>Date</th>
              <th>Action</th>
						</tr>
					</thead>
					<tbody>
            <?php foreach($memos as $memo): ?>
              <tr>
                <td><?php echo e($memo->no_memo); ?></td>
                <td>
                <?php if($memo->to_memo != 0): ?>
                  <?php echo e($memo->userTo->name); ?> | <?php echo e($memo->to_memo); ?>

                <?php endif; ?>
                </td>
                <td><?php echo e($memo->category->name); ?></td>
                <td><?php echo e($memo->branch->name); ?></td>
                <td><?php echo e($memo->subject_memo); ?></td>
                <td><?php echo e(number_format($memo->prepayment_total)); ?></td>
                <td><?php echo e($memo->status_memo); ?></td>
                <td>
                  <?php echo e(date("d F Y",strtotime($memo->created_at))); ?>

                </td>
                <td>
                  <?php if($memo->to_memo == auth()->user()->id): ?>
                    <a href="<?php echo e(route('memo.prepayment.revise.edit', $memo->token)); ?>" class="btn btn-warning btn-xs">
                      <i class="fa fa-reply" aria-hidden="true"></i> Revise
                    </a>
                  <?php endif; ?>

                  <a href="<?php echo e(route('memo.memo.show', $memo->token)); ?>" class="btn btn-success btn-xs">
                    <i class="fa fa-arrow-circle-down" aria-hidden="true"></i> Show
                  </a>
                  <?php if($memo->prepayment_finish && $memo->prepayment_no == 0): ?>
                    <a href="<?php echo e(route('memo..create')); ?>?prepayment=<?php echo e($memo->token); ?>" class="btn btn-success btn-xs">
                      <i class="fa fa-share" aria-hidden="true"></i>
                      Claim
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
				</table>
		</div>
	</div>

  <?php /* <?php echo $__env->make('memo.approval._modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> */ ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <script type="text/javascript">
    var params = '';
    var tableMemo = $("#tableMemo").DataTable({
      "sDom": 'rt',
          "scrollY":        "50vh",
          "scrollCollapse": true,
          "paging":         false
    }); 

    $("#searchDtbox").keyup(function() {
          tableMemo.search($(this).val()).draw() ;
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
      // window.location="<?php echo e(request()->url()); ?>?begin="+ start.format('Y-MM-DD') +"&end=" + end.format('Y-MM-DD');
      updateQueryStringParam('begin', start.format('Y-MM-DD'));
      updateQueryStringParam('end', end.format('Y-MM-DD'));

    });

    $('#statusMemo').change(function(){
      tableMemo.columns(6).search( this.value ).draw();
    });
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>