@extends('layout.admin')

@section('content-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-bar-chart" aria-hidden="true"></i> Dashboard
      <small>Portal Honda Prima Dashboard</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="/">Dashboard</a></li>
    </ol>
  </section>
@stop

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
			<h4>Welcome, {{ auth()->user()->name }}</h4>
          	@if (auth()->user()->pictures()->count() > 0)
				<img src="{{ route('hrd.employee.profile.get', auth()->user()->pictures()->first()->filename) }}" class="img-circle" alt="User Image">
           	@else
           		<img src="/admin-lte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
           	@endif
        </div>
      </div>
    </div>
  </div>
  <!-- /.Table Rank -->

@stop