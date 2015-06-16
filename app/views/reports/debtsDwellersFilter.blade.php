@extends('layouts.scaffold')

@section('main')

<h1>Relatório de Débitos de moradores</h1>

{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'POST')) }}

    <div class="form-group">
        {{ Form::label('Filtro', 'Filtro:', array('class'=>'col-md-2 control-label')) }}
	    <div class="col-sm-10">
		    {{Form::select('filter', $select, 0)}}
	    </div>
    </div>

    <br/>

    {{ Form::submit('Filtrar', array('class' => 'btn btn-success')) }}


{{ Form::close() }}

@stop
