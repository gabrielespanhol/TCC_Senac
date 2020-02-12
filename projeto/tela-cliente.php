<?php
 include_once('inc/classes.php');

 $objCliente 	= new cliente();
 $objVeiculo 	= new veiculos();
 $objUsuario 	= new Usuario();
 $objPeriodo 	= new Periodo();
 $objMensalista = new Mensalista();
 
 //pegar informações da url
 $id_cliente = $_SERVER['QUERY_STRING'];

 $cliente  = $objCliente->retornaDados($id_cliente);
 $veiculos = $objVeiculo->carrosCliente($id_cliente);

 //verificar se o usuario está logado
 $objUsuario->logado(); 

 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CLIENTE</title>
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
	<div class="container">
		<div class="panel panel-primary"> 
			<div class="panel-heading"> <h3 class="panel-title">CLIENTE: <?php echo $cliente['nome'];?> </h3></div> 
			<!-- DADOS -->
				<div class="panel-body">
					<div class="row">
						<fieldset class="col-md-6">
							<legend>Dados do Cliente</legend>
								<div class="col-md-8">
									<p> <label>Nome:</label> <?php echo $cliente['nome'];?></p>
								</div>

								<div class="col-md-4">
									<p> <label>CPF:</label> <?php echo $cliente['cpf'];?></p>
								</div>
						</fieldset>

						<fieldset class="col-md-5">
							<legend>Dados de Contatos</legend>
								<div class="col-md-3">
									<p> <label>DDD: </label> <?php echo $cliente['ddd'];?></p>
								</div>

								<div class="col-md-5">
									<p> <label>Telefone ou Celular:</label> <?php echo $cliente['telefone'];?></p>
								</div>
						</fieldset>
					</div>

					<div class="row">
						<fieldset class="col-md-12">
							<legend>Endereço</legend>
								<div class="col-md-3">
								<p> <label>CEP:</label> <?php echo $cliente['cep']?></p>
								</div>

								<div class="col-md-3">
								<p> <label>Endereço:</label> <?php echo $cliente['endereco']?></p>
								</div>

								<div class="col-md-3">
								<p> <label>Nº:</label> <?php echo $cliente['numero']?></p>
								</div>

								<div class="col-md-3">
								<p> <label>Complemento:</label> <?php echo $cliente['complemento']?></p>
								</div>

								<div class="col-md-3">
								<p> <label>Bairro:</label> <?php echo $cliente['bairro']?></p>
								</div>

								<div class="col-md-3">
								<p> <label>Cidade:</label> <?php echo $cliente['cidade']?></p>
								</div>

								<div class="col-md-3">
								<p> <label>UF:</label> <?php echo $cliente['uf']?></p>
								</div>
						</fieldset>
					</div>
					<!-- VOLTAR -->
					<div class="form-group">
                      <a class="btn btn-warning" href="cliente-mensalistas#<?php echo $cliente['id_cliente'];?>"  class="form-control btn btn-success">VOLTAR</a>
                    </div>
                    <!-- /VOLTAR -->					
				</div>
			<!-- /DADOS -->
			
		</div>


		<!-- LISTAR OS CARROS -->
		<div class="panel panel-success"> 
			<div class="panel-heading"> <h3 class="panel-title">CARROS DO CLIENTE : <?php echo $cliente['nome'];?></h3></div> 
			<!-- DADOS -->
				<div class="panel-body">
					<div class="row">
						<fieldset class="col-md-12">
							<legend>VEÍCULOS | <a class="btn btn-primary" href="cadastrar-veiculo-mensalista-<?php echo $cliente['id_cliente'];?> " class="form-control btn btn-primary">CADASTRAR VEÍCULOS</a></legend>

								<table class="table table-striped">
									<?php foreach ($veiculos as $veiculo) { ?>
									<tr><td>									
									<div class="col-md-4">
									<p> <label>Marca/Modelo:</label> <?php echo $objVeiculo->nomeMarca($veiculo['id_marca_modelo']);?></p>
									</div>

									<div class="col-md-3">
									<p> <label>Placa:</label> <?php echo $veiculo['placa']; ?></p>
									</div>

									<div class="col-md-2">
									<p> <label>Cor:</label> <?php echo $veiculo['cor']; ?></p>
									</div>

									<div class="col-md-2">
									<?php
										$validade = $objMensalista->validadeMensalista($cliente['id_cliente'],$veiculo['id_veiculo']);
										$termino=date_create($validade['dt_termino']);										
									?>								         					 
									<p> <label>Período: </label></p> <?php echo $objPeriodo->nomePeriodo($validade['id_periodo']);?></p>
									 
									</div>

									<div class="col-md-1">
									<p> <label>Validade: </label> <?php echo date_format($termino, 'd/m/Y') ;?></p>
									</div>
									</td></tr>									
															
								<?php } //fecha foreach ?>
							</table>					
						</fieldset>
					</div>
				</div>
		</div>

		<!-- /LISTAR OS CARROS -->
	</div>
<!-- CONTEUDO -->
<!-- RODAPE -->
<?php include_once('inc/rodape.php') ;?>
<!-- /RODAPE -->	
</body>
</html>