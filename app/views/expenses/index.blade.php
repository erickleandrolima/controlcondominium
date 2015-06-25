@extends('layouts.scaffold')

@section('main')

<h1>{{ Lang::get('expenses.title') }}</h1>


<p>{{ link_to_route('expenses.create', Lang::get('expenses.add'), null, array('class' => 'btn btn-lg btn-success')) }}</p>

{{ $expenses->links(); }}

@if(Session::has('success'))
    <div class="alert alert-success">
      {{ Session::get('success') }}
    </div>
@endif

@if (count($expenses) > 0)
	
	{{ BaseController::getDefaultDataFilter() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th>{{ Lang::get('expenses.monthReference') }}</th>
				<th>{{ Lang::get('expenses.description') }}</th>
				<th>{{ Lang::get('expenses.value') }}</th>
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
                            {{ Form::submit(Lang::get('app.delete'), array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('expenses.edit', Lang::get('app.edit'), array($expense->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>

	{{ $expenses->links(); }}
@else
	{{ Lang::get('app.notFoundData') }}
@endif

@stop
