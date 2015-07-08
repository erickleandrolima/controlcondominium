@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>{{ Lang::get('permissions.createPermission') }}</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::open(array('route' => 'permissions.store', 'class' => 'form-horizontal')) }}

        <div class="form-group">
            {{ Form::label(Lang::get('permissions.description'), Lang::get('permissions.description'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('permission_description', Input::old('permission_description'), array('class'=>'form-control', 'placeholder'=> Lang::get('permissions.description'))) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('permissions.rate'), Lang::get('permissions.rate'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                {{ Form::select('permission_rate', [
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
                ]
                ) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('permissions.status'), Lang::get('permissions.status'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                {{ Form::select('permission_status', [
                   '1' => Lang::get('app.active'),
                   '0' => Lang::get('app.inactive'),]
                ) }}
            </div>
        </div>


<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit(Lang::get('app.create'), array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('permissions.index', Lang::get('app.cancel'), null, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop


