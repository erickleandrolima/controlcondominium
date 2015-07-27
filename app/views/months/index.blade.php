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
	@if (Entrust::hasRole('Admin'))
		<div class="col-md-6">
			<h5>{{ Lang::get('months.deleteMessage') }}</h5>
			{{ Form::open(array( 'method' => 'POST', 'action' => array('MonthsController@deleteMonths'))) }}
			  {{ Form::text('year', Input::old('year'), array( 'style' => 'margin-bottom:10px; width:12%', 'maxlength' => '4', 'class'=>'form-control', 'placeholder'=> Lang::get('months.year') )) }}
			  {{ Form::submit(Lang::get('months.deleteMonths'), array('class' => 'btn btn-danger')) }}
			{{ Form::close() }}
		</div>
	@endif	
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
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($months as $month)
				<tr>
					<td>{{{ $month->month_reference }}}</td>
					<td>{{{ $month->month_name }}}</td>
					<td>
						@if ($month->casted == 0)
							{{ link_to('month/'. $month->month_reference .'/cast', Lang::get('app.throw'), array('style' => 'display:inline-block', 'class' => 'cast btn btn-warning') ) }}
						@endif
						@if ($month->casted == 1)
							{{ link_to('month/'. $month->month_reference .'/rebase', Lang::get('app.recalculate'), array('style' => 'display:inline-block', 'class' => 'cast btn btn-warning')) }}
						@endif	
					</td>
					<td>
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'post', 'url' => 'report/mural')) }}
							{{ Form::hidden('filter', $month->month_reference) }}
						    {{ Form::submit(Lang::get('app.print'), array('class' => 'btn btn-primary')) }}
						{{ Form::close() }}
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
