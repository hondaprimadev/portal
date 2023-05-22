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
        <?php echo Form::label('profile_picture', 'Profile Picture',['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <div class="outer-div">
            <div class="progress progress-body">
                      <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        <span id="progress-val"></span>
                      </div>
                  </div>

            <?php if($nikStat == true): ?>
              <div class="inner-div"><img id="profile_img"></div>
              <button type="button" class="btn-upload-profile fileinput-button">
                <i class="fa fa-camera" aria-hidden="true"></i>
              </button>
              <button type="button" class="btn-delete-profile" onclick="deletePicture()">
                <i class="fa fa-times" aria-hidden="true"></i>
              </button>
              <input type="hidden" id="profile_text" name="profile_text"/>
            <?php else: ?>             
              <?php if(empty($user->pictures->first()->filename)): ?>
                <div class="inner-div"><img id="profile_img"></div>
                <button type="button" class="btn-upload-profile fileinput-button">
                  <i class="fa fa-camera" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn-delete-profile" onclick="deletePicture()">
                  <i class="fa fa-times" aria-hidden="true"></i>
                </button>
                <input type="hidden" id="profile_text" name="profile_text"/>
              <?php else: ?>
                <div class="inner-div"><img id="profile_img" src="<?php echo e(route('hrd.employee.profile.get',$user->pictures->first()->filename)); ?>"></div>
                <button type="button" class="btn-upload-profile fileinput-button" style="display: none">
                  <i class="fa fa-camera" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn-delete-profile" onclick="deletePicture()" style="display: block">
                  <i class="fa fa-times" aria-hidden="true"></i>
                </button>
                <input type="hidden" id="profile_text" name="profile_text" value="<?php echo e($user->pictures->first()->filename); ?>" />
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php if($nikStat == true): ?>
        <div class="form-group">
          <?php echo Form::label('nik', 'Nik', ['class'=>'col-sm-2 control-label']); ?>

            <div class="col-sm-10">
            <label>
                <input type="checkbox" id="nik_auto" name="nik_auto" checked=checked> Auto
            </label>
              <?php echo Form::text('nik', null,['class'=> 'form-control','disabled']); ?>

            </div>
        </div>
      <?php else: ?>
        <div class="form-group">
          <?php echo Form::label('id', 'Nik', ['class'=>'col-sm-2 control-label']); ?>

            <div class="col-sm-10">
              <?php echo Form::text('id', $user->id,['id'=>'nik_edit', 'class'=> 'form-control']); ?>

            </div>
        </div>
      <?php endif; ?>
      
      <div class="form-group">
        <?php echo Form::label('name', 'Name', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('name', null,['class'=> 'form-control']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('address', 'Address', ['class'=>'col-sm-2 control-label']); ?>

          <div class="col-sm-10">
            <?php echo Form::text('address', null,['class'=> 'form-control']); ?>

          </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('city', 'City', ['class'=>'col-sm-2 control-label']); ?>

          <div class="col-sm-10">
            <?php echo Form::text('city', null,['class'=> 'form-control']); ?>

          </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('birthday', 'Birthday', ['class'=>'col-sm-2 control-label']); ?>

          <div class="col-sm-10">
            <?php echo Form::input('date','birthday', null,['class'=> 'form-control']); ?>

          </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('birthplace', 'Birthplace', ['class'=>'col-sm-2 control-label']); ?>

          <div class="col-sm-10">
            <?php echo Form::text('birthplace', null,['class'=> 'form-control']); ?>

          </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('phone', 'Phone', ['class'=>'col-sm-2 control-label']); ?>

          <div class="col-sm-10">
            <?php echo Form::text('phone', null,['class'=> 'form-control']); ?>

          </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <?php echo Form::label('marrital', 'Marrital', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::label('marrital','Single'); ?>

          <?php echo Form::radio('marrital', 'single',['class'=>'form-control']); ?>

          <?php echo Form::label('marrital','Married'); ?>

          <?php echo Form::radio('marrital', 'married',['class'=>'form-control']); ?>

        </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('bloodtype', 'Blood Type', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('blood_type', null,['class'=> 'form-control']); ?>

        </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('zipcode', 'Zipcode', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('zipcode', null,['class'=> 'form-control']); ?>

        </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('gender', 'Gender', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::label('gender','Male'); ?>

          <?php echo Form::radio('gender', 'male',['class'=>'form-control']); ?>

          <?php echo Form::label('gender','Female'); ?>

          <?php echo Form::radio('gender', 'female',['class'=>'form-control']); ?>

        </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('email', 'Email', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::input('email','email', null,['class'=> 'form-control']); ?>

        </div>
      </div>

      <div class="form-group">
        <?php echo Form::label('mother_name', 'Mother Name', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('mother_name', null,['class'=> 'form-control']); ?>

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
        <?php echo Form::label('bank_account', 'Account Number', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('bank_account', null,['class'=> 'form-control']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('bank_name', 'Bank Name', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('bank_name', null,['class'=> 'form-control']); ?>

        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <?php echo Form::label('bank_branch', 'Branch', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('bank_branch', null,['class'=> 'form-control']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('npwp', 'Npwp', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::text('npwp', null,['class'=> 'form-control']); ?>

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
        <?php echo Form::label('job_status', 'Job Status', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('job_status', ['Active'=>'Active', 'Skorsing'=>'Skorsing', 'Move'=>'Move', 'Retired'=>'Retired', 'Fired'=>'Fired'], null,[
          'class'=>'form-control']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('job_start', 'Job Start', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::input('date','job_start', null,['class'=> 'form-control']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('job_end', 'Job End', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::input('date','job_end', null,['class'=> 'form-control']); ?>

        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <?php echo Form::label('branch_id', 'Branch', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('branch_id', $branch, null,['class'=> 'form-control']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('department_id', 'Department', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('department_id', $depts, null,['class'=> 'form-control']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('position_id', 'Position', ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('position_id', $position,null,['class'=> 'form-control']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('grade', 'Grade' ,['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('grade', ['0'=>'no grade','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7'],null,['class'=> 'form-control']); ?>

        </div>
      </div>
      <div class="form-group">
        <?php echo Form::label('grade_marketing', 'Grade Marketing' ,['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
          <?php echo Form::select('grade_marketing', ['0'=>'Not Sales','Silver'=>'Silver','Gold'=>'Gold','Platinum'=>'Platinum'],null,['class'=> 'form-control']); ?>

        </div>
      </div>
    </div>
  </div>
</div>