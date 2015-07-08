@extends('layouts.scaffold')

@section('main')

<h1>{{ Lang::get('residentials.title') }}</h1>

<p>{{ link_to_route('residentials.create', Lang::get('residentials.add'), null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($residentials->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>{{ Lang::get('residentials.name') }} </th>
				<th>{{ Lang::get('residentials.status') }}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($residentials as $residential)
				<tr>
					<td>{{{ $residential->residential_name }}}</td>
					<td> <img width="25" src="images/{{{ ($residential->residential_status == 1) ? 'on.png' : 'off.png' }}}" alt="Status"> </td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('residentials.destroy', $residential->id))) }}
                            {{ Form::submit(Lang::get('app.delete'), array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('residentials.edit', Lang::get('app.edit'), array($residential->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	{{ Lang::get('app.notFoundData') }}
@endif

@stop
