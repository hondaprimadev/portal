@extends('layout.admin')

@section('content-header')
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> Memo
      <small>Memo approval budget</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Memo</a></li>
      <li class="active">Create</li>
    </ol>
  </section>
@stop

@section('content')
  {!! Form::model($memo = new \App\Memo, ['route'=>'memo.prepayment.store','class'=>'form-horizontal','id'=>'formMemo']) !!}
    @include('memo._form', ['edit'=>false,'prepayment'=>true])

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
@stop