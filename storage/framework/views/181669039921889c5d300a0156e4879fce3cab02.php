<!DOCTYPE html>
<html><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo e($memo->no_memo); ?></title>
	<style type="text/css">
    	<?php 
    		include(public_path().'/admin-lte/bootstrap/css/bootstrap.min.css');
    		include(public_path().'/admin-lte/dist/css/font-awesome.min.css');
    	?>
	@page  { margin: 0.5cm; }
    	.table {
		    border-bottom:1px !important;
		}
		.table th, .table td {
		    border: 1px !important;
		    padding:1px;
		}

	    .table-color tr th{
	      	background: #c0392b; /* fallback for old browsers */
	      	color: white;
	    }	    
	    .table-color .tfooter td{
	      	background: #ddd;
	      	font-weight: bold;
	    }
	    .table-color-green tr th {
		background: green;
		color: white;
	    }
	    .table-color-green .tfooter td {
		background: #ddd;
		font-weight: bold;
	    }
	    .footer{
	    	bottom: 0px
	    }
	    .page-break {
    		page-break-after: always;
		}
	</style>
</head><body>
	<div class="row">
		<div class="col-xs-12">
			<div class="col-xs-6">
				<img src="<?php echo e(public_path()); ?>/admin-lte/image/hondaprima.png">
			</div>
			<div class="col-xs-6 pull-right">
				<h4><b><?php echo e($memo->no_memo); ?></b></h4>
			</div>
		</div>
	</div>

	<hr style="border-color: #000;">
	<br>

	<table class="table">
		<tr>
			<td><b>From</b></td>
			<td><?php echo e($memo->userFrom->name); ?></td>
		</tr>
		<tr>
			<td><b>Company</b></td>
			<td><?php echo e($memo->company->name); ?></td>
		</tr>
		<tr>
			<td><b>Branch</b></td>
			<td><?php echo e($memo->branch->name); ?></td>
		</tr>
		<?php if($memo->branch_id == 100): ?>
		<tr>
			<td><b>Department</b></td>
			<td><?php echo e($memo->department->name); ?></td>
		</tr>
		<?php endif; ?>
		<tr>
			<td><b>Date</b></td>
			<td><?php echo e(date('d/M/Y H:i:s', strtotime($memo->created_at))); ?></td>
		</tr>
		<tr>
			<td><b>Activity Name</b></td>
			<td><?php echo e($memo->subject_memo); ?></td>
		</tr>
		<tr>
			<td><b>Category</b></td>
			<td><?php echo e($memo->category->name); ?></td>
		</tr>
		<tr>
			<td><b>Akun</b></td>
			<td><?php echo e($mc->journal->account_name); ?></td>
		</tr>
		<tr>
			<td><b>Request Budget</b></td>
			<td><?php echo e(number_format($memo->total_memo)); ?></td>
		</tr>
		<tr>
			<td><b>Approve By</b></td>
			<td>
				<?php
					$appr = $memo->sents()->where('status_memo', 'like', 'APPROVED BY%')->first();
					$apprU = str_replace('APPROVED BY', '', $appr['status_memo']);
				?>
				<?php echo e($apprU); ?>

			</td>
		</tr>
	</table>
	
	<?php if($memo->department_id == 'D7'): ?>
	<table class="table table-striped table-color-green">
	<?php else: ?>
	<table class="table table-striped table-color">
	<?php endif; ?>
		<tr>	
			<th>Date</th>
			<th>Description</th>
			<th>Qty</th>
			<th>Amount</th>
			<th>Sub Total</th>
		</tr>
		<?php 
			$sum='';
		 ?>
		<?php foreach($memo->details as $detail): ?>
			<tr>
				<td><?php echo e($detail->date); ?></td>
				<td><?php echo e($detail->description); ?></td>
				<td><?php echo e($detail->qty); ?></td>
				<td><?php echo e(number_format($detail->total)); ?></td>
				<td><?php echo e(number_format($detail->qty * $detail->total)); ?></td>
			</tr>
			<?php 
				$sum += $detail->qty * $detail->total;
			 ?>
		<?php endforeach; ?>
		<tr class="tfooter">
			<td colspan="4">Total</td>
			<td><?php echo e(number_format($sum)); ?></td>
		</tr>
	</table>
	<br>
	
	<h4>Data Supplier</h4>
	<hr>
		<table class="table">
			<?php if($memo->supplier_type == 'employee'): ?>
          <tr>
            <td><b>Name</b></td>
            <td><?php echo e($memo->supplierUser->name); ?></td>
          </tr>
          <tr>
            <td><b>Account No.</b></td>
            <td><?php echo e($memo->supplierUser->bank_account); ?></td>
          </tr>
          <tr>
            <td><b>Bank</b></td>
            <td><?php echo e($memo->supplierUser->bank_name); ?></td>
          </tr>
          <tr>
            <td><b>Branch</b></td>
            <td><?php echo e($memo->supplierUser->bank_branch); ?></td>
          </tr>
          <tr>
            <td><b>NPWP</b></td>
            <td><?php echo e($memo->supplierUser->npwp); ?></td>
          </tr>
        <?php else: ?>
		<?php if($memo->supplier): ?>
          <tr>
		<td><b>Name</b></td>
		<td><?php echo e($memo->supplier->name); ?></td>
	  </tr>
          <tr>
            <td><b>Account Name</b></td>
            <td><?php echo e($memo->supplier->account_name); ?></td>
          </tr>
          <tr>
            <td><b>Account No.</b></td>
            <td><?php echo e($memo->supplier->account_number); ?></td>
          </tr>
          <tr>
            <td><b>Bank</b></td>
            <td>
		<?php if($memo->supplier->bank): ?>
		<?php echo e($memo->supplier->bank->name); ?>

		<?php endif; ?>
	    </td>
          </tr>
          <tr>
            <td><b>Branch</b></td>
            <td><?php echo e($memo->supplier->bank_branch); ?></td>
          </tr>
          <tr>
            <td><b>NPWP</b></td>
            <td><?php echo e($memo->supplier->npwp); ?></td>
          </tr>
		<?php endif; ?>
        <?php endif; ?>
      	</table>

	<?php /* <?php if($memo->finances->count()>0): ?>
	<h4>Data Finance Support</h4>
	<hr>
		<table class="table">
			<?php foreach($memo->finances as $mf): ?>
				<tr>
	          		<td><?php echo e($mf->group_leasing); ?></td>
	          		<td><?php echo e(number_format($mf->total)); ?></td>
	        	</tr>
			<?php endforeach; ?>	        
      	</table>
	<?php endif; ?> */ ?>

</body></html>
