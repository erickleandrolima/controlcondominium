@extends('layouts.scaffold')

@section('main')

<h1>{{ Lang::get('permissions.title') }}</h1>

<p>{{ link_to_route('permissions.create', Lang::get('permissions.add'), null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($permissions->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>{{ Lang::get('permissions.description') }}</th>
				<th>{{ Lang::get('permissions.rate') }}</th>
				<th>{{ Lang::get('permissions.status')}}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($permissions as $permission)
				<tr>
					<td>{{{ $permission->permission_description }}}</td>
					<td>{{{ $permission->permission_rate }}}</td>
					<td><img width="25" src="images/{{{ ($permission->permission_status == 1) ? 'on.png' : 'off.png' }}}" alt="Status"></td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('permissions.destroy', $permission->id))) }}
                            {{ Form::submit(Lang::get('app.delete'), array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('permissions.edit', Lang::get('app.edit'), array($permission->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	{{ Lang::get('app.notFoundData') }}
@endif

@stop
