@extends('layout.admin')

@section('content-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> Memo Setting
      <small>Setting Memo category & account</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="/memo">Memo</a></li>
      <li class="active"><a href="{{ route('memo.setting.index') }}">Category</a></li>
    </ol>
  </section>
@stop

@section('content')
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">
				Memo Setting {{ session('tab') }}
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
			<div class="row">
				<div class="col-md-12">
				<!-- Custom Tabs -->
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class= @if (session('tab')=='category') "active" @endif>
							<a href="#tab_1" data-toggle="tab">
								<i class="fa fa-flask" aria-hidden="true"></i> Category
							</a>
						</li>
						<li class=@if (session('tab')=='account') "active" @endif>
							<a href="#tab_2" data-toggle="tab">
								<i class="fa fa-certificate" aria-hidden="true"></i> Account
							</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane @if (session('tab')=='category') active @endif" id="tab_1">
							<div class="col-md-12 box-body-header">  
						        <div class="col-md-8">
						          	<button class="btn btn-red" onclick="AddCat()" data-toggle="tooltip" data-placement="bottom" title="Add Category Memo">
						          		<i class="fa fa-plus" aria-hidden="true"></i> New
						          	</button>
						            <button type="button" class="btn btn-red" onclick="deleteCat()" data-toggle="tooltip" data-placement="bottom" title="Delete Deparment">
						              <i class="fa fa-trash" aria-hidden="true"></i> Delete
						            </button>
						            <span style="margin-left: 10px;"">
				                  		<i class="fa fa-filter" aria-hidden="true"></i> Filter
				                  		{!! Form::select('account_id', $ja,null, ['class'=>'btn btn-red', 'id'=>'account_id']) !!}
				                  		{!! Form::select('department_id',$department, null, ['class'=>'btn btn-red', 'id'=>'department_id']) !!}
				                	</span>
						        </div>
				        		<div class="col-md-4">
				          			<input type="text" id="searchDtbox" class="form-control" placeholder="search...">
				        		</div>
				      		</div>
				      		{!! Form::open(['url'=> '/memo/category/delete','id'=>'formCatDelete','method'=>'POST']) !!}
								<table class="table table-striped" id="tableCategory">
									<thead>
										<tr>
											<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
											<th>ID</th>
											<th>Name</th>
											<th>Department</th>
											<th>Account</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($mc as $mc)
											<tr>
												<td>
													<input type="checkbox" id="idTableCat" name="id[]" class="checkin" value="{{ $mc->id }}"/>
												</td>
												<td>
													{{$mc->id}}
												</td>
												<td>
													{{ $mc->name }}
													<input type="hidden" id="nameTableCat" value="{{ $mc->name }}">
												</td>
												<td>
													{{ $mc->department->name }}
													<input type="hidden" id="departmentTableCat" value="{{ $mc->department_id }}">
												</td>
												<td>
													{{ $mc->journal->account_name }}
													<input type="hidden" id="accountTableCat" value="{{ $mc->account_id }}">
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							{!! Form::close() !!}
						</div>
						<!-- /.tab-pane -->

						<div class="tab-pane @if (session('tab')=='account') active @endif" id="tab_2">
							<div class="col-md-12 box-body-header">  
						        <div class="col-md-8">
						          	<button class="btn btn-red" onclick="AddAccount()" data-toggle="tooltip" data-placement="bottom" title="Add New Department">
						          		<i class="fa fa-plus" aria-hidden="true"></i> New
						          	</button>
						            <button type="button" class="btn btn-red" onclick="deleteAccount()" data-toggle="tooltip" data-placement="bottom" title="Delete Deparment">
						              <i class="fa fa-trash" aria-hidden="true"></i> Delete
						            </button>
						            <span style="margin-left: 10px;"">
				                  		<i class="fa fa-filter" aria-hidden="true"></i> Filter
				                	</span>
						        </div>
				        		<div class="col-md-4">
				          			<input type="text" id="searchJournalbox" class="form-control" placeholder="search...">
				        		</div>
				      		</div>
				      		{!! Form::open(['url'=> '/memo/account/delete','id'=>'formAccountDelete','method'=>'POST']) !!}
								<table class="table table-striped" id="tableAccount">
									<thead>
										<tr>
											<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
											<th>ID</th>
											<th>Name</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($journal as $j)
											<tr>
												<td>
													<input type="checkbox" id="idTableAccount" name="id[]" class="checkin" value="{{ $j->id }}"/>
												</td>
												<td>
													{{$j->id}}
													<input type="hidden" id="idTableAccount" value="{{ $j->id }}">
												</td>
												<td>
													{{ $j->account_name }}
													<input type="hidden" id="nameTableAccount" value="{{ $j->account_name }}">
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							{!! Form::close() !!}
						</div>
						<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- nav-tabs-custom -->
				</div>
			</div>
			
		</div>
	</div>
	@include('memo.setting._modal')
@stop
@section('scripts')
	<script type="text/javascript">
		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      		$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
   		});   
	</script>
	@include('memo.setting._jsCategory')
	@include('memo.setting._jsJournal')
@stop

