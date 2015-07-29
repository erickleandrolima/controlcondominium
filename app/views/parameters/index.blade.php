@extends('layouts.scaffold')

@section('main')

<h1>{{ Lang::get('parameters.title') }}</h1>

@if ($parameters->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>{{ Lang::get('parameters.numberApartments') }}</th>
				<th>{{ Lang::get('parameters.residentialName') }}</th>
				<th>{{ Lang::get('app.dueDate')}}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($parameters as $parameter)
				<tr>
					<td>{{{ $parameter->number_apartments }}}</td>
					<td>{{{ $parameter->residential_name }}}</td>
					<td>{{{ $parameter->day_due_date }}}</td>
                    <td>
                        {{ link_to_route('parameters.edit', Lang::get('app.edit'), array($parameter->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	{{ Lang::get('app.notFoundData') }}
@endif

@stop
