@extends('layout.admin')

@section('content-header')
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> HRD Management
      <small>Emplyoee / User Data Manajemen</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Hrd</a></li>
      <li><a href="{{ route('hrd.employee.index') }}">Employee</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>
@stop

@section('content')
  {!! Form::model($user, ['class'=>'form-horizontal', 'id'=>'formEditEmployee', 'method'=>'PUT', 'action'=>['HrdEmployeeController@update', $user->id]]) !!}
    @include('hrd.employee._form',['nikStat' => false])

    <div class="box-footer">
      <button type="submit" class="btn btn-success">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> Update
      </button>
      <button type="submit" class="btn btn-default">Cancel</button>
    </div>
  {!! Form::close() !!}
@stop

@section('scripts')
  @include('hrd.employee._js')
@stop