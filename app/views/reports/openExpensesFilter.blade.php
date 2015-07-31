@extends('layouts.scaffold')

@section('main')

<h1> Relatório de meses com despesas em aberto </h1>

{{ $months->links(); }}

@if (count($months))
	
	{{ BaseController::getDefaultDataFilter() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th>{{ Lang::get('months.referenceDate') }}</th>
				<th>{{ Lang::get('months.monthAndYear') }}</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($months as $month)
				<tr>
					<td>{{{ $month->month_reference }}}</td>
					<td>{{{ $month->month_name }}}</td>
					<td>
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'post', 'url' => 'report/openExpenses')) }}
							{{ Form::hidden('date', $month->month_reference) }}
						    {{ Form::submit(Lang::get('reports.generate'), array('class' => 'btn btn-success')) }}
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	{{ $months->links(); }}

@else
	{{ Lang::get('app.notFoundData') }}
@endif

@stop
