@extends('layouts.scaffold')

@section('main')

<h1>Relatórios</h1>

	<table class="table table-striped">
		<thead>
			<tr>
				<th>Nome do relatório</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>Relatório do Mural</td>
				<td>{{ link_to('report/mural', 'Filtrar', 'class="cast btn btn-warning"') }}</td>
			</tr>
		</tbody>
	</table>
@stop
