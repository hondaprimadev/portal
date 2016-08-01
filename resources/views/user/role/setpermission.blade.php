@extends('layout.admin')

@section('styles')
  <style type="text/css">
    select { width: 5.5em }
  </style>
@stop
@section('content-header')
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> Role Management
      <small>Setting Role's permission </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">User</a></li>
      <li><a href="{{ route('admin.user.role.index') }}">Role</a></li>
      <li class="active">Setting</li>
    </ol>
  </section>
@stop

@section('content')
	<div class="box box-danger">
    	<div class="box-header">
	    	<div class="box-tools pull-right">
	      		<button type="button" class="btn btn-box-tool" data-widget="collapse">
	        		<i class="fa fa-minus"></i>
	      		</button> 	
	      		<button type="button" class="btn btn-box-tool" data-widget="remove">
	        		<i class="fa fa-remove"></i>
	      		</button> 	
	    	</div>
  		</div>

  	{!! Form::open(['route'=>'admin.user.role.setting.post', 'method'=>'post', 'enctype'=>'multipart/form-data', 'class'=>'form-horizontal' ,'id'=>'formRole']) !!}
    <div class="box-body">
      <div class="form-group">
        <label for="role_id" class="col-sm-2 control-label">Role</label>
        <div class="col-sm-4">
          {!! Form::select('role_id',$roles ,$r ,['class'=>'form-control','id'=>'role_id']) !!}
        </div>
      </div>
      <div class="form-group">
      	<label for="sales" class="col-sm-2 control-label"></label>
      	<div class="col-sm-10">
      		<table>
      		<tr>
      			<th>All Permission</th>
      			<th></th>
      			<th>Set Permission</th>
      		</tr>
			<tr>
				<td>
					{!! Form::select('permission[]', $permissions, null, ['class'=>'form-control selectionList','id'=>'LEFT_MENU','size'=>'10','multiple']) !!}
				</td>
				<td valign="middle">
					<p><buton type="button" class="btn btn-re" id="moveRight" onclick="moveOption('LEFT_MENU','RIGHT_MENU')"><i class='fa fa-arrow-right' aria-hidden='true'></i></buton></p>
					<p><buton type="button" class="btn btn-re" id="moveLeft" onclick="moveOption('RIGHT_MENU','LEFT_MENU')"><i class='fa fa-arrow-left' aria-hidden='true'></i></buton></p>
				</td>
				<td>
					{!! Form::select('permission_role[]', $permission_role, null, ['class'=>'form-control selectionList','id'=>'RIGHT_MENU','size'=>'10','multiple']) !!}
				</td>
			</tr>
			</table>
      	</div>
      </div>	
      <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
          <button type="button" class="btn btn-red" onclick="addSetting()">
            <i class="fa fa-floppy-o"></i> Save
          </button>    
        </div>
      </div>
    </div>
  	{!! Form::close() !!}
@stop

@section('scripts')
	<script type="text/javascript">
    $('#role_id').on('change', function(){
      var role_id = $('#role_id').val();
      window.location = "{{ request()->url() }}?r="+role_id;
    });

		function addSetting() 
		{
			$('.selectionList option').prop('selected', true);
			$('#formRole').submit();
		}
		function moveOption( fromID, toID )
		{
			var i = document.getElementById( fromID ).selectedIndex;
			var o = document.getElementById( fromID ).options[ i ];
			var theOpt = new Option( o.text, o.value, false, false );

			document.getElementById( toID ).options[document.getElementById( toID ).options.length] = theOpt;
			document.getElementById( fromID ).options[ i ] = null;
		}
	</script>
@stop