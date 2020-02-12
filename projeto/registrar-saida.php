<?php
 include_once('inc/classes.php');
 $objVeiculos     = new Veiculos();
 $objUsuario  = new Usuario();
 //verificar se o usuario está logado
 $objUsuario->logado(); 

$saida = $objVeiculos->listarSaidasHoje();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SAÍDA DE VEÍCULO</title>
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
	<!-- LINHA 2 -->
	<div class="row">
	<h2 class="text-center">LISTA DE SAÍDA</h2>
		<!-- VEÍCULOS ESTACIONADOS -->
		<div class="panel col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">LISTA DE VEÍCULOS </h3>
			</div>
			<div class="panel-body">
			    <!-- LISTA DE VEÍCULOS -->
			    <div class="bs-example" data-example-id="hoverable-table"> 
			    <table class="table table-hover table-striped"> 
			    	<thead> 
			    		<tr>
			    			<th class="col-md-1">#</th> 
			    			<th class=" col-md-2 ">VEÍCULO</th> 
			    			<th class=" col-md-3 ">PERMANÊNCIA</th>
			    			<th class=" col-md-2 ">VALOR</th>
			    			<th class=" col-md-2 ">TIPO</th>			    			 
			    			<th class="col-md-2">OBSERVAÇÕES</th>
			    		</tr> 
			    	</thead> 
				    	<tbody> 

				    		<?php
						// recebe um array com todos os veículos que sairam
						$x = 1; // apenas para mostra a quantidade de carros 
						$saidas = $objVeiculos->listarSaidasHoje();
						foreach($saidas as $saida) {

						echo '<tr id="'.$saida['id_entrada_saida'].'">';
											
							echo '<th>'.$x.'</th>';
							echo '<td><strong>'.$saida['placa'].'<br>'. $saida['marca'].'<br>'. $saida ['modelo']. '<br>'.$saida['cor'].'</strong></td>';
							echo '<td>'.'Entrada: '.$saida['entrada'].'<br>'.'Saida: '.$saida['saida'].'<br>'.'Permanência: '.$saida['permanencia'].'<br>Vaga: '.$saida['vaga'].'</td>';	
							echo '<td>'.'R$ '.$saida['valor'].'</td>';
							echo '<td>'.$saida['tipo'].'</td>';
							echo '<td>'.$saida['observacoes'].'</td>';

						echo '</tr>';
						$x++;
							}
							?>
				    	</tbody> 
			    </table> 
			    </div>
			    <!-- /LISTA DE VEÍCULOS -->
			</div>
		</div>
		</div>
		<!-- /VEÍCULOS ESTACIONADOS -->	
	</div>
	<!-- /LINHA 2 -->
</div>
<!-- CONTEUDO -->
<!-- RODAPE -->
<?php include_once('inc/rodape.php') ;?>
<!-- /RODAPE -->	
</body>
</html>