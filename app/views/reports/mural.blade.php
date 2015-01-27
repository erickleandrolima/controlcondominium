<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">

          <h1>  
            Valor do Condomínio Referente ao mês de {{{ $month_reference }}}
            com vencimento em {{{ $due_date }}}
          </h1>

          <h2>
            Valor: {{{ number_format(floor((float)$cost), 2, ',', '')}}}
          </h2>

          <ul>

            @foreach($expenses as $expense)

              <li> 
                {{{ $expense->description }}} : 
                <strong> {{{ number_format(floor((float)$expense->value), 2, ',', '') }}} </strong> 
                {{{ strftime("%d/%m/%Y", strtotime( $expense->date_expense )) }}} 
              </li>

            @endforeach

          </ul>

        </div> <!-- md-12 -->
    </div> <!-- row -->

    <div class="row">
      <div class="col-md-3">

        <table id="expenses" class="table table-condensed table-striped" border="1">
          <thead>
            <tr>
              <th class="col-sm-1">N° APTO</th>
              <th class="col-sm-2">Data do Pagamento</th>
          </thead>
          <tbody>
            @foreach($dwellers as $dweller)
              <tr>
                <td> {{{ $dweller->number_apartament }}} </td>
                <td></td>
              </tr>
            @endforeach
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
                <td> <strong> {{{ $debtor->number_apartament }}} </strong> </td>
                <td> {{{ BaseController::getMonthNameExtension($debtor->date_expense, 3) }}} </td>
                <td> {{{ number_format(floor((float)$debtor->value), 2, ',', '') }}} </td>
              </tr>
            @endforeach
          </tbody>
        </table>


      </div> <!-- md-3 --> 
    </div> <!-- row -->

</div> <!-- container -->

</body>
</html>
