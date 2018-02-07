<div class="col-md-6">
	<div class="form-group has-feedback{{ $errors->has('prepayment_total') ? ' has-error' : '' }}">
          {!! Form::label('prepayment_total', 'Request prepayment', ['class'=>'col-sm-2 control-label']) !!}
         <div class="col-sm-10">
            @if ($edit)
            {!! Form::text('prepayment_total', number_format($memo->prepayment_total), ['class'=> 'form-control',"onkeyup"=>"formatNumber(this)", "onkeypress"=>"formatNumber(this)"]) !!}
            @else
            {!! Form::text('prepayment_total', old('prepayment_total'), ['class'=> 'form-control',"onkeyup"=>"formatNumber(this)", "onkeypress"=>"formatNumber(this)"]) !!}  
            @endif
            
            @if ($errors->has('prepayment_total'))
                  <span class="help-block">
                      <strong>{{ $errors->first('prepayment_total') }}</strong>
                  </span>
            @endif
         </div>
	</div>
</div>
