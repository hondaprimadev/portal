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
                  @else 
                    <input type="hidden" id="roleTableUser" value="[0]">
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
        var role = $(this).find('#roleTableUser').val();

        editUser(id, name, email, role);
      }
    });

  	function addUser() {
  		$('.profile_img').attr('src', '');
    		$( ".btn-upload-profile" ).show();
    		$( ".btn-delete-profile" ).hide();
  		$("#createUserModal").modal("show");
  	}

  	function editUser(id, name, email, role) {
  		$("#editUser").attr('action', '/admin/user/user/' + id);
    		$("#idUser").val(id);
    		$("#nameUser").val(name);
    		$("#emailUser").val(email);
    		$("#roleUser").val(JSON.parse(role));

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
	</script>
@stop