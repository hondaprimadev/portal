<div class="col-md-6">
	<div class="form-group">
		{!! Form::label('prepayment_total', 'Request prepayment',['class'=>'col-sm-2 control-label']) !!}  
		<div class="col-sm-10">
			{!! Form::text('prepayment_total', number_format($memo->prepayment_total), ['class'=> 'form-control',"onkeyup"=>"formatNumber(this)", "onkeypress"=>"formatNumber(this)",'readonly'=>'readonly']) !!}
		</div>
	</div>
</div>
