@extends('layouts.scaffold')

@section('main')

<h1>{{ Lang::get('roles.title') }}</h1>

<p>{{ link_to_route('roles.create', Lang::get('roles.add'), null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($roles->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>{{ Lang::get('roles.description') }}</th>
				<th>{{ Lang::get('roles.rate') }}</th>
				<th>{{ Lang::get('roles.status') }}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($roles as $role)
				<tr>
					<td>{{{ $role->role_description }}}</td>
					<td>{{{ $role->role_rate }}}</td>
					<td><img width="25" src="images/{{{ ($role->role_status == 1) ? 'on.png' : 'off.png' }}}" alt="Status"></td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('roles.destroy', $role->id))) }}
                            {{ Form::submit(Lang::get('app.delete'), array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('roles.edit', Lang::get('app.edit'), array($role->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	{{ Lang::get('app.notFoundData') }}
@endif

@stop
