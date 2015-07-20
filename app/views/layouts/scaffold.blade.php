<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="/"></base>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
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

        $('input[type=number]').keypress(function(){
            var value = $(this).val();
            value = value.replace(/[^0-9]+/g, '');
            $(this).val(value);
        });

        $('input#search').quicksearch('table tbody tr');

      });
    </script>
</head>

<body>

@if(Auth::check())
  <header class="top-bar"></header>
  <aside class="side-bar">
    <nav>
        <ul>
          <li> <i class="fa red fa-calendar"></i> <a href="months"><?php echo Lang::get('months.title') ?> </a></li>
          <li> <i class="fa blue fa-users"></i> <a href="dwellers"><?php echo Lang::get('dwellers.title') ?></a></li>
          <li> <i class="fa green fa-money"></i> <a href="expenses"><?php echo Lang::get('expenses.title') ?></a></li>
          <li> <i class="fa fa-building-o yellow"></i> <a href="apartments"> <?php echo Lang::get('apartments.title') ?> </a></li>
          <li> <i class="fa orange fa-list-ul"></i> <a href="categories"><?php echo Lang::get('categories.title') ?></a></li>
          <li> <i class="fa pink fa-trello"></i> <a href="reports"> <?php echo Lang::get('reports.title') ?> </a></li>
          @if (Entrust::hasRole('Admin'))
            <li> <i class="fa blue fa-male"></i> <a href="users"> <?php echo Lang::get('users.title') ?> </a></li>
          @endif  
          <li> <i class="fa fa-sign-out"></i> <a href="users/logout"><?php echo Lang::get('login.logout') ?></a></li>
        </ul>
    </nav>
  </aside>
@endif

@if(Auth::check())
<section class="main">
@endif  
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
@if(Auth::check())  
</section>  
@endif

</body>
</html>
