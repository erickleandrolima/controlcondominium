<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Relatório de Despesas</title>
<style type="text/css">
.container {
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
}
@media (min-width: 992px) {
  .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {float: left;}
  .col-md-12 { width: 100%; }
  .col-md-6 {width: 50%;}
  .col-md-3 {width: 25%;}
}
.row { margin-right: -15px; margin-left: -15px;}
table {  background-color: transparent;}
caption { padding-top: 8px; padding-bottom: 8px; color: #777; text-align: left;}
th { text-align: left;}
.table {width: 100%; max-width: 100%; margin-bottom: 20px;}
.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td {
  padding: 8px;
  line-height: 1.42857143;
  vertical-align: top;
  border-top: 1px solid #ddd;
}
.table > thead > tr > th {
  vertical-align: bottom;
  border-bottom: 2px solid #ddd;
}
.table > caption + thead > tr:first-child > th,
.table > colgroup + thead > tr:first-child > th,
.table > thead:first-child > tr:first-child > th,
.table > caption + thead > tr:first-child > td,
.table > colgroup + thead > tr:first-child > td,
.table > thead:first-child > tr:first-child > td {
  border-top: 0;
}
.table > tbody + tbody {
  border-top: 2px solid #ddd;
}
.table .table {
  background-color: #fff;
}
.table-condensed > thead > tr > th,
.table-condensed > tbody > tr > th,
.table-condensed > tfoot > tr > th,
.table-condensed > thead > tr > td,
.table-condensed > tbody > tr > td,
.table-condensed > tfoot > tr > td {
  padding: 5px;
}
@page {margin-top:  0px;}
.header {top: -50px; position: fixed; display: table;}
.footer {bottom: 0px; position: fixed;}
</style>
</head>
<body>

<header class="header"> <h1>Condominio</h1> </header>

<div class="container">
    <div class="row">
        <div class="col-md-12">

          <h1>  
            Valor do Condomínio Referente ao mês de <?php echo $month_reference ?>
            com vencimento em <?php echo $due_date ?>
          </h1>

          <h2>
            Valor: <?php echo number_format(floor((float)$cost), 2, ',', '')?>
          </h2>

          <ul>

            <?php foreach($expenses as $expense): ?>

              <li> 
                <?php echo $expense->description ?> : 
                <strong> <?php echo number_format(floor((float)$expense->value), 2, ',', '') ?> </strong> 
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
            <?php foreach($debtors as $debtor): ?>
              <tr>
                <td> <strong> <?php echo $debtor->number_apartament ?> </strong> </td>
                <td> <?php echo BaseController::getMonthNameExtension($debtor->date_expense, 3) ?> </td>
                <td> <?php echo number_format(floor((float)$debtor->value), 2, ',', '') ?> </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>


      </div> <!-- md-3 --> 
    </div> <!-- row -->

</div> <!-- container -->

</body>
</html>