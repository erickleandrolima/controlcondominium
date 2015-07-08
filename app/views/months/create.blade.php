@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Novo Mês</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::open(array('route' => 'months.store', 'class' => 'form-horizontal')) }}

        <div class="form-group">
            {{ Form::label('Nome do mês e ano', 'Nome do mês e ano:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('month_name', Input::old('month_name'), array('class'=>'form-control', 'placeholder'=>'Nome do mês e ano')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Data de Referencia', 'Data de Referencia:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('month_reference', Input::old('month_reference'), array('class'=>'date form-control', 'placeholder'=>'Data de referencia')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('Data de Vencimento', 'Data de Vencimento:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('due_date', Input::old('due_date'), array('class'=>'date form-control', 'placeholder'=>'Data de Vencimento')) }}
            </div>
        </div>


<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Criar', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('months.index', 'Cancelar', null , array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop


