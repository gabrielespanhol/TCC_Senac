<?php
 include_once('inc/classes.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>REGISTRAR ENTRADA</title>
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
	<h2 class="text-center">REGISTRAR ENTRADA DE VEÍCULO</h2>
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">PESQUISAR VEÍCULO</h3>
			</div>
			<div class="panel-body">
				<form class="form-inline" role="form" method="POST" action="#">
					<div class="form-group">
						<label for="placa">PLACA</label>
						<input type="text" class="form-control" id="placa" placeholder="AAA0000">
					</div>
					<div class="form-group">
						<button type="submit" class="form-control btn btn-success">PESQUISAR</button>
						<button type="submit" class="form-control btn btn-warning">CADASTRAR</button>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>
</div>
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
					<th class="col-sm-2 col-md-2 col-lg-2">AÇÕES</th>
					<th>#</th>
					<th class="col-sm-1 col-md-1 col-lg-1">PLACA</th>
					<th class="col-sm-1 col-md-1 col-lg-1">ENTRADA</th>
                    <th>VEÍCULO</th>
                    <th>TIPO</th>
                    <th>VAGA</th>
                    <th>OBSERVAÇÕES</th>


				</tr>
			</thead>
			<tbody>
				<tr>
					<th>
						<a class="btn btn-success" href="#"><i class="glyphicon glyphicon-usd"></i>COBRAR</a>
						<a class="btn btn-warning" href="#"><i class="glyphicon glyphicon-zoom-in"></i>VER</a>
						</th>

					
					<th>1</th>
					<th>AAA1234</th>
					<td>10:42h</td>
					<td>FUSCA/BRANCO</td>
					<td>MENSALISTA</td>
					<td>01</td>
					<td>AMASSADO</td>
					<th>
					<a class="btn btn-info" href="#"><i class="glyphicon glyphicon-pencil"></i>EDITAR</a>
					</th>

				</tr>
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