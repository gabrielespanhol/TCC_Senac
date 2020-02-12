<?php
 include_once('inc/classes.php');

 //ESTACIAR O OBJ
 $objEntradaSaida = new EntradaSaida();
 $objVagas        = new Vaga();

 $objUsuario      = new Usuario();
 //verificar se o usuario está logado
 $objUsuario->logado(); 


// if (isset($_POST['btnCobrar'])) {

// 	$cobrar = $objEntradaSaida->registrarSaida($_POST['id_veiculo'], $_POST['id_vaga'], $_POST['id_entrada_saida'], $_POST['id_usuario_saida'], $_POST['id_tipo_pagamento'], $_POST['observacoes']);
// 	// header('location:recibo-saida.php?'.$cobrar['id_entrada_saida']);
// 	header('location:recibo-saida-'.$cobrar);
// }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>VEÍCULOS MENSALISTAS</title>
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

<div class="row">
	<h2 class="text-center">LISTA DE VEÍCULOS ESTACIONADOS</h2>
	<div class="panel col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">VEÍCULOS ESTACIONADOS</h3>
			</div>
<div class="panel-body">
	<div class="bs-example" data-example-id="hoverable-table">
		<table class="table table-hover">
			<thead>
				<tr>
					<th class="col-md-2">AÇÕES</th>
					<th class="col-md-1 ">#</th>
					<th class="col-md-1">PLACA</th>
					<th class="col-md-2">ENTRADA</th>
                    <th class=" col-md-1 ">VEÍCULO</th>
                    <th class=" col-md-1 ">TIPO</th>
                    <th class=" col-md-1 ">VAGA</th>
                    <th class=" col-md-2 ">OBSERVAÇÕES</th>
				</tr>
			</thead>
			<tbody>

				<?php
					// recebe um array com todos os veículos estacionados
					$x = 1; // apenas para mostra a quantidade de carros 
					$veiculos = $objEntradaSaida->listarVeiculosEstacionados();
					foreach($veiculos as $veiculo) {

					echo '<tr id="'.$veiculo['id_entrada_saida'].'">';
						echo '<th>';
							// echo '<a class="btn btn-success" href="recibo-saida.php?id='.$veiculo['id_entrada_saida'].'"><i class="glyphicon glyphicon-usd"></i> COBRAR</a>';
							echo '<a class="btn btn-success" href="recibo-saida-'.$veiculo['id_entrada_saida'].'"><i class="glyphicon glyphicon-usd"></i> COBRAR</a>';
							// echo '<a class="btn btn-warning" href="#"><i class="glyphicon glyphicon-zoom-in"></i> VER</a>';
						echo '</th>';				
						echo '<th>'.$x.'</th>';
						echo '<th>'.$veiculo['placa'].'</th>';
						echo '<td>'.$veiculo['entrada'].'h<br> Permanencia: '.$objEntradaSaida->calcularTempoDePermanencia($veiculo['data_hora_entrada']).'<br> Valor: R$ '.$objEntradaSaida->exibirValor($veiculo['id_veiculo'], $veiculo['id_entrada_saida']).'</td>';
						echo '<td>'.$veiculo['veiculo'].'</td>';
						echo '<td>'.$veiculo['tipo'].'</td>';
						echo '<td>'.$veiculo['vaga'].'</td>';
						echo '<td>'.$veiculo['observacoes'].'</td>';			
					echo '</tr>';
					$x++;
				}
				?>
			</tbody>
		</table>
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