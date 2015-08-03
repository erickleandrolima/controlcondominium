@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Atualizar Parâmetros</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($parameter, array('class' => 'form-horizontal', 'files' => 'true', 'method' => 'PATCH', 'route' => array('parameters.update', $parameter->id))) }}

        {{ Form::hidden('user_id', Auth::id()) }}

        @if (!is_null($path))
            <div class="form-group">
                <label class="col-md-2 control-label">Imagem atual do perfil</label>
                <div class="col-sm-10">
                   <img src="{{ $path }}">
                </div>
            </div>
        @endif

        <div class="form-group">
            {{ Form::label(Lang::get('parameters.numberApartments'), Lang::get('parameters.numberApartments'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'number_apartments', Input::old('number_apartments'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('residential_name', 'Residential_name:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('residential_name', Input::old('residential_name'), array('class'=>'form-control', 'placeholder'=>'Residential_name')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('parameters.dayDueDate'), Lang::get('parameters.dayDueDate') , array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('day_due_date', Input::old('day_due_date'), array('class'=>'form-control', 'placeholder'=>'Due_date')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('app.profilePhoto'), Lang::get('app.profilePhoto'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                 {{Form::file('image') }}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-10">
              {{ Form::submit(Lang::get('app.update'), array('class' => 'btn btn-lg btn-primary')) }}
              {{ link_to_route('parameters.index', Lang::get('app.cancel'), null, array('class' => 'btn btn-lg btn-default')) }}
            </div>
        </div>

{{ Form::close() }}

@stop