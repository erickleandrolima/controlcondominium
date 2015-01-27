@extends('layouts.scaffold')

@section('main')

<h1>All Dwellers</h1>

<p>{{ link_to_route('dwellers.create', 'Add New Dweller', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if(Session::has('success'))
    <div class="alert alert-success">
      {{ Session::get('success') }}
    </div>
@endif

@if (count($dwellers) > 0)
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Situation</th>
				<th>Number_apartament</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($dwellers as $dweller)
				<tr>
					<td>{{{ $dweller->name }}}</td>
					<td>{{{ $dweller->situation }}}</td>
					<td>{{{ $dweller->number_apartament }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('dwellers.destroy', $dweller->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('dwellers.edit', 'Edit', array($dweller->id), array('class' => 'btn btn-info')) }}
                      	{{ link_to_route('dwellers.show', 'Show expenses', $dweller->id, array('class' => 'btn btn-warning')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no dwellers
@endif

@stop
