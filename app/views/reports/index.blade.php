@extends('layouts.scaffold')

@section('main')

<h1>{{ Lang::get('reports.title') }}</h1>
	
	{{ BaseController::getDefaultDataFilter() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th> {{ Lang::get('reports.description') }} </th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>Relatório de despesas em aberto</td>
				<td>{{ link_to('report/openExpenses', Lang::get('reports.generate'), 'class="cast btn btn-warning"') }}</td>
			</tr>
		</tbody>
	</table>
@stop
