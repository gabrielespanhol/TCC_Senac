<?php
 include_once('inc/classes.php');

 // estanciar obj
 $objVeiculos     = new Veiculos();
 $objVagas        = new Vaga();
 $objEntradaSaida = new EntradaSaida();

 $objUsuario      = new Usuario();
 //verificar se o usuario está logado
 $objUsuario->logado();



 //EXECUTAR METODOS

 // REGISTRAR A ENTRADA DO VEICULO
 if (isset($_POST['btnRegistrarEntrada'])){

 	// variavel que irá armazenar o numero da entrada
 	$id_entrada = $objEntradaSaida->registrarEntrada($_POST['id_veiculo'], $_POST['id_usuario'], $_POST['id_vaga'],$_POST['observacoes']);
 	
 	//redirecionar a tela
     header('location:veiculos-estacionados#'.$id_entrada);
 }

if (isset($_POST['btnCadastrar'])){

 	// variavel que irá armazenar o numero da entrada
 	$id_veiculo = $objVeiculos->cadastrar($_POST['id_marca_modelo'],$_POST['id_cliente'],$_POST['placa'],$_POST['cor']);

 	// variavel que irá armazenar o numero da entrada
 	$id_entrada = $objEntradaSaida->registrarEntrada($id_veiculo, $_POST['id_usuario'], $_POST['id_vaga'],$_POST['observacoes']);
 	
 	//redirecionar a tela
     header('location:veiculos-estacionados#'.$id_entrada);
 	
 }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ESTACIONAMENTO | REGISTRAR ENTRADA</title>
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
	<!-- LINHA 2 -->
	
		<?php
			if(isset($_POST['btnPesquisar']) and  $_POST['placa'] !=''){
			
			// remove os espaços vazios da placa digitada
			$placa = trim($_POST['placa']);
			//aciona o metod de pesquisa de placa
			$resultado = $objVeiculos->pesquisarPlaca($placa);
			
			//se o veiculo já possuir cadastro
			 if ($resultado !=0 ) {  
			 ?>
	<div class="row">
		<h2 class="text-center">REGISTRAR ENTRADA DE VEÍCULO</h2>
		<!-- FORMULARIO REGISTRAR ENTRADA  -->
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
				    <h3 class="panel-title">REGISTRAR ENTRADA | VEÍCULO JÁ CADASTRADO - TIPO DA VAGA :<?php  echo $resultado['id_cliente']>1 ? 'MENSALISTA': 'AVULSA'; ?></h3>
				 </div>
				  <div class="panel-body">
				    <!-- FORMULARIO LOGIN  -->
					<form class="form-inline" role="form" method="POST" action="">
						 <div class="form-group">
						    <label for="placa">Placa</label>
						    <input type="text" name="placa" class="form-control" id="placa" value="<?php echo $resultado['placa'];?>">
						 	<!-- GUARDA O ID DO VEICULO -->
						 	<input type="hidden" name="id_veiculo" id="id_veiculo" value="<?php echo $resultado['id_veiculo'];?>">
						 	<input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo $resultado['id_cliente'];?>">
						 	<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id_usuario'];?>">
						 </div>
						 <div class="form-group">
						 	<label for="id_vaga">Vagas</label>
						 	<select name="id_vaga" id="id_vaga" class="form-control">
						 		<?php
						 		//se o id cliente for maior que 1 é mensalista
						 		    if ($resultado['id_cliente']>1) {
						 		    	$vagas = $objVagas->mensaisLivres();
						 		    }else{
						 		    	$vagas = $objVagas->avulsasLivres();
						 		    }

						 			foreach ($vagas as $vaga){
						 				echo '<option value="'.$vaga['id_vaga'].'">'.$vaga['vaga'].'</option>';
						 			}
						 		?>
						 	</select>
						 </div>	
						 <div class="form-group">
		                    <label for="obs">Observações:</label>
		                    <input type="text" name="observacoes" class="form-control" value="" id="obs">
		                  </div>

						<div class="form-group">
						<button type="submit" name="btnRegistrarEntrada" class="form-control btn btn-warning">REGISTRAR ENTRADA</button>
					   </div>			
				    </form>	   
					<!-- /FORMULARIO REGISTRAR ENTRADA  -->		
					</div>
		     </div>
		</div>
	</div>
	<!-- /LINHA 2 -->
	<?php } else { ?>

	<!-- LINHA 3 -->
	<!-- FORMULARIO DE CADASTRO DE VEICULO -->
		<div class="container">
		    <div id="row">
		      <h2 class="text-center">CADASTRO DE VEÍCULO</h2>
		        <div class="col-md-12">
		          <div class="panel panel-primary">
		            <div class="panel-heading"><h3 class="panel-title">CADASTRE O VEÍCULO</h3></div>
		              <div class="panel-body">
		                
		                <form class="form-inline" method="POST" action="?">
		                  <input type="hidden" name="id_cliente" value="1"> <!-- cliente avulso -->
		                  <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id_usuario'];?>">
		                  <div class="form-group">
		                    <label for="placa">Placa: </label>
		                    <input type="text" name="placa" class="form-control" value="<?php echo $placa;?>" id="placa" placeholder="AAA0000" required>
		                  </div>
		                  <div class="form-group">
		                    <label for="id_marca_modelo">Modelo: </label>
		                    <select name="id_marca_modelo" class="form-control lista-de-marcas-de-carros" id="id_marca_modelo" required>
		                      <?php
		                       $marcas = $objVeiculos->listarMarcas();
		                        foreach ($marcas as $marca) {
		                          echo '<option value="'.$marca['id_marca_modelo'].'">'.$marca['marca'].'/'.$marca['modelo'].'</option>';
		                        }
		                        ?>
		                    </select>

		                                   
		                  </div>
		                  <br><br>
		                  <div class="form-group">
						 	<label for="id_vaga">Vagas</label>
						 	<select name="id_vaga" id="id_vaga" class="form-control" required>
						 		<?php
						 		    $vagas = $objVagas->avulsasLivres();
						 			foreach ($vagas as $vaga){
						 				echo '<option value="'.$vaga['id_vaga'].'">'.$vaga['vaga'].'</option>';
						 			}
						 		?>
						 	</select>
		                  <div class="form-group">
		                    <label for="cor">Cor: </label>
		                    <select name="cor" class="form-control" id="cor" required>
		                    	<option value="">Selecion uma cor</option>
		                    	<option value="PRATA">PRATA</option>
		                    	<option value="PRETO">PRETO</option>
		                    	<option value="CINZA">CINZA</option>
		                    	<option value="BRANCO">BRANCO</option>
		                    	<option value="VERMELHO">VERMELHO</option>
		                    	<option value="AZUL">AZUL</option>
		                    	<option value="VERDE">VERDE</option>
		                    	<option value="MARROM">MARROM</option>
		                    	<option value="DOURADO/AMARELO">DOURADO/AMARELO</option>
		                    	<option value="LARANJA">LARANJA</option>
		                    	<option value="BEGE">BEGE</option>
		                    	<option value="OUTRAS">OUTRAS</option>                 	
		                    </select>
		                  </div>

		                  <div class="form-group">
		                    <label for="obs">Observações:</label>
		                    <input type="text" name="observacoes" class="form-control" value="" id="obs">
		                  </div>


		                  <button type="submit" class="btn btn-info" name="btnCadastrar">CADASTRAR</button>
		                </form>
		                                
		              </div>
		          </div>
		        </div>
		  </div>
	<!-- /FORMULARIO DE CADASTRO DE VEICULO -->
	<!--/ LINHA 3 -->

	<?php } //fecha o else do formula de cadastro de veiculo ?>

	<?php
        }//fecha o if
        else{
     ?> 
     	<!-- LINHA 1 -->
	<div id="row">
	<h2 class="text-center">REGISTRAR ENTRADA DE VEÍCULO</h2>
	<!-- PESQUISAR PLACA -->
			<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
				    <h3 class="panel-title">PESQUISAR VEÍCULO</h3>
				  </div>
				  <div class="panel-body">				   
				    <!-- FORMULARIO LOGIN  -->
					<form class="form-inline" role="form" method="POST" action="">
						 <div class="form-group">
						    <label for="placa">Placa</label>
						    <input type="text" name="placa" class="form-control" id="placa" placeholder="AAA0000">
						 </div>				 
						<div class="form-group">
						<button type="submit" name="btnPesquisar" class="form-control btn btn-success">PESQUISAR</button>
						<!-- <button type="submit" class="form-control btn btn-warning">CADASTRAR</button> -->
					</div>			
					</form>
					<!-- /FORMULARIO LOGIN  -->					   
				 </div>
			</div>
			</div>
		<!-- PESQUISAR PLACA -->		
	</div>
	<!-- /LINHA 1 -->
	<?php } //fecha o else ;?>
</div>
<!-- CONTEUDO -->
<!-- RODAPE -->
<?php include_once('inc/rodape.php') ;?>
<!-- /RODAPE -->	
</body>
<!-- funções jQuery -->
<script>
	
	$('#placa').mask("aaa9999");

	//transformar em caixa alta
	$('#placa').blur(function() {
		 $('#placa').val(this.value.toUpperCase());
		 // let teste = this.value.toUpperCase();
		 // console.log(teste);
	});

// LISTA DE VEICULOS
$(document).ready(function() {
    $('.lista-de-marcas-de-carros').select2();
});

	// $('#placa').keypress(function() {
	//  $('#placa').val(this.value.toUpperCase());
	// });


	

</script>
<!-- /funções jQuery -->

</html> 