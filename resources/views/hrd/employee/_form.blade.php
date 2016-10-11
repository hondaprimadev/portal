<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Employee Data</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body">
    <div class="col-md-6">
      <div class="form-group">
        {!! Form::label('profile_picture', 'Profile Picture',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          <div class="outer-div">
            <div class="progress progress-body">
                      <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        <span id="progress-val"></span>
                      </div>
                  </div>

            @if ($nikStat == true)
              <div class="inner-div"><img id="profile_img"></div>
              <button type="button" class="btn-upload-profile fileinput-button">
                <i class="fa fa-camera" aria-hidden="true"></i>
              </button>
              <button type="button" class="btn-delete-profile" onclick="deletePicture()">
                <i class="fa fa-times" aria-hidden="true"></i>
              </button>
              <input type="hidden" id="profile_text" name="profile_text"/>
            @else             
              @if (empty($user->pictures->first()->filename))
                <div class="inner-div"><img id="profile_img"></div>
                <button type="button" class="btn-upload-profile fileinput-button">
                  <i class="fa fa-camera" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn-delete-profile" onclick="deletePicture()">
                  <i class="fa fa-times" aria-hidden="true"></i>
                </button>
                <input type="hidden" id="profile_text" name="profile_text"/>
              @else
                <div class="inner-div"><img id="profile_img" src="{{ route('hrd.employee.profile.get',$user->pictures->first()->filename) }}"></div>
                <button type="button" class="btn-upload-profile fileinput-button" style="display: none">
                  <i class="fa fa-camera" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn-delete-profile" onclick="deletePicture()" style="display: block">
                  <i class="fa fa-times" aria-hidden="true"></i>
                </button>
                <input type="hidden" id="profile_text" name="profile_text" value="{{ $user->pictures->first()->filename }}" />
              @endif
            @endif
          </div>
        </div>
      </div>
      @if ($nikStat == true)
        <div class="form-group">
          {!! Form::label('nik', 'Nik', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
            <label>
                <input type="checkbox" id="nik_auto" name="nik_auto" checked=checked> Auto
            </label>
              {!! Form::text('nik', null,['class'=> 'form-control','disabled']) !!}
            </div>
        </div>
      @else
        <div class="form-group">
          {!! Form::label('nik', 'Nik', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('nik', null,['id'=>'nik_edit', 'class'=> 'form-control','disabled']) !!}
            </div>
        </div>
      @endif
      
      <div class="form-group">
        {!! Form::label('name', 'Name', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('name', null,['class'=> 'form-control']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('address', 'Address', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {!! Form::text('address', null,['class'=> 'form-control']) !!}
          </div>
      </div>

      <div class="form-group">
        {!! Form::label('city', 'City', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {!! Form::text('city', null,['class'=> 'form-control']) !!}
          </div>
      </div>

      <div class="form-group">
        {!! Form::label('birthday', 'Birthday', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {!! Form::input('date','birthday', null,['class'=> 'form-control']) !!}
          </div>
      </div>

      <div class="form-group">
        {!! Form::label('birthplace', 'Birthplace', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {!! Form::text('birthplace', null,['class'=> 'form-control']) !!}
          </div>
      </div>

      <div class="form-group">
        {!! Form::label('phone', 'Phone', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {!! Form::text('phone', null,['class'=> 'form-control']) !!}
          </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        {!! Form::label('marrital', 'Marrital', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::label('marrital','Single') !!}
          {!! Form::radio('marrital', 'single',['class'=>'form-control']) !!}
          {!! Form::label('marrital','Married') !!}
          {!! Form::radio('marrital', 'married',['class'=>'form-control']) !!}
        </div>
      </div>

      <div class="form-group">
        {!! Form::label('bloodtype', 'Blood Type', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('blood_type', null,['class'=> 'form-control']) !!}
        </div>
      </div>

      <div class="form-group">
        {!! Form::label('zipcode', 'Zipcode', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('zipcode', null,['class'=> 'form-control']) !!}
        </div>
      </div>

      <div class="form-group">
        {!! Form::label('gender', 'Gender', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::label('gender','Male') !!}
          {!! Form::radio('gender', 'male',['class'=>'form-control']) !!}
          {!! Form::label('gender','Female') !!}
          {!! Form::radio('gender', 'female',['class'=>'form-control']) !!}
        </div>
      </div>

      <div class="form-group">
        {!! Form::label('email', 'Email', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::input('email','email', null,['class'=> 'form-control']) !!}
        </div>
      </div>

      <div class="form-group">
        {!! Form::label('mother_name', 'Mother Name', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('mother_name', null,['class'=> 'form-control']) !!}
        </div>
      </div>
    </div>
  </div>
</div>

<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Bank Account</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body">
    <div class="col-md-6">
      <div class="form-group">
        {!! Form::label('bank_account', 'Account Number', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('bank_account', null,['class'=> 'form-control']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('bank_name', 'Bank Name', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('bank_name', null,['class'=> 'form-control']) !!}
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        {!! Form::label('bank_branch', 'Branch', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('bank_branch', null,['class'=> 'form-control']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('npwp', 'Npwp', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('npwp', null,['class'=> 'form-control']) !!}
        </div>
      </div>
    </div>
  </div>
</div>

<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title">Job Status</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body">
    <div class="col-md-6">
      <div class="form-group">
        {!! Form::label('job_status', 'Job Status', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('job_status', ['Active'=>'Active', 'Skorsing'=>'Skorsing', 'Move'=>'Move', 'Retired'=>'Retired', 'Fired'=>'Fired'], null,[
          'class'=>'form-control']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('job_start', 'Job Start', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::input('date','job_start', null,['class'=> 'form-control']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('job_end', 'Job End', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::input('date','job_end', null,['class'=> 'form-control']) !!}
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        {!! Form::label('branch_id', 'Branch', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('branch_id', $branch, null,['class'=> 'form-control']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('department_id', 'Department', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('department_id', $depts, null,['class'=> 'form-control']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('position_id', 'Position', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::select('position_id', $position,null,['class'=> 'form-control']) !!}
        </div>
      </div>
    </div>
  </div>
</div>