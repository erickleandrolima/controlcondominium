@extends('reports.template')

@section('report')

<div class="container">
    <div class="row">
        <div class="col-md-12">

          <h1>  
            Valor do Condomínio Referente ao mês de <?php echo $month_reference ?>
            com vencimento em <?php echo $due_date ?>
          </h1>

          <h2>
            Valor: <?php echo number_format(ceil((float)$cost), 2, ',', '')?>
          </h2>

          <ul>

            <?php foreach($expenses as $expense): ?>

              <li> 
                <?php echo $expense->description ?> : 
                <strong> <?php echo number_format(ceil((float)$expense->value), 2, ',', '') ?> </strong> 
                <?php echo strftime("%d/%m/%Y", strtotime( $expense->date_expense )) ?> 
              </li>

            <?php endforeach; ?>

          </ul>

        </div> <!-- md-12 -->
    </div> <!-- row -->

    <div class="row" style="page-break-after:always">
      <div class="col-md-3">

        <table id="expenses" class="table table-condensed table-striped" border="1">
          <thead>
            <tr>
              <th class="col-sm-1">N° APTO</th>
              <th class="col-sm-2">Data do Pagamento</th>
          </thead>
          <tbody>
            <?php foreach($dwellers as $dweller): ?>
              <tr>
                <td> <?php echo $dweller->number_apartament ?> </td>
                <td></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>


      </div> <!-- md-3 --> 
    </div> <!-- row -->

    <div class="row">
      <div class="col-md-6">

        <h2>Apartamentos com Condomínio Atrasado</h2>

        <table id="expenses" class="table table-condensed table-striped" border="1">
          <thead>
            <tr>
              <th class="col-sm-1">N° APTO</th>
              <th class="col-sm-3">Mês Pendente</th>
              <th class="col-sm-2">Valor</th>
          </thead>
          <tbody>
              @foreach($debtors as $debtor)
              <tr>
                <td> <strong> {{ $debtor->number_apartament }} </strong> </td>
                <td> {{{ BaseController::getMonthNameExtension($debtor->date_expense, 3) }}} </td>
                <td> {{{ number_format(ceil((float)$debtor->value - $debtor->credit), 2, ',', '') }}} </td>
              </tr>
              @endforeach
          </tbody>
        </table>


      </div> <!-- md-3 --> 
    </div> <!-- row -->

</div> <!-- container -->

@stop