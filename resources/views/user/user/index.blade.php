@extends('layout.admin')

@section('content-header')
	<section class="content-header">
      <h1>
        <i class="fa fa-newspaper-o"></i> User
        <small>User Manajemen</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">User</a></li>
        <li class="active">Index</li>
      </ol>
    </section>
@stop

@section('content')
	<div class="box box-warning">
		<div class="box-header">
			<h3 class="box-title">
				Tables User
			</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse">
					<i class="fa fa-minus"></i>
				</button>
				<button type="button" class="btn btn-box-tool" data-widget="remove">
					<i class="fa fa-remove"></i>
				</button>
			</div>
		</div>

		<div class="box-body">
			<div class="col-md-12 box-body-header">  
        <div class="col-md-8">
            <button type="button" class="btn btn-red" onclick="addUser()">
              <i class="fa fa-user-plus" aria-hidden="true"></i> New
            </button>
            <button type="button" class="btn btn-red" onclick="DeleteUser()">
              <i class="fa fa-trash" aria-hidden="true"></i> Delete
            </button>
            <span style="margin-left: 10px;">
            <i class="fa fa-filter" aria-hidden="true"></i> Filter
            {!! Form::select('branch_id_sort', $branches, null, ['class'=>'btn btn-red', 'id'=>'branch_id_sort']) !!}
          </span>
        </div>

        <div class="col-md-4">
          <input type="text" id="searchDtbox" class="form-control" placeholder="search...">
        </div>
      </div>

			{!! Form::open(['url'=>'admin/user/user/delete','id'=>'formUserDelete']) !!}
				<table id="tableUser" class="table table-striped table-color">
					<thead>
						<tr>
							<th data-sortable="false"><input type="checkbox" id="check_all"/></th>
              <th>Nik</th>
							<th>Name</th>
							<th>Email</th>
							<th>Branch</th>
							<th>Role</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
            @foreach ($users as $user)
              <tr>
                <td>
                    <input type="checkbox" id="idTableUser" value="{{ $user->id }}" name="id[]" class="checkin">
                </td>
                <td>
                  {{ $user->id }}
                </td>
                <td>
                  {{ $user->name }}
                  <input type="hidden" id="nameTableUser" value="{{ $user->name }}">
                </td>
                <td>
                  {{ $user->email }}
                  <input type="hidden" id="emailTableUser" value="{{ $user->email }}">
                </td>
                <td> 
                  @if ($user->branch()->count() > 0)
                    {{ $user->branch->name }}
                  @endif
                </td>
                <td>
                  @if ($user->roles()->count() > 0)
                    @foreach ($user->roles as $role)
                      {{ $role->name }}, 
                    @endforeach
                    <input type="hidden" id="roleTableUser" value="{{ $user->roles->lists('id') }}"/>
                  @endif
                </td>
                <td>{{ $user->created_at }}</td>
              </tr>
            @endforeach
          </tbody>
				</table>
			{!! Form::close() !!}
		</div>
	</div>

	@include('user.user.modal')
@stop

@section('scripts')
	<script type="text/javascript">
		var tableUser = $("#tableUser").DataTable({
      "sDom": 'rt',
      "scrollY":        "50vh",
      "scrollCollapse": true,
      "paging":         false
    });
		$("#searchDtbox").keyup(function() {
        	tableUser.search($(this).val()).draw();
    });
    $('#branch_id_sort').on('change', function () {
      tableUser.columns(4).search( this.value ).draw();
    });

    /*dropzone*/
		var myDropzone = new Dropzone(document.body, { 
			// Make the whole body a dropzone
        	url: "/",
        	paramName: "profile_picture",
        	createImageThumbnails: false,
        	previewTemplate : '<div style="display:none"></div>',
        	parallelUploads: 20,
        	clickable: ".fileinput-button",
        	// Define the element that should be used as click trigger to select files.
      	});

		myDropzone.on("sending", function(file, xhr, formData){

			console.log('token', $('[name=_token').val());
			console.log('upload started', file);

			$('.progress').show();
			formData.append("_token", $('[name=_token').val());
		});

      	myDropzone.on("totaluploadprogress", function(progress){
        	console.log("progress", progress);
        	$('.progress-bar').width(progress + '%');
        	$('#progress-val').text(progress + '%');
      	});

      	myDropzone.on("queuecomplete", function(progress){
        	$('.progress').hide();
      	});

      	myDropzone.on("success", function(file, response){
      		console.log('url', response.urltemp);
      		console.log('filename', response.filename);
        	$('.profile_img').attr('src', response.urltemp + '?' + new Date().getTime());
        	$('.profile_text').val(response.filename);
        	$( ".btn-upload-profile" ).hide();
      		$( ".btn-delete-profile" ).show();

      	});
      	/*End Dropzone*/
      	

    	$('#tableUser tbody').on('dblclick', 'tr', function () {
    		if ( $(this).hasClass('selected') ) {
    			$(this).removeClass('selected');
    		}
    		else {
    			tableUser.$('tr.selected').removeClass('selected');
    			$(this).addClass('selected');
        		
        		var id = $(this).find('#idTableUser').val();
        		var name = $(this).find('#nameTableUser').val();
        		var email = $(this).find('#emailTableUser').val();
        		var phone = $(this).find('#phoneTableUser').val();
        		var notif = $(this).find('#notifTableUser').val();
        		var dealer = $(this).find('#dealerTableUser').val();
        		var role = $(this).find('#roleTableUser').val();
        		if (!$(this).find('#pictureTableUser').val()) {
        			var picture = 0;
        			var urlpicture = 0;
        		}
        		else {
        			var picture = $(this).find('#pictureTableUser').val();
        			var urlpicture = $(this).find('#urlpictureTableUser').val();
        		}

        		editUser(id, name, email, phone, notif, dealer, role, urlpicture, picture);
    		}
    	});

    	function addUser() {
    		$('.profile_img').attr('src', '');
      		$( ".btn-upload-profile" ).show();
      		$( ".btn-delete-profile" ).hide();
    		$("#createUserModal").modal("show");
    	}

    	function editUser(id, name, email, phone, notif, dealer, role, urlpicture, picture) {
    		$("#editUser").attr('action', '/admin/user/user/' + id);
      		$("#idUser").val(id);
      		$("#nameUser").val(name);
      		$("#emailUser").val(email);
      		$("#phoneUser").val(phone);
      		$("#notifUser").val(notif);
      		$("#dealerUser").val(dealer);
      		$("#roleUser").val(JSON.parse(role));
      		if (picture != 0) {
      			$('.profile_img').attr('src', urlpicture);
      			$('.profile_text').val(picture);
      			$( ".btn-upload-profile" ).hide();
      			$( ".btn-delete-profile" ).show();
      		}else{
      			$('.profile_img').attr('src', '');
      			$('.profile_text').val('');
      			$( ".btn-upload-profile" ).show();
      			$( ".btn-delete-profile" ).hide();
      		}

      		$("#editUserModal").modal("show");
    	}

    	function DeleteUser() {
    		if ($('.checkin').is(':checked')) 
      		{
        		$('#deleteUserModal').modal("show");
      		}
      		else
      		{
        		$('#deleteNoModal').modal("show");
      		}
    	}

    	function deleteUser() {
    		$('#formUserDelete').submit();
    	}

    	// picture method
    	function deletePicture() {
    		var name = $(".profile_text").val();
      		$.ajax({
      			url: "/admin/user/picture/"+ name,
      			type: 'DELETE',
      			data:{
      				'_token': $('[name=_token').val(),
      			},
      			success: function(response){
      				console.log('delete picture', response);
      				$( ".btn-upload-profile" ).show();
      				$( ".btn-delete-profile" ).hide();
      				$('.profile_img').attr('src', '');
      				$('.profile_text').val('');
      			}
      		});
    	}
	</script>
@stop