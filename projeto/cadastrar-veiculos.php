<?php
 include_once('inc/classes.php');

 $objVagas    = new Vaga();
 $objVeiculos = new Veiculos();
 $objCliente  = new cliente();
 $objPeriodo  = new periodo();
 $objUsuario  = new Usuario();
 //verificar se o usuario está logado
 $objUsuario->logado(); 

#PEGAR A URL
// $id_cliente = str_replace('/', '', $_SERVER['QUERY_STRING']);
$id_cliente = $_SERVER['QUERY_STRING'];

// $cliente    = $objCliente->retornaDados($_GET['id']);
 $cliente    = $objCliente->retornaDados($id_cliente);


 
 //verificar se um veiculo foi cadastrado
 if (isset($_POST['btnCadastrar'])) {
   
   //cadastrar o veiculo
   $id_veiculo = $objVeiculos->cadastrar($_POST['id_marca_modelo'],$_POST['id_cliente'],$_POST['placa'],$_POST['cor']);
   
   // cadastrar o pagamento e periodo
   $objVeiculos->cadastrarPerioDoPagamento($_POST['id_cliente'], $id_veiculo, $_POST['id_periodo'],$_POST['valor']);
  
   //redirecionar a tela
    header('location:ficha-cliente-'.$_POST['id_cliente']);
 }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CADASTRO DE VEÍCULO</title>
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
    <div class="panel panel-primary"> 
      <div class="panel-heading"> <h3 class="panel-title">CLIENTE: <?php echo $cliente['nome'];?> </h3></div> 
        <!-- DADOS -->
          <div class="panel-body">
            <div class="row">
              <fieldset class="col-md-6">
                <legend>Dados do Cliente</legend>
                  <div class="col-md-8">
                    <p><label>Nome:</label> <?php echo $cliente['nome'];?></p>
                  </div>

                  <div class="col-md-4">
                    <p><label>CPF:</label> <?php echo $cliente['cpf'];?></p>
                  </div>
              </fieldset>
             
            </div>
          </div>
    </div>
  </div>

  <div class="container">
    <div id="row">
      <h2 class="text-center">CADASTRO DE VEÍCULO</h2>
        <div class="col-md-12">
          <div class="panel panel-primary">
            <div class="panel-heading"><h3 class="panel-title">CADASTRE O VEÍCULO</h3></div>
              <div class="panel-body">
                
                <form class="form-inline" method="POST" action="?">
                  <input type="hidden" name="id_cliente" value="<?php echo  $cliente['id_cliente']; ?>">
                  <div class="form-group">
                    <label for="placa">Placa: </label>
                    <input type="text" name="placa" class="form-control" id="placa" placeholder="AAA0000">
                  </div>

                  <div class="form-group">
                    <label for="id_marca_modelo">Modelo: </label>
                    <select name="id_marca_modelo" class="form-control lista-de-marcas-de-carros" id="id_marca_modelo">
                      <?php
                       $marcas = $objVeiculos->listarMarcas();
                        foreach ($marcas as $marca) {
                          echo '<option value="'.$marca['id_marca_modelo'].'">'.$marca['marca'].'/'.$marca['modelo'].'</option>';
                        }
                        ?>
                    </select>                   
                  </div>
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
                  <br><br>
                  <div class="form-group">
                    <label for="id_periodo">Período: </label>
                    <select name="id_periodo" class="form-control" id="id_periodo">

                      <?php

                       $periodo    = $objPeriodo->listarPeriodos();
                      
                        foreach ($periodo as $periodo) {
                          echo '<option value="'.$periodo['id_periodo'].'">'.$periodo['periodo'].'</option>';
                       }
                        ?>
                    </select>                   
                  </div>

                  <div class="form-group">
                      <label for="valor">Valor:</label>
                      <input type="number" name="valor" class="form-control" id="valor">
                  </div>

                  

                  <button type="submit" class="btn btn-info" name="btnCadastrar">CADASTRAR</button>
                  <!-- VOLTAR -->          
                      <!-- <a class="btn btn-warning" href="cliente-mensalistas#<?php echo $cliente['id_cliente'];?>"  class="form-control btn btn-success">VOLTAR</a> -->
                      <a class="btn btn-warning" href="ficha-cliente-<?php echo $cliente['id_cliente'];?>"  class="form-control btn btn-success">VOLTAR</a>
                  <!-- /VOLTAR -->    
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
<script>
$('#placa').mask("aaa9999");

//transformar em caixa alta
  $('#placa').blur(function() {
     $('#placa').val(this.value.toUpperCase());
  });
// LISTA DE VEICULOS
$(document).ready(function() {
    $('.lista-de-marcas-de-carros').select2();
});

</script>
</html>