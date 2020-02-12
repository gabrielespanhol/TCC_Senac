<?php
 include_once('inc/classes.php');


 $objEntradaSaida = new EntradaSaida();
 $objVeiculos     = new Veiculos();
 $objUsuario      = new Usuario();
 
 //verificar se o usuario está logado
 $objUsuario->logado(); 

//pegar informações da url
 $id_entrada_saida = $_SERVER['QUERY_STRING'];

// $entrada = $objEntradaSaida->dadosEntradaSaida($_GET['id']);

$entrada = $objEntradaSaida->dadosEntradaSaida($id_entrada_saida);
// print_r($entrada); die();

//registrar a saida, efetuar o calculo de cobrança
$objEntradaSaida->registrarSaida($entrada['id_veiculo'], $entrada['id_vaga'], $entrada['id_entrada_saida'],$_SESSION['id_usuario'], $entrada['id_tipo_pagamento'], $entrada['entrada'],$entrada['observacoes']);


$entrada = $objEntradaSaida->dadosEntradaSaida($id_entrada_saida);
// print_r($entrada);

$veiculo = $objVeiculos->retornaDados($entrada['id_veiculo']);
// print_r($veiculo);
$dt_saida   =  new DateTime($entrada['saida']);
$dt_entrada =  new DateTime($entrada['entrada']);




?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ESTACIONAMENTO | RECIBO DE SAIDA</title>
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
		<div id="row">
			
				<h2 class="text-center">RECIBO DE SAIDA</h2>
					<div class="col-md-6 col-md-offset-3">
						<div class="panel panel-primary"> 
							<div class="panel-heading"><h3 class="panel-title">Recibo de Saida</h3></div>			
								<div class="panel-body">
									<div class="row">
										<fieldset>	
										<legend class="text-center">VEÍCULO</legend>
											<div class="col-md-3">
												<p> <label>Placa:</label><?php echo $veiculo['placa']?></p>
											</div>

											<div class="col-md-5">
											<p> <label>Marca/Modelo:</label><?php echo $objVeiculos->nomeMarca($veiculo['id_marca_modelo']);?></p>
											</div>

											<div class="col-md-4">
											<p> <label>Cor:</label><?php echo $veiculo['cor']?></p>
											</div>
										</fieldset>
									</div>
									<div class="row">
										<fieldset>
											<legend class="text-center">PERMANÊNCIA - VALOR</legend>
											<div class="col-md-6">
												<p><label>Entrada: </label><?php echo $dt_entrada->format('d/m/Y H:i:s');?></p>
											</div>
											<div class="col-md-6">
												<p><label>Saída: </label><?php echo $dt_saida->format('d/m/Y H:i:s');?></p>
											</div>

											<div class="col-md-6">
												<p><label>Permanência: </label><?php echo $entrada['permanencia']?>h</p>
											</div>
											<div class="col-md-6">
												<p><label>Valor: </label> R$  <?php echo $entrada['valor']?></p>
											</div>

										</fieldset>
											
											

										
									</div>
								</div>
						</div>
					</div>
		</div>
	</div>
<!-- CONTEUDO -->
<!-- RODAPE -->
<?php include_once('inc/rodape.php') ;?>
<!-- /RODAPE -->	
</body>
</html>
