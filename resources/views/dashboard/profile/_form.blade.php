<div class="box box-danger">
  <div class="box-header with-border">
    <h3 class="box-title">User Profile</h3>

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
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        {!! Form::label('alias', 'Name(alias)', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::text('alias', null,['class'=> 'form-control']) !!}
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
        {!! Form::label('phone', 'Phone', ['class'=>'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            {!! Form::text('phone', null,['class'=> 'form-control']) !!}
          </div>
      </div>
      <div class="form-group">
        {!! Form::label('email', 'Email', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::input('email','email', null,['class'=> 'form-control']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('password', 'Password',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::input('password','password',null, ['class'=>'form-control']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('password_confirmation', 'Password Confirmation',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          {!! Form::input('password','password_confirmation',null, ['class'=>'form-control']) !!}
        </div>
      </div>
    </div>

  </div>
</div>