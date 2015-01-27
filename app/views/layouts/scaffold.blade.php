<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.mask.min.js"></script>
    <script type="text/javascript">
      $(function(){
        $('.money').mask('000.000.000.000.000.00', {reverse: true});
        $(".date").datepicker({
          dateFormat: 'yy-mm-dd',
          dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
          dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
          dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
          monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
          monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
          nextText: 'Próximo',
          prevText: 'Anterior'
        });
        $('.btn-danger').on('click', function(e){

          var action = confirm('Deseja realmente excluir? Isso é irreversível');

          if (action) {
            document.location = this.attr('href');
          } else {
            e.preventDefault();
          }

        });
      });
    </script>
    <style>
        body { padding-top: 20px; }
    </style>
</head>

<body>

<header>
    <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="/months">Meses</a></li>
        <li><a href="/dwellers">Moradores</a></li>
        <li><a href="/expenses">Despesas</a></li>
        <li><a href="/categories">Categorias</a></li>
        <li><a href="/reports">Relatórios</a></li>
      </ul>
    </div>  <!-- collapse navbar -->
  </div> <!-- container-fluid -->
</nav>
</header>    

<div class="container">
    <div class="row">
        <div class="col-md-12">

            @if (Session::has('message'))
                <div class="flash alert">
                    <p>{{ Session::get('message') }}</p>
                </div>
            @endif

            @yield('main')

        </div>
    </div>
</div>

</body>
</html>