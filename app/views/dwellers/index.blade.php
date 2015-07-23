@extends('layouts.scaffold')

@section('main')

<h1> {{ Lang::get('dwellers.title') }} </h1>

<p>{{ link_to_route('dwellers.create', Lang::get('dwellers.add') , null, array('class' => 'btn btn-lg btn-success')) }}</p>

{{ $dwellers->links(); }}

@if (count($dwellers) > 0)
	
	{{ BaseController::getDefaultDataFilter() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th>{{ Lang::get('app.name') }}</th>
				<th>{{ Lang::get('dwellers.numberApartament') }}</th>
				<th>{{ Lang::get('app.status') }}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($dwellers as $dweller)
				<tr>
					<td>{{{ $dweller->name }}}</td>
					<td>{{{ $dweller->number_apartament }}}</td>
					<td>{{{ ($dweller->situation == 1) ? 'Ocupado' : 'Desocupado' }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('dwellers.destroy', $dweller->id))) }}
                            {{ Form::submit(Lang::get('app.delete'), array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('dwellers.edit', Lang::get('app.edit'), array($dweller->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{{ $dwellers->links(); }}

@else
	{{ Lang::get('app.notFoundData') }}
@endif

@stop
