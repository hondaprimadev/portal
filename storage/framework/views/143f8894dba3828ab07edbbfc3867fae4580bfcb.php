<div class="col-md-6">
	<div class="form-group has-feedback<?php echo e($errors->has('prepayment_total') ? ' has-error' : ''); ?>">
          <?php echo Form::label('prepayment_total', 'Request prepayment', ['class'=>'col-sm-2 control-label']); ?>

         <div class="col-sm-10">
            <?php if($edit): ?>
            <?php echo Form::text('prepayment_total', number_format($memo->prepayment_total), ['class'=> 'form-control',"onkeyup"=>"formatNumber(this)", "onkeypress"=>"formatNumber(this)"]); ?>

            <?php else: ?>
            <?php echo Form::text('prepayment_total', old('prepayment_total'), ['class'=> 'form-control',"onkeyup"=>"formatNumber(this)", "onkeypress"=>"formatNumber(this)"]); ?>  
            <?php endif; ?>
            
            <?php if($errors->has('prepayment_total')): ?>
                  <span class="help-block">
                      <strong><?php echo e($errors->first('prepayment_total')); ?></strong>
                  </span>
            <?php endif; ?>
         </div>
	</div>
</div>
