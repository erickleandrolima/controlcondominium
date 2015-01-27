@extends('layouts.scaffold')

@section('main')

@if(Session::has('success'))
    <div class="alert alert-success">
      {{ Session::get('success') }}
    </div>
@endif

<p>{{ link_to_route('months.index', 'Todos os meses', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Data de referência</th>
				<th>Nome do mês e ano</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $month->month_reference }}}</td>
					<td>{{{ $month->month_name }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('months.destroy', $month->id))) }}
                            {{ Form::submit('Excluir', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('months.edit', 'Editar', array($month->id), array('class' => 'btn btn-info')) }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
