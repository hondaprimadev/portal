@extends('layout.admin')

@section('content-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> Upload Data Employee
      <small>importing csv / excel to database </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="/upload">Upload</a></li>
      <li class="active"><a href="/upload/hr">Upload HR</a></li>
    </ol>
  </section>
@stop

@section('content')
  <div class="box box-primary">
    <div class="box-header">
      <h3>
        Upload HR
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

  {!! Form::open(['url'=>'upload/hr', 'method'=>'post', 'enctype'=>'multipart/form-data', 'class'=>'form-horizontal']) !!}
    <div class="box-body">
      <div class="form-group">
        <label for="file" class="col-sm-2 control-label">File</label>
        <div class="col-sm-4">
          {!! Form::file('import_hr', null, ['class'=>'form-control']) !!}
        </div>
      </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      <button type="submit" class="btn btn-default">Cancel</button>
      <button type="submit" class="btn btn-info pull-right">Upload</button>
    </div>
    <!-- /.box-footer -->
  {!! Form::close() !!}

@stop