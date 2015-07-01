<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=devide-width, initial-scale=1">
    <base href="http://192.168.1.3/condominio/public/">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.css" />
    <script src="assets/js/jquery-2.1.3.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.mask.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.quicksearch.js"></script>
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

          var message = "<?php echo Lang::get('app.confirmAction') ?>";

          var action = confirm(message);

          if (action) {
            document.location = this.attr('href');
          } else {
            e.preventDefault();
          }

        });

        $('input#search').quicksearch('table tbody tr');

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
        <li><a href="months"><?php echo Lang::get('months.title') ?> </a></li>
        <li><a href="dwellers"><?php echo Lang::get('dwellers.title') ?></a></li>
        <li><a href="expenses"><?php echo Lang::get('expenses.title') ?></a></li>
        <li><a href="categories"><?php echo Lang::get('categories.title') ?></a></li>
        <li><a href="reports"> <?php echo Lang::get('reports.title') ?> </a></li>
        @if(Auth::check())
          <li><a href="users/logout"><?php echo Lang::get('login.logout') ?></a></li>
        @endif
      </ul>
    </div>  <!-- collapse navbar -->
  </div> <!-- container-fluid -->
</nav>
</header>    

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('success'))
                <div class="alert alert-success">
                  {{ Session::get('success') }}
                </div>
            @endif
            
            @if(Session::has('message'))
                <ul class="alert alert-danger">
                  <li class="error">{{ Session::get('message') }}</li>
                </ul>
            @endif

            @yield('main')
            
        </div>
    </div>
</div>

</body>
</html>