@extends('layouts.scaffold')

@section('main')

<h1>{{ Lang::get('months.title') }}</h1>

<p>{{ link_to_route('months.create', Lang::get('months.add'), null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if(Session::has('message'))
    <ul class="alert alert-danger">
    	<li class="error">{{ Session::get('message') }}</li>
    </ul>
@endif

@if(Session::has('success'))
    <div class="alert alert-success">
    	{{ Session::get('success') }}
    </div>
@endif

@if ($months->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>{{ Lang::get('months.referenceDate') }}</th>
				<th>{{ Lang::get('months.monthAndYear') }}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($months as $month)
				<tr>
					<td>{{{ $month->month_reference }}}</td>
					<td>{{{ $month->month_name }}}</td>
					<td>
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('months.destroy', $month->id))) }}
							{{ Form::submit(Lang::get('app.delete'), array('class' => 'btn btn-danger')) }}
						{{ Form::close() }}
						{{ link_to_route('months.edit', Lang::get('app.edit'), array($month->id), array('class' => 'btn btn-info')) }}
						@if ($month->casted == 0)
							{{ link_to('month/'. $month->month_reference .'/cast', Lang::get('app.throw'), 'class="cast btn btn-warning"') }}
						@endif
						@if ($month->casted == 1)
							{{ link_to('month/'. $month->month_reference .'/rebase', Lang::get('app.recalculate'), 'class="cast btn btn-warning"') }}
						@endif	
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		$(function(){
			$('.cast').on('click', function(e){

				var action = confirm("<?php echo Lang::get('app.confirmAction') ?>");

        if (action) {
          document.location = this.attr('href');
        } else {
          e.preventDefault();
        }

			});
		});
	</script>
@else
	{{ Lang::get('app.notFoundData') }}
@endif

@stop
