@extends('layout.admin')

@section('content-header')
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> Supplier
      <small>Edit Supplier</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="/supplier">Supplier</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>
@stop

@section('content')
  {!! Form::model($supplier, ['class'=>'form-horizontal', 'id'=>'formEditSupplier', 'method'=>'PUT', 'action'=>['SupplierController@update', $supplier->id]]) !!}
    @include('supplier._form',['editSupplier' => true])

    <div class="box-footer">
      <button type="submit" class="btn btn-success">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> Edit
      </button>
      <button type="submit" class="btn btn-default">Cancel</button>
    </div>
  </form>
@stop

@section('scripts')
  @include('supplier._js')
@stop