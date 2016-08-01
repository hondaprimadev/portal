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
      <li class="active">Create</li>
    </ol>
  </section>
@stop

@section('content')
  {!! Form::open(['route'=>'hrd.employee.store','class'=>'form-horizontal']) !!}
    @include('hrd.employee._form',['nikStat' => true])

    <div class="box-footer">
      <button type="submit" class="btn btn-success">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
      </button>
      <button type="submit" class="btn btn-default">Cancel</button>
    </div>
  </form>
@stop

@section('scripts')
  @include('hrd.employee._js')
@stop