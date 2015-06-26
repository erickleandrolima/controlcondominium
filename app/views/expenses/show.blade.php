@extends('layouts.scaffold')

@section('main')

<p>{{ link_to_route('expenses.index', 'Todas as despesas', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Data</th>
				<th>Descrição</th>
				<th>Valor</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $expense->date_expense }}}</td>
					<td>{{{ $expense->description }}}</td>
					<td>{{{ $expense->value }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('expenses.destroy', $expense->id))) }}
                            {{ Form::submit('Excluir', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('expenses.edit', 'Editar', array($expense->id), array('class' => 'btn btn-info')) }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
