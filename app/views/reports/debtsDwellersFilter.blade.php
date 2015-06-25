@extends('layouts.scaffold')

@section('main')

<h1>Relatório de Débitos de moradores</h1>

{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'POST')) }}

    <div class="form-group">
        {{ Form::label(Lang::get('reports.filter'), Lang::get('reports.choice') , array('class'=>'col-md-3 control-label margin-top-5')) }}
	    <div class="col-sm-6">
		    {{Form::select('filter', $select, 0)}}
	    </div>
    </div>

    <br/>

    {{ Form::submit(Lang::get('reports.generate'), array('class' => 'btn btn-success')) }}


{{ Form::close() }}

@stop
