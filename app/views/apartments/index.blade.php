@extends('layouts.scaffold')

@section('main')

<h1>{{ Lang::get('apartments.title') }}</h1>

<p>{{ link_to_route('apartments.create', Lang::get('apartments.add'), null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($apartments->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>{{ Lang::get('apartments.number') }}</th>
				<th>{{ Lang::get('apartments.status') }}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($apartments as $apartment)
				<tr>
					<td>{{{ $apartment->number_apartment }}}</td>
					<td><img width="25" src="images/{{{ ($apartment->status == 1) ? 'on.png' : 'off.png' }}}" alt="Status"></td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('apartments.destroy', $apartment->id))) }}
                            {{ Form::submit(Lang::get('app.delete'), array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('apartments.edit', Lang::get('app.edit'), array($apartment->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	{{ Lang::get('app.notFoundData') }}
@endif

@stop
