@extends('layout.admin')

@section('styles')
  <style type="text/css">
    select { width: 5.5em }
  </style>
@stop
@section('content-header')
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> Team Marketing
      <small>Setting Team Marketing</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#">Marketing</a></li>
      <li class="active"><a href="/marketing/team">Team Marketing</a></li>
    </ol>
  </section>
@stop

@section('content')
	<div class="box box-primary">
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

  	{!! Form::open(['route'=>'marketing.team.post', 'method'=>'post', 'enctype'=>'multipart/form-data', 'class'=>'form-horizontal' ,'id'=>'formTeam']) !!}
    <div class="box-body">
      <div class="form-group">
        <label for="branch_id" class="col-sm-2 control-label">Branch</label>
        <div class="col-sm-4">
          {!! Form::select('branch_id', $branches,$branch ,['class'=>'form-control', 'id'=>'branch']) !!}
        </div>
      </div>
      <div class="form-group">
        <label for="pic_id" class="col-sm-2 control-label">PIC</label>
        <div class="col-sm-4">
          {!! Form::select('pic_id',$pic ,$pic_id ,['class'=>'form-control','id'=>'pic_id']) !!}
        </div>
      </div>
      <div class="form-group">
      	<label for="sales" class="col-sm-2 control-label"></label>
      	<div class="col-sm-10">
      		<table>
      		<tr>
      			<th>All Sales</th>
      			<th></th>
      			<th>Team Pic</th>
      		</tr>
			<tr>
				<td>
					{!! Form::select('sales[]', $sales, null, ['class'=>'form-control selectionList','id'=>'LEFT_MENU','size'=>'10','multiple']) !!}
				</td>
				<td valign="middle">
					<p><buton type="button" class="btn btn-primary" id="moveRight" onclick="moveOption('LEFT_MENU','RIGHT_MENU')"><i class='fa fa-arrow-right' aria-hidden='true'></i></buton></p>
					<p><buton type="button" class="btn btn-primary" id="moveLeft" onclick="moveOption('RIGHT_MENU','LEFT_MENU')"><i class='fa fa-arrow-left' aria-hidden='true'></i></buton></p>
				</td>
				<td>
					{!! Form::select('sales_pic[]', $sales_pic, null, ['class'=>'form-control selectionList','id'=>'RIGHT_MENU','size'=>'10','multiple']) !!}
				</td>
			</tr>
			</table>
      	</div>
      </div>	
    </div>
    
    <div class="box-footer">
      <button type="button" class="btn btn-default">Cancel</button>
      <button type="button" class="btn btn-info pull-right" onclick="addTeam()">Upload</button>
    </div>
    
  	{!! Form::close() !!}
@stop

@section('scripts')
	<script type="text/javascript">
    $('#branch').on('change', function(){
      var branch_id = $('#branch').val();
      window.location= "{{  request()->url() }}?b="+branch_id;
    });

    $('#pic_id').on('change', function(){
      var branch_id = $('#branch').val();
      var pic_id = $('#pic_id').val();
      window.location = "{{ request()->url() }}?b="+branch_id+"&p="+pic_id;
    });

		function addTeam() 
		{
			$('.selectionList option').prop('selected', true);
			$('#formTeam').submit();
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