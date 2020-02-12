<?php
 include_once('inc/classes.php');

 $objUsuario = new Usuario();

 
 //atualizar dados do usuario
 if (isset($_POST['btnAtualizar'])) {

  $objUsuario->editar($_POST);

   // redirecionar a tela
    
 }


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CADASTRO DE USUÁRIO</title>
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
  <!-- LINHA 1 -->
  <div id="row">
  <h2 class="text-center">CADASTRAR USUÁRIO</h2>    
    <div class="panel panel-primary">
        <div class="panel-heading"><h2 class="panel-title">Cadastro de Usuário</h2></div>
                
                <form method="POST" action="?">
                  <!-- DADOS DO USUÁRIO -->

                  <div class="row">
                      <fieldset class="col-md-12">
                        <legend>Dados do Usuário</legend>
                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="Nome">Nome: </label>
                              <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome:">
                            </div>
                          </div>
                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="email">E-mail</label>
                              <input type="email" id="email" name="email" class="form-control" placeholder="E-mail">
                            </div>
                          </div>
                           <div class="col-md-3">
                        <div class="form-group">
                          <label for="senha">Senha:</label>
                          <input type="password" id="senha" name="senha" class="form-control" placeholder="*****">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="confSenha">Confirmar Senha:</label>
                          <input type="password" id="confSenha" name="confSenha" class="form-control" placeholder="*****">
                        </div>
                      </div>
                      <input type="hidden" name="id_usuario" value="1">
                      <input type="hidden" name="id_nivel_acesso" value="1">
                  </div>
                      </fieldset>         
                 <!-- /DADOS DO USUÁRIO -->

                 <!-- BOTAO CADASTAR-->                      
                        <div class="col-md-2">
                          <div class="form-group">
                            <button type="submit" class=" form-control btn btn-primary" name='btnCadastrar'>CADASTRAR NOVO USUÁRIO </button>
                          </div> 
                        </div> 
                      <!-- /BOTAO CADASTRAR-->                      
                        <!-- BOTAO ATUALIZAR-->                      
                        <div class="col-md-1">
                          <div class="form-group">
                            <button type="submit" class="form-control btn btn-success" name="btnAtualizar">ATUALIZAR</button>
                          </div> 
                        </div> 

                      <!-- /BOTAO ATUALIZAR-->
                      <!-- VOLTAR -->
                    <div class="col-md-1">
                      <div class="form-group">
                      <a class="btn btn-warning" href="index.php"  class="form-control btn btn-success">VOLTAR</a>
                      </div> 
                    </div>
                  <!-- /VOLTAR -->        
                        <br/>         
                        <br/> 
                </form><!--fim form -->
</div>
</div>    

<!-- CONTEUDO -->
<!-- RODAPE -->
<?php include_once('inc/rodape.php') ;?>
<!-- /RODAPE -->  
</body>
</html>
