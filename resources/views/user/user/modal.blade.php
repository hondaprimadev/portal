{{-- Create Modal --}}
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="Create User">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="CreateColor">Create User</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(['url'=> '/admin/user/user']) !!}
					<div class="outer-div">
						<div class="progress progress-body">
              				<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                				<span id="progress-val"></span>
              				</div>
            			</div>
						<div class="inner-div"><img class="profile_img"></div>
						<button type="button" class="btn-upload-profile fileinput-button">
							<i class="fa fa-camera" aria-hidden="true"></i>
						</button>
						<button type="button" class="btn-delete-profile" onclick="deletePicture()">
							<i class="fa fa-times" aria-hidden="true"></i>
						</button>
						<input type="hidden" class="profile_text" name="profile_text"/>
					</div>
					<div class="form-group">
						{!! Form::label('name', 'Name:') !!}
						{!! Form::text('name',null,['class'=>'form-control']) !!}
						
						{!! Form::label('email', 'Email:') !!}
						{!! Form::text('email',null,['class'=>'form-control']) !!}
						
						{!! Form::label('phone', 'Phone:') !!}
						{!! Form::text('phone',null,['class'=>'form-control']) !!}

						{!! Form::label('notif', 'Notif:') !!}
						{!! Form::text('notif',null,['class'=>'form-control']) !!}

						{!! Form::label('dealer_id', 'Dealer:') !!}
						{!! Form::select('dealer_id',$branch,null,['class'=>'form-control']) !!}

						{!! Form::label('role', 'Role:') !!}
						{!! Form::select('role[]',$roles, null, ['class'=>'form-control','id'=>'idRole', 'multiple'=>'multiple']) !!}

						{!! Form::label('password', 'Password:') !!}
						{!! Form::input('password','password',null,['class'=>'form-control']) !!}

						{!! Form::label('password_confirmation', 'Password Confirmation:') !!}
						{!! Form::input('password','password_confirmation',null,['class'=>'form-control']) !!}
					</div>
					{!! Form::submit('save' , ['class' =>'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="Edit User">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="EditType">Edit User</h4>
			</div>
			<div class="modal-body">
				{!! Form::open(['url'=> '/admin/user/user','method'=>"PATCH",'id'=>'editUser']) !!}
					<div class="outer-div">
						<div class="progress progress-body">
              				<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                				<span id="progress-val"></span>
              				</div>
            			</div>
						<div class="inner-div"><img class="profile_img"></div>
						<button type="button" class="btn-upload-profile fileinput-button">
							<i class="fa fa-camera" aria-hidden="true"></i>
						</button>
						<button type="button" class="btn-delete-profile" onclick="deletePicture()">
							<i class="fa fa-times" aria-hidden="true"></i>
						</button>
						<input type="hidden" class="profile_text" name="profile_text"/>
					</div>
					<div class="form-group">
						{!! Form::label('name', 'Name:') !!}
						{!! Form::text('name',null,['class'=>'form-control','id'=>'nameUser']) !!}
						
						{!! Form::label('email', 'Email:') !!}
						{!! Form::text('email',null,['class'=>'form-control','id'=>'emailUser']) !!}
						
						{!! Form::label('phone', 'Phone:') !!}
						{!! Form::text('phone',null,['class'=>'form-control','id'=>'phoneUser']) !!}

						{!! Form::label('notif', 'Notif:') !!}
						{!! Form::text('notif',null,['class'=>'form-control','id'=>'notifUser']) !!}

						{!! Form::label('dealer_id', 'Dealer:') !!}
						{!! Form::select('dealer_id',$branch,null,['class'=>'form-control','id'=>'dealerUser']) !!}

						{!! Form::label('role', 'Role:') !!}
						{!! Form::select('role[]',$roles, null, ['class'=>'form-control','id'=>'roleUser', 'multiple'=>'multiple']) !!}

						{!! Form::label('password', 'Password:') !!}
						{!! Form::input('password','password',null,['class'=>'form-control']) !!}

						{!! Form::label('password_confirmation', 'Password Confirmation:') !!}
						{!! Form::input('password','password_confirmation',null,['class'=>'form-control']) !!}
					</div>
					{!! Form::submit('Update' , ['class' =>'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="Delete User">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="CreateMerk">Please Confirm</h4>
			</div>
			<div class="modal-body">
				<p class="lead">
            	<i class="fa fa-question-circle fa-lg"></i>  
            		Are you sure you want to delete this User?
          		</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            	<button type="submit" class="btn btn-danger" onclick=deleteUser()><i class="fa fa-times-circle"></i> Yes
			</div>
		</div>
	</div>
</div>