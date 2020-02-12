<?php
 include_once('inc/classes.php');
 $objCliente     = New Cliente();

 $objUsuario      = new Usuario();
 //verificar se o usuario está logado
 $objUsuario->logado(); 

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CLIENTES MENSALISTAS</title>
	<?php include_once('inc/css-js.php'); ?>
</head>
<body>
<!-- TOPO -->
<?php include_once('inc/topo.php') ;?>
<!-- /TOPO -->
<!-- MENU -->
<?php include_once('inc/menu.php') ;?>
<!-- /MENU -->
<!-- CONTEUDO -->
	<div class="container-fluid">
		<!-- LINHA 1 -->
			<div id="row">
				<h2 class="text-center">CLIENTES MENSALISTAS</h2>
					<!-- PESQUISAR CLIENTE -->
						<div class="col-sm-12 col-md-12 col-lg-12">
							<div class="panel panel-primary">
								<div class="panel-heading"><h3 class="panel-title">Pesquisar Cliente</h3></div>
									<div class="panel-body">				   
										<!-- FORMULARIO LOGIN  -->
											<form class="form-inline" role="form" method="POST" action="?">
												<div class="form-group">

												<label for="nomeCpf">Nome / CPF</label>
												<input type="text" name="termoPesquisa" class="form-control" id="nomeCpf" placeholder="digite o nome ou cpf">
												</div>

												<div class="form-group">
												<button type="submit" name="btnPesquisar" class=" form-control btn btn-success">Pesquisar</button>
												</div>				
											</form>
										<!-- /FORMULARIO LOGIN  -->					   
									</div>
							</div>
						</div>
					<!-- /PESQUISAR CLIENTE -->
			</div>
		<!-- /LINHA 1 -->

		<!-- LINHA 2 -->
			<div class="row">
				<h2 class="text-center">LISTA DE CLIENTES MENSALISTAS | <a href="cadastro-de-cliente" class="btn btn-primary"> <i class="glyphicon glyphicon-plus"></i> Cadastrar Novo Cliente</a></h2>   
					<div class="panel col-sm-12 col-md-12 col-lg-12">
						<div class="panel panel-primary">
							<div class="panel-heading"><h3 class="panel-title">VEÍCULOS ESTACIONADOS</h3></div>
								<!-- LISTA DE CLIENTE -->
									<div class="panel-body">
										<div class="bs-example" data-example-id="hoverable-table">
											<table class="table table-hover">
												<thead>	   	
													<tr>
														<th class=" col-md-2 ">Ações</th>
														<th class=" col-md-1 ">#</th>
														<th class=" col-md-3 ">Nome</th>
														<th class=" col-md-2 ">CPF</th>
														<th class=" col-md-1 ">DDD</th>
														<th class=" col-md-2 ">Tel/Cel</th>
													</tr>					    	
												</thead>
												
												<tbody>							
													<?php
														//Verificar se foi realizada uma pesquisa
														if(isset($_POST['btnPesquisar'])) {
															
															$clientes = $objCliente->pesquisarCliente($_POST['termoPesquisa']);
														}else{
															//listar todos clientes mensalistas
															$clientes = $objCliente->listar();
													   }
													   
														foreach ($clientes as $cliente){
														echo '<tr id="'.$cliente['id_cliente'].'">';
														echo '<th>';
														// echo '<a class="btn btn-success" href="atualizar-cliente.php?id='.$cliente['id_cliente'].'"><i class="glyphicon glyphicon-pencil"></i> EDITAR</a>';
														// echo '<a class="btn btn-warning" href="tela-cliente.php?id='.$cliente['id_cliente'].'"><i class="glyphicon glyphicon-zoom-in"></i>VER</a>';
														echo '<a class="btn btn-success" href="atualizar-cliente-'.$cliente['id_cliente'].'"><i class="glyphicon glyphicon-pencil"></i> EDITAR</a>';
														echo '&nbsp;&nbsp;<a class="btn btn-warning" href="ficha-cliente-'.$cliente['id_cliente'].'"><i class="glyphicon glyphicon-zoom-in"></i>VER</a>';
														echo '</th>';

														echo '<th>'.$cliente['id_cliente'].'</th>';
														echo '<th>'.$cliente['nome'].'</th>';
														echo '<td>'.$cliente['cpf'].'</td>';
														echo '<td>'.$cliente['ddd'].'</td>';
														echo '<td>'.$cliente['telefone'].'</td>';																			
														echo '</tr>';									
														}//fecha foreach
													?>
												</tbody>
											</table>
										</div>
									</div>
								<!-- /LISTA DE CLIENTE -->
					</div>
				</div>
			</div>
		<!-- /LINHA 2 -->
	</div>
<!-- CONTEUDO -->
<!-- RODAPE -->
<?php include_once('inc/rodape.php') ;?>
<!-- /RODAPE -->	
</body>
</html>