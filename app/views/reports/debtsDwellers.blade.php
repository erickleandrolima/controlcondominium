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
</style>
</head>
<body>

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

</body>
</html>