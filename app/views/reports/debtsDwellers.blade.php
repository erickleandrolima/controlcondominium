@extends('reports.template')

@section('report')

@if (count($expenses) == 0)
  
  <h1>Este morador não possui débitos</h1>

@else

<div class="container">
    <div class="row">
        <div class="col-md-12">
      
          <h1> Débitos do Apartamento {{{ $expenses[0]->number_apartament }}} </h1>

        </div> <!-- md-12 -->
    </div> <!-- row -->

    <div class="row" style="page-break-after:always">
      <div class="col-md-3">

        <table id="expenses" class="table table-condensed table-striped" border="1">
          <thead>
            <tr>
              <th class="col-sm-1">Mês</th>
              <th class="col-sm-2">Valor</th>
          </thead>
          <tbody>
            @foreach($expenses as $expense)
              <tr>
                <td> {{{ $expense->month_name }}} </td>
                <td align="center"> {{{ ceil($expense->cost) }}} </td>
              </tr>
            @endforeach
            <tr>
              <td> <strong>Total</strong>:</td>
              <td> <strong> R$ {{{ ceil($total[0]->debt) }}} </strong> </td>
            </tr>
          </tbody>
        </table>


      </div> <!-- md-3 --> 
    </div> <!-- row -->

</div> <!-- container -->

@endif

@stop