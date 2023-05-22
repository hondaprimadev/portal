<?php $__env->startSection('content-header'); ?>
  <section class="content-header">
    <h1>
      <i class="fa fa-user-secret" aria-hidden="true"></i> Memo 
      <small>Inbox Memo Approval</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo e(route('memo..index')); ?>">Memo</a></li>
      <li><a href="<?php echo e(route('memo..index')); ?>">Index</a></li>
    </ol>
  </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="box box-danger">
		<div class="box-header">
			<h3 class="box-title">
				Tables Memo Inbox
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
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('memo.super')): ?>
              <?php /* <button type="button" class="btn btn-red" onclick="ApproveMemo()">
                <i class="fa fa-check-square" aria-hidden="true"></i> Approve
              </button>
              <button type="button" class="btn btn-red" onclick="ReviseMemo()">
                <i class="fa fa-reply" aria-hidden="true"></i> Revise
              </button>
              <button type="button" class="btn btn-red" onclick="RejectMemo()">
                <i class="fa fa-trash" aria-hidden="true"></i> Reject
              </button> */ ?>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
          <input type="text" id="searchDtbox" class="form-control" placeholder="search...">
        </div>
      </div>
      <?php echo Form::open(['id'=>'formInbox','method'=>'POST']); ?>

			<table id="tableInbox" class="table table-striped table-color">
				<thead>
					<tr>
						<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
            <th>&nbsp;</th>
            <th>Memo No.</th>
            <th>From</th>
            <th>Approval</th>
            <th>Branch</th>
            <th>Subject</th>
            <th>Total</th>
            <th>Status</th>
            <th>Prepayment</th>
            <th>Action</th>
					</tr>
				</thead>
				<tbody>
          <?php foreach($memos as $memo): ?>
            <tr>
              <td>
                  <input type="checkbox" id="idTableInbox" value="<?php echo e($memo->id); ?>" name="id[]" class="checkin">
              </td>
              <td>
                <?php if(is_array($memo->userFrom->pictures)): ?>
                  <img src="<?php echo e(url('hrd/employee/profile')); ?>/<?php echo e($memo->userFrom->pictures[0]->filename); ?>" class="img-circle" alt="User Image" id="picture-profile-memo">
                <?php else: ?> 
                  <img src="/admin-lte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" id="picture-profile-memo">
                <?php endif; ?>
                
              </td>
              <td><?php echo e($memo->no_memo); ?></td>
              <td><?php echo e($memo->userFrom->name); ?> | <?php echo e($memo->from_memo); ?></td>
              <td>
                <?php
                  // $approval_path = explode("+", $memo->approval_memo);
                  // $search = array_search(auth()->user()->position_id, $approval_path);
                  // $key = $search + 1;

                  // if(isset($approval_path[$key])){
                  //   $user = App\User::where('position_id', $approval_path[$key])->first();
                  //   echo $user->name." | ".$user->id;  
                  // }
                ?>
                <?php /* <?php if(!empty($user)): ?> */ ?>
                  <?php /* <?php echo e(Form::hidden('to_memo', $user->id)); ?> */ ?>
                <?php /* <?php else: ?> */ ?>
                  <?php /* <span>Finish</span>
                  <?php echo e(Form::hidden('to_memo', '0')); ?> */ ?>
                <?php /* <?php endif; ?> */ ?>
              </td>
              <td><?php echo e($memo->branch->name); ?></td>
              <td><?php echo e($memo->subject_memo); ?></td>
              <td>
                <?php if($memo->prepayment_total>0): ?>
                  <?php echo e(number_format($memo->prepayment_total)); ?>

                <?php else: ?> 
                  <?php echo e(number_format($memo->total_memo)); ?>  
                <?php endif; ?>
                
              </td>
              <td><?php echo e($memo->status_memo); ?></td>
              <td>
                <?php if($memo->prepayment_total>0): ?>
                  <i class="fa fa-check-circle" aria-hidden="true" style="color: #2ecc71"></i>
                <?php else: ?>
                  <i class="fa fa-times" aria-hidden="true" style="color: #c0392b"></i>
                <?php endif; ?>
              </td>
              <td>
                <a href="<?php echo e(route('memo.process.process', $memo->token)); ?>" class="btn btn-success">
                  <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Process
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
			</table>
      <?php echo Form::close(); ?>

		</div>
	</div>

  <?php echo $__env->make('memo.inbox._modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <script type="text/javascript">
    var tableInbox = $("#tableInbox").DataTable({
	"sDom": 'rt',
      	"scrollY": "50vh",
	"scrollCollapse": true,
	"paging": false
    });
    function ApproveMemo() {
      if ($('.checkin').is(':checked')) 
      {
        $('#approveMemo').modal("show");
      }
      else
      {
        $('#deleteNoModal').modal("show");
      }
    }

    function RejectMemo() {
      if ($('.checkin').is(':checked')) 
      {
        $('#rejectMemo').modal("show");
      }
      else
      {
        $('#deleteNoModal').modal("show");
      } 
    }

    function ReviseMemo(){
      if ($('.checkin').is(':checked')) 
      {
        $('#reviseMemo').modal("show");
      }
      else
      {
        $('#deleteNoModal').modal("show");
      }
    }

    function approveMemo(){
      $("#formInbox").attr('action', '/memo/inbox/process/approval');
      $('#formInbox').submit();
    }
    function rejectMemo(){
      $("#formInbox").attr('action', '/memo/inbox/process/reject');
      $('#formInbox').submit();
    }
    function reviseMemo(){
      $("#formInbox").attr('action', '/memo/inbox/process/revise');
      $('#formInbox').submit();
    }
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>