<?php
 include_once('inc/classes.php');

$objUsuario = new Usuario();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>LISTA DE USUÁRIOS</title>
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
	<h2 class="text-center">USUÁRIOS</h2>
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">PESQUISAR USUÁRIOS</h3>
			</div>
			<div class="panel-body">
				<form class="form-inline" role="form" method="POST" action="#">
					<div class="form-group">
						<label id="idClie">NOME DO USUÁRIO: </label>
							<input type="text" class="form-control" id="idClie">
							<button type="submit" class="form-control btn btn-success">PESQUISAR</button>
							<a class="btn btn-warning" href="index.php"  class="form-control btn btn-success">VOLTAR</a>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>
</div>
<div class="row">
	<h2 class="text-center">LISTA DE USUÁRIOS | <a href="cadastrar-usuario.php" class="btn btn-primary"> <i class="glyphicon glyphicon-plus"></i> CADASTRAR NOVO USUÁRIO</a></h2>
	<div class="panel col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">USUÁRIOS</h3>
			</div>
<div class="panel-body">
	<div class="bs-example" data-example-id="hoverable-table">
		<table class="table table-hover">
			<thead>
				<tr>
					<th class="col-md-2">AÇÕES</th>
					<th class="col-md-2">ID USUÁRIO</th>
					<th>NOME DO USUÁRIO:</th> 
				</tr>
			</thead>
			<tbody>
				<?php
				$x = 1;
              $usuario = $objUsuario ->listar();
              foreach($usuario as $usuario) {
              	echo '<tr>';
              	echo '<th>';
							echo '<a class="btn btn-warning" href="#"><i class="glyphicon glyphicon-pencil"></i>EDITAR</a>';	
						echo '</th>';		
              	echo '<th>'.$usuario['id_usuario'].'</th>';
                echo '<th>'.$usuario['nome'].'</th>';
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




<!-- CONTEUDO -->
<!-- RODAPE -->
<?php include_once('inc/rodape.php') ;?>
<!-- /RODAPE -->	
</body>
</html>