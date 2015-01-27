@extends('layouts.scaffold')

@section('main')

<h1>Meses</h1>

<p>{{ link_to_route('months.create', 'Adicionar mês', null, array('class' => 'btn btn-lg btn-success')) }}</p>

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
				<th>Data de referência</th>
				<th>Mês e Ano</th>
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
							{{ Form::submit('Excluir', array('class' => 'btn btn-danger')) }}
						{{ Form::close() }}
						{{ link_to_route('months.edit', 'Editar', array($month->id), array('class' => 'btn btn-info')) }}
						@if ($month->casted == 0)
							{{ link_to('month/'. $month->month_reference .'/cast', 'Lançar', 'class="cast btn btn-warning"') }}
						@endif	
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		$(function(){
			$('.cast').on('click', function(e){

				var action = confirm('Deseja realmente lancar a despesa para este mês? Isso é irreversível');

        if (action) {
          document.location = this.attr('href');
        } else {
          e.preventDefault();
        }

			});
		});
	</script>
@else
	There are no months
@endif

@stop
