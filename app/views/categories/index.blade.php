@extends('layouts.scaffold')

@section('main')

<h1>{{ Lang::get('categories.title') }}</h1>

<p>{{ link_to_route('categories.create', Lang::get('categories.add'), null, array('class' => 'btn btn-lg btn-success')) }}</p>

{{ $categories->links(); }}

@if(Session::has('success'))
    <div class="alert alert-success">
      {{ Session::get('success') }}
    </div>
@endif

@if ($categories->count())
	
	{{ BaseController::getDefaultDataFilter() }}

	<table class="table table-striped">
		<thead>
			<tr>
				<th>{{ Lang::get('categories.name') }}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($categories as $category)
				<tr>
					<td>{{{ $category->name }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('categories.destroy', $category->id))) }}
                            {{ Form::submit(Lang::get('app.delete'), array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('categories.edit', Lang::get('app.edit') , array($category->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{{ $categories->links(); }}

@else
	{{ Lang::get('app.notFoundData') }}
@endif

@stop
