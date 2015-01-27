@extends('layouts.scaffold')

@section('main')

<h1>Despesas</h1>

<p>{{ link_to_route('expenses.create', 'Adicionar Despesa', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if(Session::has('success'))
    <div class="alert alert-success">
      {{ Session::get('success') }}
    </div>
@endif

@if ($expenses->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Data</th>
				<th>Descrição</th>
				<th>Valor</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($expenses as $expense)
				<tr>
					<td>{{{ $expense->date_expense }}}</td>
					<td>{{{ $expense->description }}}</td>
					<td>{{{ number_format(floor((float)$expense->value), 2, ',', '') }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('expenses.destroy', $expense->id))) }}
                            {{ Form::submit('Excluir', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('expenses.edit', 'Editar', array($expense->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no expenses
@endif

@stop
