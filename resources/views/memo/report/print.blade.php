<!DOCTYPE html>
<html><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>{{ $memo->no_memo }}</title>
	<style type="text/css">
    	<?php 
    		include(public_path().'/admin-lte/bootstrap/css/bootstrap.min.css');
    		include(public_path().'/admin-lte/dist/css/font-awesome.min.css');
    	?>
	@page { margin: 0.5cm; }
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
				<img src="{{ public_path() }}/admin-lte/image/hondaprima.png">
			</div>
			<div class="col-xs-6 pull-right">
				<h4><b>{{ $memo->no_memo }}</b></h4>
			</div>
		</div>
	</div>

	<hr style="border-color: #000;">
	<br>

	<table class="table">
		<tr>
			<td><b>From</b></td>
			<td>{{ $memo->userFrom->name }}</td>
		</tr>
		<tr>
			<td><b>Company</b></td>
			<td>{{ $memo->company->name }}</td>
		</tr>
		<tr>
			<td><b>Branch</b></td>
			<td>{{ $memo->branch->name }}</td>
		</tr>
		@if ($memo->branch_id == 100)
		<tr>
			<td><b>Department</b></td>
			<td>{{ $memo->department->name }}</td>
		</tr>
		@endif
		<tr>
			<td><b>Date</b></td>
			<td>{{ date('d/M/Y H:i:s', strtotime($memo->created_at)) }}</td>
		</tr>
		<tr>
			<td><b>Activity Name</b></td>
			<td>{{ $memo->subject_memo }}</td>
		</tr>
		<tr>
			<td><b>Category</b></td>
			<td>{{ $memo->category->name }}</td>
		</tr>
		<tr>
			<td><b>Akun</b></td>
			<td>{{ $mc->journal->account_name }}</td>
		</tr>
		<tr>
			<td><b>Request Budget</b></td>
			<td>{{ number_format($memo->total_memo) }}</td>
		</tr>
		<tr>
			<td><b>Approve By</b></td>
			<td>
				<?php
					$appr = $memo->sents()->where('status_memo', 'like', 'APPROVED BY%')->first();
					$apprU = str_replace('APPROVED BY', '', $appr['status_memo']);
				?>
				{{  $apprU }}
			</td>
		</tr>
	</table>
	
	@if ($memo->department_id == 'D7')
	<table class="table table-striped table-color-green">
	@else
	<table class="table table-striped table-color">
	@endif
		<tr>	
			<th>Date</th>
			<th>Description</th>
			<th>Qty</th>
			<th>Amount</th>
			<th>Sub Total</th>
		</tr>
		@php
			$sum='';
		@endphp
		@foreach ($memo->details as $detail)
			<tr>
				<td>{{ $detail->date }}</td>
				<td>{{ $detail->description }}</td>
				<td>{{ $detail->qty }}</td>
				<td>{{ number_format($detail->total) }}</td>
				<td>{{ number_format($detail->qty * $detail->total) }}</td>
			</tr>
			@php
				$sum += $detail->qty * $detail->total;
			@endphp
		@endforeach
		<tr class="tfooter">
			<td colspan="4">Total</td>
			<td>{{ number_format($sum) }}</td>
		</tr>
	</table>
	<br>
	
	<h4>Data Supplier</h4>
	<hr>
		<table class="table">
			@if ($memo->supplier_type == 'employee')
          <tr>
            <td><b>Name</b></td>
            <td>{{ $memo->supplierUser->name }}</td>
          </tr>
          <tr>
            <td><b>Account No.</b></td>
            <td>{{ $memo->supplierUser->bank_account }}</td>
          </tr>
          <tr>
            <td><b>Bank</b></td>
            <td>{{ $memo->supplierUser->bank_name }}</td>
          </tr>
          <tr>
            <td><b>Branch</b></td>
            <td>{{ $memo->supplierUser->bank_branch }}</td>
          </tr>
          <tr>
            <td><b>NPWP</b></td>
            <td>{{ $memo->supplierUser->npwp }}</td>
          </tr>
        @else
		@if($memo->supplier)
          <tr>
		<td><b>Name</b></td>
		<td>{{ $memo->supplier->name }}</td>
	  </tr>
          <tr>
            <td><b>Account Name</b></td>
            <td>{{ $memo->supplier->account_name }}</td>
          </tr>
          <tr>
            <td><b>Account No.</b></td>
            <td>{{ $memo->supplier->account_number }}</td>
          </tr>
          <tr>
            <td><b>Bank</b></td>
            <td>
		@if($memo->supplier->bank)
		{{ $memo->supplier->bank->name }}
		@endif
	    </td>
          </tr>
          <tr>
            <td><b>Branch</b></td>
            <td>{{ $memo->supplier->bank_branch }}</td>
          </tr>
          <tr>
            <td><b>NPWP</b></td>
            <td>{{ $memo->supplier->npwp }}</td>
          </tr>
		@endif
        @endif
      	</table>

	{{-- @if ($memo->finances->count()>0)
	<h4>Data Finance Support</h4>
	<hr>
		<table class="table">
			@foreach ($memo->finances as $mf)
				<tr>
	          		<td>{{ $mf->group_leasing }}</td>
	          		<td>{{ number_format($mf->total) }}</td>
	        	</tr>
			@endforeach	        
      	</table>
	@endif --}}

</body></html>
