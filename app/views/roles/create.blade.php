@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>{{ Lang::get('roles.createRole') }}</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::open(array('route' => 'roles.store', 'class' => 'form-horizontal')) }}

<div class="form-group">
    {{ Form::label(Lang::get('roles.description'), Lang::get('roles.description'), array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
      {{ Form::text('role_description', Input::old('role_description'), array('class'=>'form-control', 'placeholder'=> Lang::get('roles.description') )) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label(Lang::get('roles.rate'), Lang::get('roles.rate'), array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::select('role_rate', [
           '1' => 1,
           '2' => 2,
           '3' => 3,
           '4' => 4,
           '5' => 5,
           '6' => 6,
           '7' => 7,
           '8' => 8,
           '9' => 9,
           '10' => 10,
        ], Input::old('role_rate')
        ) }}    
    </div>
</div>

<div class="form-group">
    {{ Form::label(Lang::get('roles.status'), Lang::get('roles.status'), array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::select('role_status', [
           '1' => Lang::get('app.active'),
           '0' => Lang::get('app.inactive'),]
        ), Input::old('role_status') }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit(Lang::get('app.create'), array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('roles.index', Lang::get('app.cancel'), null, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop


