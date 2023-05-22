@extends('layout.admin')

@section('content-header')
	<section class="content-header">
    <h1>
      <i class="fa fa-newspaper-o"></i> Profile
      <small>Profile edit</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="/profile/">Profile</a></li>
    </ol>
  </section>
@stop

@section('content')
  {!! Form::model($user, ['class'=>'form-horizontal', 'id'=>'formEditEmployee', 'method'=>'PATCH', 'action'=>['DashboardController@postProfile', $user->token]]) !!}
    @include('dashboard.profile._form',['nikStat' => true])

    <div class="box-footer">
      <button type="submit" class="btn btn-success">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
      </button>
      <button type="submit" class="btn btn-default">Cancel</button>
    </div>
  </form>
@stop

@section('scripts')
  @include('dashboard.profile._js')
@stop