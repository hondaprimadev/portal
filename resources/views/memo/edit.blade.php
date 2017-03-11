@extends('layout.admin')

@section('head')
  <!-- dropzone css -->
  <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
@stop
@section('content-header')
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> Memo Revise
      <small>Memo Revise</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="/memo">Memo</a></li>
      <li class="active">Create</li>
    </ol>
  </section>
@stop

@section('content')
  {!! Form::model($memo, array('route'=>['memo.revise.update',$memo->token], 'class'=>'form-horizontal', 'id'=>'formMemo' )) !!}
    @include('memo._editForm', ['edit'=>true])
    <div class="box-footer">
      <button type="submit" class="btn btn-success">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
      </button>
      <button type="button" class="btn btn-default" onclick="window.location='{{ url("/memo") }}';">Cancel</button>
    </div>
  {!! Form::close() !!}
@stop

@section('scripts')
  @include('memo._js')
  <script type="text/javascript">
    getSupplier($('#supplier_type').val(), {{ $memo->branch_id }},{{ $memo->supplier_id }});
    getSupplierId({{ $memo->supplier_id }}, $('#supplier_type').val());
  </script>
@stop