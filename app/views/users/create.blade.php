@extends('layouts.scaffold')

@section('main')

{{ Form::open(array('route'=>'users.store', 'class'=>'form-signup')) }}
    <h2 class="form-signup-heading"> {{{ Lang::get('users.createUser') }}} </h2>
 
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <div class="form-group">
        {{ Form::text('firstname', null, array('class'=>'form-control', 'placeholder'=>Lang::get('users.firstName'))) }}
    </div>
    <div class="form-group">
        {{ Form::text('lastname', null, array('class'=>'form-control', 'placeholder'=> Lang::get('users.lastName'))) }}
    </div>
    <div class="form-group">
        {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=> Lang::get('users.email'))) }}
    </div>
    <div class="form-group">
        {{ Form::password('password', array('class'=>'form-control', 'placeholder'=> Lang::get('users.password'))) }}
    </div>
    <div class="form-group">
        {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=> Lang::get('users.confirmPassword'))) }}
    </div>
 
    {{ Form::submit(Lang::get('app.create'), array('class'=>'btn btn-large btn-primary btn-block'))}}
{{ Form::close() }}

@stop