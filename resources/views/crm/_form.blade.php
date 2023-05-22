<div class="box box-success">
	<div class="box-header with-border">
    	<h3 class="box-title">Type</h3>
    	<div class="box-tools pull-right">
      		<button type="button" class="btn btn-box-tool" data-widget="collapse">
        		<i class="fa fa-minus"></i>
      		</button>
    	</div>
  	</div>
  	<div class="box-body">
    	<div class="form-group">
			<div class="col-md-offset-2 col-md-10">
  				<label class="radio-inline">
    				{!! Form::radio('type_customer', 'Personal', null, ['class'=>'type_customer','checked'=>'checked', 'onchange'=>'getCheckbox()']) !!}
    				Personal
  				</label>
  				<label class="radio-inline">
    				{!! Form::radio('type_customer', 'Group', null, ['class'=>'type_customer','onchange'=>'getCheckbox()']) !!}
    				Group
  				</label>
  			</div>
		</div>
		<div class="form-group">
			{!! Form::label('type_list[]', 'Type Supplier', ['class'=>'col-md-2 control-label']) !!}
			<div class="col-md-10">
				{!! Form::select('type_list[]',$crmtypes, null,['id'=>'crmtypes','class'=>'form-control', 'multiple']) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::hidden('active_crm', null, ['class'=>'form-control']) !!}
			{!! Form::hidden('branch_id', null, ['class'=>'form-control']) !!}
		</div>
  	</div>

</div>

<div class="box box-success">
	<div class="box-header with-border">
    	<h3 class="box-title">Personal</h3>
    	<div class="box-tools pull-right">
      		<button type="button" class="btn btn-box-tool" data-widget="collapse">
        		<i class="fa fa-minus"></i>
      		</button>
    	</div>
  	</div>
  	<div class="box-body">
    	<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('nomor_crm', 'Nomor Supplier',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('nomor_crm', $crm_no, ['class' => 'form-control', 'disabled'=>'disabled']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('name_personal','Name',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('name_personal', null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('email_personal','Email',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('email_personal', null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('identity_number','Id.Number(KTP)',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('identity_number', null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('address_personal','Address',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('address_personal', null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('birthdate','Birthdate',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::input('date','birthdate', null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('birthplace','Birthplace',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('birthplace', null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('gender','Gender',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::select('gender',['Male'=>'Male','Female'=>'Female'], null,['id'=>'tag_list','class'=>'form-control']) !!}
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('rt','RT',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-4">
					{!! Form::text('rt', null, ['class' => 'form-control']) !!}
				</div>
				{!! Form::label('rw','RW',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-4">
					{!! Form::text('rw', null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('postalcode','Postalcode',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('postalcode', null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('kelurahan','Kelurahan',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('kelurahan', null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('kecamatan','Kecamatan', ['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('kecamatan', null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('kabupaten','Kabupaten',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('kabupaten', null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('city','City',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('city', null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('province','Province',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('province', null, ['class' => 'form-control']) !!}
				</div>	
			</div>
			<div class="form-group">
				{!! Form::label('phone_number','Phone Number',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('ponsel_number','Ponsel Number',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('ponsel_number', null, ['class' => 'form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('kk_number','Kartu Keluarga',['class'=>'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('kk_number', null, ['class' => 'form-control']) !!}
				</div>
			</div>
		</div>
  	</div>
</div>

<div class="box box-success">
	<div class="box-header with-border">
    	<h3 class="box-title">Group Info</h3>
    	<div class="box-tools pull-right">
      		<button type="button" class="btn btn-box-tool" data-widget="collapse">
        		<i class="fa fa-minus"></i>
      		</button>
    	</div>
  	</div>
  	<div class="box-body">
    	<div class="form-group">
			{!! Form::label('name_group','Company/Group Name',['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('name_group', null, ['class' => 'form-control supplier-group']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('address_group','Address Group',['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('address_group', null, ['class' => 'form-control supplier-group']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('npwp_group','Npwp Group',['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('npwp_group', null, ['class' => 'form-control supplier-group']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('email_group','Email Group',['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('email_group', null, ['class' => 'form-control supplier-group']) !!}
			</div>
		</div>
  	</div>
</div>