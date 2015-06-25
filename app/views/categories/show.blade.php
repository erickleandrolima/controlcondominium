@extends('layouts.scaffold')

@section('main')

@if(Session::has('success'))
    <div class="alert alert-success">
      {{ Session::get('success') }}
    </div>
@endif

<p>{{ link_to_route('categories.index', Lang::get('app.returnList'), null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>{{ Lang::get('categories.name') }}</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $category->name }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('categories.destroy', $category->id))) }}
                            {{ Form::submit(Lang::get('app.delete'), array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('categories.edit', Lang::get('app.edit'), array($category->id), array('class' => 'btn btn-info')) }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
