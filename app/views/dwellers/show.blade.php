@extends('layouts.scaffold')

@section('main')

<p>{{ link_to_route('dwellers.index', Lang::get('app.returnList'), null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<p>
  {{ link_to('dweller/' . $dweller->id . '/history' , Lang::get('app.historyPayment'), 'class="cast btn btn-lg btn-danger"') }}  
</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>{{ Lang::get('app.name') }}</th>
				<th>{{ Lang::get('app.status') }}</th>
				<th>{{ Lang::get('dwellers.numberApartament') }}</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $dweller->name }}}</td>
			<td>{{{ $dweller->situation }}}</td>
			<td>{{{ $dweller->number_apartament }}}</td>
		</tr>
	</tbody>
</table>

<table id="expenses" class="table table-striped">
	<thead>
		<tr>
			<th>{{ Lang::get('app.months') }}</th>
			<th>{{ Lang::get('app.value') }}</th>
			<th>{{ Lang::get('app.status') }}</th>
      <th>{{ Lang::get('app.parcialPay') }}</th>
			<th>{{ Lang::get('app.reversePayment') }}</th>
		</tr>
	</thead>

	<tbody>
		@foreach($expenses as $expense)
			<tr>
				<td>{{{ substr($expense->date_expense, 0, 7) }}}</td>
        @if ($expense->status_expense == 0)
				  <td>R$ {{{ number_format(ceil((float)$expense->total - $expense->credit), 2, ',', '') }}}</td>
        @else  
          <td>R$ {{{ number_format(ceil((float)$expense->total), 2, ',', '') }}}</td>
        @endif  
				<td>
					@if ($expense->status_expense == 0)
            			{{ link_to('expense/' . $dweller->id . '/'. $expense->date_expense .'/pay' , Lang::get('app.pay'), 'class="pay cast btn btn-danger"') }}
					@else
            			{{ link_to('#', Lang::get('app.paid'), 'class="cast btn btn-success"') }}
					@endif
				</td>
				<td>
          {{ Form::open(array( 'class' => 'parcialPay', 'style' => 'display: inline-block;', 'method' => 'POST', 'action' => array('MoneyController@parcialPay', $expense->id . '/' . $dweller->id . '/'. $expense->credit))) }}
            {{ Form::text('value', Input::old('value'), array( 'style' => 'margin-bottom:10px', 'class'=>'form-control money', 'placeholder'=> Lang::get('app.value'))) }}
            {{ Form::submit(Lang::get('app.parcialPay'), array('class' => 'btn btn-warning')) }}
          {{ Form::close() }}
				</td>
        <td>
          {{ Form::open(array( 'style' => 'display: inline-block;', 'method' => 'POST', 'action' => array('MoneyController@reversePayment', 
            $dweller->id . '/' . $expense->date_expense))) }}
            {{ Form::submit(Lang::get('app.reversePayment'), array('class' => 'btn btn-warning')) }}
          {{ Form::close() }}
        </td>
			</tr>
		@endforeach	
    <tr>
      <td colspan="1" align="right"> 
        <strong>{{ Lang::get('app.total') }}: R$ {{{ number_format(ceil((float)$sum[0]->total), 2, ',' ,'')  }}}</strong> 
      </td>
      <td colspan="1" align="right"> 
        <strong>{{ Lang::get('app.balance') }}: R$ 
          @if($balance > 0) 
            {{{ number_format(ceil((float)$balance), 2, ',', '') }}}
          @else
            0,00
          @endif 
        </strong> 
      </td>
    </tr>
	</tbody>
</table>

<script type="text/javascript">

	$(function(){

    function isNumber(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }

    $('.parcialPay').submit(function(e){

      if(this.value.value == '')
      {
        alert('Digite o valor que deseja pagar!');
        return false;
      }

      if(!isNumber(this.value.value) )
      {
        alert('Digite o valor corretamente!');
        return false;
      }

      var action = confirm('Deseja realmente pagar esta despesa parcialmente? Isso é irreversível');

      if (action) {
        return action;
      } else {
        e.preventDefault();
      }

    });


	});
</script>

@stop
