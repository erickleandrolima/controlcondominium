@extends('layouts.scaffold')

@section('main')

<p>{{ link_to_route('dwellers.index', 'Return to All dwellers', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
				<th>Situation</th>
				<th>Number_apartament</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $dweller->name }}}</td>
					<td>{{{ $dweller->situation }}}</td>
					<td>{{{ $dweller->number_apartament }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('dwellers.destroy', $dweller->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('dwellers.edit', 'Edit', array($dweller->id), array('class' => 'btn btn-info')) }}
                    </td>
                    
		</tr>
	</tbody>
</table>

<table id="expenses" class="table table-striped">
	<thead>
		<tr>
			<th>Mês</th>
			<th>Valor</th>
			<th>Status</th>
      <th>Pagamento Parcial</th>
			<th>Estornar pagamento</th>
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
            			{{ link_to('expense/' . $dweller->id . '/'. $expense->date_expense .'/pay' , 'Pay', 'class="pay cast btn btn-danger"') }}
					@else
            			{{ link_to('#', 'Paid', 'class="cast btn btn-success"') }}
					@endif
				</td>
				<td>
          {{ Form::open(array( 'class' => 'parcialPay', 'style' => 'display: inline-block;', 'method' => 'POST', 'action' => array('ExpensesController@parcialPay', $expense->id . '/' . $dweller->id . '/'. $expense->credit))) }}
            {{ Form::text('value', Input::old('value'), array( 'style' => 'margin-bottom:10px', 'class'=>'form-control money', 'placeholder'=>'Value')) }}
            {{ Form::submit('Pagamento parcial', array('class' => 'btn btn-warning')) }}
          {{ Form::close() }}
				</td>
        <td>
          {{ Form::open(array( 'style' => 'display: inline-block;', 'method' => 'POST', 'action' => array('ExpensesController@reversePayment', 
            $dweller->id . '/' . $expense->date_expense))) }}
            {{ Form::submit('Estornar pagamento', array('class' => 'btn btn-warning')) }}
          {{ Form::close() }}
        </td>
			</tr>
		@endforeach	
    <tr>
      <td colspan="1" align="right"> 
        <strong>Total: R$ {{{ number_format(ceil((float)$sum[0]->total), 2, ',' ,'')  }}}</strong> 
      </td>
      <td colspan="1" align="right"> 
        <strong>Saldo devedor: R$ 
          @if($balance > 0) 
            {{{ number_format(ceil((float)$balance), 2, ',', '') }}}
          @else
            0,00
          @endif 
        </strong> 
      </td>
      <td>
        {{ link_to('dweller/' . $dweller->id . '/history' , 'Histórico de pagamentos', 'class="cast btn btn-danger"') }}
      </td> 
    </tr>
	</tbody>
</table>

<script type="text/javascript">

	$(function(){

    function isNumber(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }

		$('.pay').on('click', function(e){

	 		var action = confirm('Deseja realmente pagar esta despesa? Isso é irreversível');

      if (action) {
        document.location = this.attr('href');
      } else {
        e.preventDefault();
      }

		});

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
