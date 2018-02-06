@extends('layout.admin')

@section('content-header')
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> Memo
      <small>Memo approval budget</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Memo</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>
@stop

@section('content')
  {!! Form::model($memo, ['route'=>['memo.prepayment.update',$memo->token],'class'=>'form-horizontal','id'=>'formMemo','method'=>'PATCH']) !!}
    @include('memo._form', ['edit'=>true,'prepayment'=>true])

    <div class="box-footer">
      <button type="submit" class="btn btn-success">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
      </button>
      <button type="button" class="btn btn-default">Cancel</button>
    </div>
  </form>
@stop

@section('scripts')
  @include('memo._js')
  <script type="text/javascript">
    getSupplier($('#supplier_type').val(), {{ $memo->branch_id }},{{ $memo->supplier_id }});
    getSupplierId({{ $memo->supplier_id }}, $('#supplier_type').val());
  </script>
@stop