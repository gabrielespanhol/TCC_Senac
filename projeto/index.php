<?php
 include_once('inc/classes.php');


 // realizar o Login
 if (isset($_POST['btnLogar'])) {
 	
 	$objUsuario =  new Usuario();
 	$autorizado = $objUsuario->logar($_POST['email'],$_POST['senha']);

 	//se o usuario e senha estiverem corretos, direcionar para a tela de veúculos estacionados
 	if ($autorizado == true) {

 		header('location:veiculos-estacionados.php');
 	} else {

 		header('location:index.php?m');
 	}
 	

 }

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
<!-- CONTEUDO -->
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Acesso ao Sistema</div>
				<div class="panel-body">
					<!-- FORMULARIO LOGIN  -->
					<form class="form-horizontal" role="form" method="POST" action="">
						<div class="form-group">
							<label class="col-md-4 control-label">Login</label>
							<div class="col-md-6">
								<input type="email" name="email" class="form-control" name="login" value="">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Senha</label>
							<div class="col-md-6">
								<input  name="senha" type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" name="btnLogar" class="btn btn-primary">Acessar Sistema</button>								
							</div>
						</div>
					</form>
					<!-- /FORMULARIO LOGIN  -->
					<!-- ALERTA DE FALHA DE ACESSO  -->
					<?php 

						if(isset($_GET['m'])){
							echo '<div class="alert alert-danger" role="alert">';
							echo '<p class="text-center"><strong>Usuário ou Senha Inválido</strong></p>';
							echo '</div>';
					 	}

					 	if(isset($_GET['n'])){
							echo '<div class="alert alert-danger" role="alert">';
							echo '<p class="text-center"><strong>ACESSO NEGADO</strong></p>';
							echo '</div>';
					 	}
					 ?>
					<!-- /ALERTA DE FALHA DE ACESSO  -->
					
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