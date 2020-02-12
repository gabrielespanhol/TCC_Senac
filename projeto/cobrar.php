<?php
 include_once('inc/classes.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>COBRAR</title>
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
	<div id="row">
	<h2 class="text-center">REGISTRAR SAÍDA DE VEÍCULO</h2>
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">INFORMAÇÕES DA COBRANÇA</h3>
			</div>
			<div class="panel-body">
				<form class="form-inline" role="form" method="POST" action="#">
					<div class="form-group">
						<label for="entrada">Entrada: </label>
						<input type="#" class="form-control" id="#">
					</div>
					<div class="form-group">
						<label for="saida">Saída: </label>
						<input type="#" class="form-control" id="#">
					</div>
					<div class="form-group">
						<label for="permanencia">Permanência: </label>
						<input type="#" class="form-control" id="#">
					</div>
					</form>
                    <br />
					<form class="form-inline" role="form" method="POST" action="#">
						<div class="form-group">
						<label for="pagamento">Tipo de pagamento: </label>
						<input type="#" class="form-control" id="#">
					</div>
					<div class="form-group">
						<label for="valor">Valor: </label>
						<input type="#" class="form-control" id="#">
					</div>

					<div class="form-group">
						<button type="submit" class="form-control btn btn-danger"><i class="glyphicon glyphicon-usd"></i> COBRAR</button>
						
					</div>
				</form>
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