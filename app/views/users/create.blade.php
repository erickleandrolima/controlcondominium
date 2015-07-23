@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>{{ Lang::get('users.createUser') }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
            </div>
        @endif
    </div>
</div>

{{ Form::open(array('route'=>'users.store', 'class'=>'form-horizontal')) }}
    
    @if (!Entrust::hasRole('Admin'))
        {{ Form::hidden('user_id', Auth::id()) }}
    @endif    

    <div class="form-group">
        {{ Form::label(Lang::get('users.firstName'), Lang::get('users.firstName'), array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('firstname', null, array('class'=>'form-control', 'placeholder'=>Lang::get('users.firstName'))) }}
        </div>    
    </div>
    <div class="form-group">
        {{ Form::label(Lang::get('users.lastName'), Lang::get('users.lastName'), array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('lastname', null, array('class'=>'form-control', 'placeholder'=> Lang::get('users.lastName'))) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(Lang::get('users.email'), Lang::get('users.email'), array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=> Lang::get('users.email'))) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(Lang::get('users.password'), Lang::get('users.password'), array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::password('password', array('class'=>'form-control', 'placeholder'=> Lang::get('users.password'))) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(Lang::get('users.confirmPassword'), Lang::get('users.confirmPassword'), array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=> Lang::get('users.confirmPassword'))) }}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>
        <div class="col-sm-10">
          {{ Form::submit(Lang::get('app.create'), array('class'=>'btn btn-lg btn-primary'))}}
          {{ link_to_route('users.index', Lang::get('app.cancel'), null, array('class' => 'btn btn-lg btn-default')) }}
        </div>
    </div>

{{ Form::close() }}

@stop