@extends('layouts.scaffold')

@section('main')

<h1>Despesas</h1>

<p>{{ link_to_route('expenses.create', 'Adicionar Despesa', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if(Session::has('success'))
    <div class="alert alert-success">
      {{ Session::get('success') }}
    </div>
@endif

@if (count($expenses) > 0)
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Mês de Referência</th>
				<th>Descrição</th>
				<th>Valor</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($expenses as $expense)
				<tr>
					<td>{{{ $expense->month_name }}}</td>
					<td>{{{ $expense->description }}}</td>
					<td>{{{ number_format(ceil((float)$expense->value), 2, ',', '') }}}</td>
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
