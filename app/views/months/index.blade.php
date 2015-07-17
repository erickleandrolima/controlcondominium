@extends('layouts.scaffold')

@section('main')

<h1>{{ Lang::get('months.title') }}</h1>

<div class="col-md-12">
	<div class="col-md-6">
		<h5>{{ Lang::get('months.generateMessage') }}</h5>

		{{ Form::open(array( 'method' => 'POST', 'action' => array('MonthsController@generateMonths'))) }}
		  {{ Form::text('year', Input::old('year'), array( 'style' => 'margin-bottom:10px; width:12%', 'maxlength' => '4', 'class'=>'form-control', 'placeholder'=> Lang::get('months.year') )) }}
		  {{ Form::submit(Lang::get('months.generateMonths'), array('class' => 'btn btn-success')) }}
		{{ Form::close() }}
	</div>
	<div class="col-md-6">
		<h5>{{ Lang::get('months.deleteMessage') }}</h5>

		{{ Form::open(array( 'method' => 'POST', 'action' => array('MonthsController@deleteMonths'))) }}
		  {{ Form::text('year', Input::old('year'), array( 'style' => 'margin-bottom:10px; width:12%', 'maxlength' => '4', 'class'=>'form-control', 'placeholder'=> Lang::get('months.year') )) }}
		  {{ Form::submit(Lang::get('months.deleteMonths'), array('class' => 'btn btn-danger')) }}
		{{ Form::close() }}
	</div>
</div>



{{ $months->links(); }}

@if ($months->count())
	
	{{ BaseController::getDefaultDataFilter() }}

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

	{{ $months->links(); }}
	
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
