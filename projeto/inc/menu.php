<nav class="navbar">
  <div class="container">
   <ul class="nav nav-pills">
	  <li class="active"><a href="#">Usuário:  <?php echo $_SESSION['nome_usuario'];?></a></li>
	  <li><a href="registrar-entrada">    <i class="glyphicon glyphicon-upload"></i> Entradas</a></li>
	  <li><a href="saidas-registradas">   <i class="glyphicon glyphicon-download"></i> Saidas</a></li>
	  <li><a href="veiculos-estacionados"><i class="glyphicon glyphicon-road"></i> Veículos Estacionados</a></li>
	  <li><a href="clientes-mensalistas"> <i class="glyphicon glyphicon-user"></i> Clientes Mensalistas</a></li>
	  <!-- <li><a href="#"><i class="glyphicon glyphicon-list-alt"></i> Relatórios</a></li> -->
	  <li><a href="sair">                 <i class="glyphicon glyphicon-log-out"></i> Sair</a></li>
	</ul>
  </div>
</nav>
