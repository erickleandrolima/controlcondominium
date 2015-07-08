@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>{{ Lang::get('residentials.editResidential') }}</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($residential, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('residentials.update', $residential->id))) }}

        <div class="form-group">
            {{ Form::label(Lang::get('residentials.name'), Lang::get('residentials.name'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('residential_name', Input::old('residential_name'), array('class'=>'form-control', 'placeholder'=>'Residential_name')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('residentials.status'), Lang::get('residentials.status'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                {{ Form::select('residential_status', [
                    '1' => Lang::get('app.active'),
                    '0' => Lang::get('app.inactive'),]
                ), Input::old('residential_status') }}
            </div>
        </div>


<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit(Lang::get('app.update'), array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('residentials.index', Lang::get('app.cancel'), $residential->id, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop