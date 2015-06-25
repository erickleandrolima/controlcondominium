@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>{{ Lang::get('months.editMonth') }}</h1>

        @if ($errors->any())
        	<div class="alert alert-danger" role="alert">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($month, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('months.update', $month->id))) }}


        <div class="form-group">
            {{ Form::label('Nome do mês e ano', 'Nome do mês e Ano:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('month_name', Input::old('month_name'), array('class'=>'form-control', 'placeholder'=>'Month_name')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Data de Referência', 'Data de Referência:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('month_reference', Input::old('month_reference'), array('class'=>'date form-control', 'placeholder'=>'Month_reference')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label(Lang::get('months.dueDate'), Lang::get('months.dueDate'), array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('due_date', Input::old('due_date'), array('class'=>'date form-control', 'placeholder'=> Lang::get('months.dueDate'))) }}
            </div>
        </div>

<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit(Lang::get('app.update'), array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('months.index', Lang::get('app.cancel'), null , array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop