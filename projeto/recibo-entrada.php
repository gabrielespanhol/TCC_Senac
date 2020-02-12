<?php
 include_once('inc/classes.php');


 $objEntradaSaida = new EntradaSaida();
 $objVeiculos     = new Veiculos();

$entrada = $objEntradaSaida->dadosEntradaSaida($_GET['id']);
print_r($entrada);

$veiculo = $objVeiculos->retornaDados($entrada['id_veiculo']);
print_r($veiculo);

$dt_entrada =  new DateTime($entrada['entrada']);
$dt_saida =  new DateTime($entrada['saida']);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ESTACIONAMENTO</title>
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
			<input type="hidden" name="id_cliente" value="1">
				<h2 class="text-left">RECIBO DE ENTRADA</h2>
					<div class="col-md-6">
						<div class="panel panel-primary"> 
							<div class="panel-heading"><h3 class="panel-title">Recibo de Entrada</h3></div>			
								<div class="panel-body">
									<div class="row">
										<fieldset class="col-md-7 col-md-offset-1">	
										<legend>ENTRADA</legend>
										
											<div class="col-md-12">
											<p> <label>Placa:</label><?php echo $veiculo['placa']?></p>
											</div>

											<div class="col-md-12">
											<p> <label>Marca/Modelo:</label><?php echo $veiculo['id_marca_modelo']?></p>
											</div>

											<div class="col-md-12">
											<p> <label>Cor:</label><?php echo $veiculo['cor']?></p>
											</div>

											<div class="col-md-12">
											<p><label>Dt/Hr Entrada:</label><?php echo $dt_entrada->format('d/m/Y H:i:s');?></p>
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
