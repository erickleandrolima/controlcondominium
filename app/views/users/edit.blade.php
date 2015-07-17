@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>{{ Lang::get('users.editUser') }}</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($user, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('users.update', $user->id))) }}

        <div class="form-group">
            {{ Form::label(Lang::get('users.firstName'), Lang::get('users.firstName'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('firstname', Input::old('firstname'), array('class'=>'form-control', 'placeholder'=> Lang::get('users.firstName'))) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('users.lastName'), Lang::get('users.lastName'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('lastname', Input::old('lastname'), array('class'=>'form-control', 'placeholder'=> Lang::get('users.lastName'))) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('users.email'), Lang::get('users.email'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('email', Input::old('email'), array('class'=>'form-control', 'placeholder'=> Lang::get('users.email'))) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('users.password'), Lang::get('users.password'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::password('password', Input::old(''), array('class'=>'form-control', 'placeholder'=> Lang::get('users.password'))) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('users.userRole'), Lang::get('users.userRole'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                 {{Form::select('role_id', $roles, $userRole[0]->role_id)}}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('users.situation'), Lang::get('users.situation'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                {{ Form::select('situation', [
                   '1' => 'Ativo',
                   '0' => 'Inativo',]
                ), Input::old('situation') }}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-10">
              {{ Form::submit(Lang::get('app.update'), array('class' => 'btn btn-lg btn-primary')) }}
              {{ link_to_route('users.index', Lang::get('app.cancel'), null, array('class' => 'btn btn-lg btn-default')) }}
            </div>
        </div>

{{ Form::close() }}

@stop