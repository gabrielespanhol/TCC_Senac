<?php
 include_once('inc/classes.php');

  $objVagas = new Vaga();
  $objVeiculo = new Veiculos();

  //recebe os dados do cliente do ID informado no GET
  $veiculos = $objVeiculo->retornaDados($_GET['id']);
  // $veiculos = $objVeiculo->retornaDados(12);
  // $veiculos = $objVeiculo->listar();


  //atualizar dados do cliente
  if (isset($_POST['btnAtualizar'])){

    $objVeiculo->editar($_POST);

    echo '<pre>';
    echo '<h1> DADOS ATUALIZADO</h1>';
      print_r($_POST);
    echo '</pre>';
  }


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ATUALIZAR VEÍCULO</title>
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
    <!-- CAMPOS OCULTOS -->
                  <input type="hidden" name="id_veiculo" value="1">
                  <input type="hidden" name="id_veiculo" value="<?php echo $veiculos['id_veiculo'];?>">
                    
                    <!-- /CAMPOS OCULTOS -->
	
  <h2 class="text-center">ATUALIZAR VEÍCULO</h2>
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">ATUALIZE O VEÍCULO</h3>
				</div>
				<div class="panel-body">
				<form class="form-inline">
  				<div class="form-group">
    				<label for="exampleInputPlaca">Placa: </label>
    				<input type="text" class="form-control" id="placa" name="placa" value ="<?php echo $veiculos['placa']?>">
  				</div>
  			<div class="form-group">
  				
    			<label for="exampleInputVeiculo">Modelo: </label>
    		  <select name="id_marca_modelo" id="id_marca_modelo"  value ="<?php echo $veiculos['id_marca_modelo']?>">
                <?php
                    $veiculos = $objVeiculo->listar();
                  foreach ($veiculos as $veiculo){
                    echo '<option value="'.$veiculo['id_marca_modelo'].'">'.$veiculo['id_marca_modelo'].'</option>';
                  }
                ?>
              </select>

  			</div>
        <div class="form-group">
          
          <label for="exampleInputVeiculo">Cor: </label>
          
          <input type="text" class="form-control" id="cor" name="cor" value ="<?php echo $veiculo['cor'] ; ?>">

        </div>
				</form>
				<br />
				<form class="form-inline">
          <div class="form-group">
          <label for="exampleInputObs">Observações: </label>
          <textarea name="observacoes" class="form-control" id="observacoes" name="observacoes"></textarea> 
          
        </div>

  				<div class="form-group">
    				<label for="exampleInputVaga">Vaga: </label>
    				<select  name="id_vaga" class="form-control" id="vaga" name="vaga">
              <?php

                //array com as vagas livres
                $vagaslivres = $objVagas->mensaisLivres();

                foreach($vagaslivres as $vaga){
                  echo '<option value="'.$vaga['id_vaga'].'">'.$vaga['vaga'].'</option>';
                }
                
            ?>
            </select>
  				</div>

				<div class="form-group">
  				<button type="submit" class="btn btn-success" name="btnAtualizar">ATUALIZAR</button>
          <a class="btn btn-warning" href="veiculos-estacionados.php#<?php echo $veiculo['id_veiculo'];?>"  class="form-control btn btn-success">VOLTAR</a>
  			</div>
				</form>
			
			
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