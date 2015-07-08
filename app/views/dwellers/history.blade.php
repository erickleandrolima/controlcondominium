@extends('layouts.scaffold')

@section('main')

<h1>Históricos de Pagamentos</h1>

<p>{{ link_to_route('dwellers.show', 'Retornar para as despesas', $dweller->id, array('class'=>'btn btn-lg btn-primary')) }}</p>

@if (count($expenses) > 0)

<table id="expenses" class="table table-striped">
	<thead>
		<tr>
			<th>Mês</th>
			<th>Valor</th>
			<th>Data</th>
      <th>Tipo de Pagamento</th>
		</tr>
	</thead>

	<tbody>
		@foreach($expenses as $expense)
			<tr>
				<td>{{{ substr($expense->date_expense, 0, 7) }}}</td>
				<td>R$ {{{ $expense->value }}}</td>
				<td> 
          {{{ substr($expense->updated_at, 0, 10) }}}
        </td>
        <td>
          @if ($expense->type_expense == 0)
            Pagamento Integral
          @else
            Pagamento Parcial
          @endif
        </td>
			</tr>
		@endforeach	
    <tr>
      <td colspan="1" align="right"> 
        <strong>Total: R$ {{{ $sum[0]->total }}}</strong> 
      </td>
      <td colspan="2" align="right"> 
        <strong>Saldo devedor: R$ 
          @if($balance > 0) 
            {{{ $balance }}}
          @else
            0.00
          @endif 
        </strong> 
      </td>
    </tr>
	</tbody>
</table>

@else
  
  <br>
  <h4> Não há registros de pagamentos para este morador </h4>

@endif

@stop
