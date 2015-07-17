@extends('layouts.scaffold')

@section('main')

<h1> {{ Lang::get('users.title') }} </h1>

<p>{{ link_to_route('users.create', Lang::get('users.add') , null, array('class' => 'btn btn-lg btn-success')) }}</p>

{{ $users->links(); }}

@if (count($users) > 0)
	
	{{ BaseController::getDefaultDataFilter() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th>{{ Lang::get('users.firstName') }}</th>
				<th>{{ Lang::get('users.lastName') }}</th>
				<th>{{ Lang::get('users.situation') }}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($users as $user)
				<tr>
					<td>{{{ $user->firstname }}}</td>
					<td>{{{ $user->lastname }}}</td>
					<td>{{{ ($user->situation == 1) ? 'Ativo' : 'Inativo' }}}</td>
                    <td>
						  {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('users.destroy', $user->id))) }}
						      {{ Form::submit(Lang::get('app.delete'), array('class' => 'btn btn-danger')) }}
						  {{ Form::close() }}
						  {{ link_to_route('users.edit', Lang::get('app.edit'), array($user->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{{ $users->links(); }}

@else
	{{ Lang::get('app.notFoundData') }}
@endif

@stop
