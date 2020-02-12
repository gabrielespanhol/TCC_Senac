<?php
 include_once('inc/classes.php');

  $objCliente = New Cliente();
  $objUsuario = new Usuario();
 //verificar se o usuario está logado
 $objUsuario->logado();

 //pegar informações da url
 $id_cliente = $_SERVER['QUERY_STRING'];

  //recebe os dados do cliente do ID informado no GET
  // $cliente = $objCliente->retornaDados($_GET['id']);
  $cliente = $objCliente->retornaDados($id_cliente);

  //atualizar dados do cliente
  if (isset($_POST['btnAtualizar'])){
     $objCliente->editar($_POST);

     //redirecionar a tela
     // header('location:tela-cliente.php?id='.$_POST['id_cliente']);
     header('location:ficha-cliente-'.$_POST['id_cliente']);

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
<!-- MENU -->
<?php include_once('inc/menu.php') ;?>
<!-- /MENU -->
<!-- CONTEUDO -->
  <div class="container">    
    <div class="panel panel-primary">
        <div class="panel-heading"><h2 class="panel-title">Atualizar Cliente : <?php echo $cliente['nome'] ?></h2></div>
          <form method="POST" action="?">
            <!-- DADOS DO CLIENTE -->
              <div class="row">
                <!-- CAMPOS OCULTOS -->
                  <input type="hidden" name="id_usuario" value="1">
                  <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente'];?>">
                  <input type="hidden" name="id_tipo_cliente" value="<?php echo $cliente['id_tipo_cliente'];?>">
                <!-- /CAMPOS OCULTOS -->

                <fieldset class="col-md-6">
                  <legend>Dados do Cliente</legend>
                    <div class="col-md-8">
                      <div class="form-group">
                        <label for="Nome">Nome:</label>
                        <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome:"  value ="<?php echo $cliente['nome'];?> " required>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" id="cpf" name='cpf' class="form-control" placeholder="CPF:" value ="<?php echo $cliente['cpf'];?>" required>
                        <div id="alerta" class="alert alert-danger">CPF INVÁLIDO</div>
                      </div>
                    </div>
                </fieldset>
                <!-- DADOS DE CONTATOS -->
                  <fieldset class="col-md-6">
                    <legend>Dados de Contato</legend>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="DDD">DDD:</label>
                          <input type="tel" id="ddd" name="ddd" class="form-control" placeholder="xx" value ="<?php echo $cliente['ddd'];?> " maxlength="2" required>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group"> 
                          <label for="telefone">Telefone ou Celular</label>
                          <input type="text" id="telefone" name="telefone" class="form-control"  value ="<?php echo $cliente['telefone'];?> " placeholder="0 0000-0000" required>
                        </div>
                      </div>
                  </fieldset>
              </div>
                <!-- /DADOS DE CONTATOS -->
            <!-- /DADOS DO CLIENTE -->

            <!-- ENDEREÇO -->                 
            <div class="row">
              <fieldset class="col-md-12">
                <legend> Endereço</legend>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="cep">CEP:</label>
                      <input type="text" id="cep" name="cep" class="form-control"  value ="<?php echo $cliente['cep'];?> " placeholder="00000000" required>
                    </div>                        
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <label for="endereco">Endereço:</label>
                      <input type="text" id="endereco" name="endereco" class="form-control" placeholder="Endereço:" value ="<?php echo $cliente['endereco'];?>" required>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="numero">Número:</label>
                      <input type="text" id="numero" name="numero" class="form-control" placeholder="Nº:" value ="<?php echo $cliente['numero'];?> " required>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="complemento">Complemento:</label>
                      <input type="text" id="complemento" name="complemento" class="form-control" placeholder="complemento:" value ="<?php echo $cliente['complemento'];?> ">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="bairro">Bairro:</label>
                      <input type="text" id="bairro" name="bairro" class="form-control" placeholder="Bairro:" value ="<?php echo $cliente['bairro'];?> " required>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="cidade">Cidade:</label>
                      <input type="text" id="cidade" name="cidade" class="form-control" placeholder="cidade:" value ="<?php echo $cliente['cidade'];?> " required>
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="">UF:</label>
                      <input type="text" id="uf" name="uf" class="form-control" placeholder="UF:" value ="<?php echo $cliente['uf'];?> " required>
                    </div>
                  </div>
              </fieldset>
            </div>
        <!--/ ENDEREÇO -->                      

            <!-- BOTÕES DA TELA ATUALIZAR CLIENTE-->
              <div class="row">                        
                <fieldset class="col-md-8">
                  <!-- BOTAO ATUALIZAR CLIENTE-->
                    <div class="col-md-3">
                      <div class="form-group">
                      <button type="submit" name="btnAtualizar" class=" form-control btn btn-success">ATUALIZAR CLIENTE</button>
                      </div> 
                    </div> 
                  <!-- /BOTAO ATUALIZAR CLIENTE-->

                  <!-- BOTAO ATUALIZAR VEICULOS-->                      
                   <!--  <div class="col-md-2">
                      <div class="form-group">
                      <a class="btn btn-primary" href="cadastrar-veiculos.php" class="form-control btn btn-success">Atualizar Veículos</a>
                      </div> 
                    </div> --> 
                  <!-- /BOTAO ATUALIZAR VEICULOS-->                      

                  <!-- VOLTAR -->
                    <div class="col-md-1">
                      <div class="form-group">
                      <a class="btn btn-warning" href="ficha-cliente-<?php echo $cliente['id_cliente'];?>"  class="form-control btn btn-success">VOLTAR</a>
                      </div> 
                    </div>
                  <!-- /VOLTAR -->                       
                </fieldset>
              </div>                    
            <!-- BOTÕES DA TELA ATUALIZAR CLIENTE-->
          </form>
    </div>
  </div>
<!-- CONTEUDO -->
<!-- RODAPE -->
<?php include_once('inc/rodape.php') ;?>
<!-- /RODAPE -->  
</body>

<script type="text/javascript" >

//MASCARA DO CEP
$('#cep').mask("99999999");
// MASCARA PARA TELEFONE
$("#telefone").mask("9999-9999?9").focusout(function (event){  
                                    var target, telefone, element;  
                                    target   = (event.currentTarget) ? event.currentTarget : event.srcElement;  
                                    telefone = target.value.replace(/\D/g, '');
                                    element  = $(target);  
                                    element.unmask();  
                                    if(telefone.length > 8) {  
                                        element.mask("?9 9999-9999");  
                                    } else {  
                                        element.mask("9999-9999");  
                                    }  
                                });
//MASCARA CPF
$('#cpf').mask('999.999.999-99', {reverse: true});

$("#alerta" ).hide(); //esconde a mensagem de cfp inválido

//valida o CPF digitado
//transformar em caixa alta
$('#cpf').blur(function(){
     // $('#nome').val(this.value.toUpperCase());
     let cpf = $('#cpf').val();
        exp = /\.|\-/g
        cpf = cpf.toString().replace( exp, "" ); 
        let digitoDigitado = eval(cpf.charAt(9)+cpf.charAt(10));
        let soma1=0, soma2=0;
        let vlr =11;

        for(i=0;i<9;i++){
                soma1+=eval(cpf.charAt(i)*(vlr-1));
                soma2+=eval(cpf.charAt(i)*vlr);
                vlr--;
        }       
        soma1 = (((soma1*10)%11)==10 ? 0:((soma1*10)%11));
        soma2 = (((soma2+(2*soma1))*10)%11);

        let digitoGerado=(soma1*10)+soma2;
        
        if(digitoGerado!=digitoDigitado){
           $("#alerta").show();
           $('#cpf').val('');
           $('#cpf').focus();
        }else{
          $("#alerta").hide();
        }      
});

//NOME
//transformar em caixa alta
$('#nome').blur(function() {
     $('#nome').val(this.value.toUpperCase());
});

//


$(document).ready(function() {
    
  //Quando o campo cep perde o foco.
  $('#cep').blur(function() {

      //Nova variável "cep" somente com dígitos.
      var cep = $(this).val().replace(/\D/g, '');

      //Verifica se campo cep possui valor informado.
      if (cep != '') {
          //Expressão regular para validar o CEP.
          var validacep = /^[0-9]{8}$/;
          //Valida o formato do CEP.
          if(validacep.test(cep)){
              //Preenche os campos com "..." enquanto consulta webservice.
              $('#endereco').val('pesquisando endereço aguarde.....');
              $('#bairro').val('...');
              $('#cidade').val('...');
              $('#uf').val('...'); 

              //desabilita os campos
              $('#endereco').attr('disabled', 'disabled');           
              $('#numero').attr('disabled', 'disabled');           
              $('#complemento').attr('disabled', 'disabled');           
              $('#bairro').attr('disabled', 'disabled');           
              $('#cidade').attr('disabled', 'disabled');           
              $('#uf').attr('disabled', 'disabled');           

              //Consulta o webservice viacep.com.br/
              $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                  if (!("erro" in dados)) {
                      //Atualiza os campos com os valores da consulta.
                      $('#endereco').val(dados.logradouro);
                      $('#bairro').val(dados.bairro);
                      $('#cidade').val(dados.localidade);
                      $('#uf').val(dados.uf);
                      // habilitar os campos
                      //desabilita os campos
                      $('#endereco').removeAttr('disabled');           
                      $('#numero').removeAttr('disabled');           
                      $('#complemento').removeAttr('disabled');           
                      $('#bairro').removeAttr('disabled');           
                      $('#cidade').removeAttr('disabled');           
                      $('#uf').removeAttr('disabled'); 
                      $('#numero').focus();
                  } //end if.
                  else {
                      $('#endereco').val('ENDEREÇO NÃO LOCALIZADO!');
                      $('#endereco').removeAttr('disabled');           
                      $('#numero').removeAttr('disabled');           
                      $('#complemento').removeAttr('disabled');           
                      $('#bairro').removeAttr('disabled');           
                      $('#cidade').removeAttr('disabled');           
                      $('#uf').removeAttr('disabled');                     
                  }
              });
          } //end if.
          else {
              $('#endereco').val('CEP INVÁLIDO, digite novamente!');
              $('cep').val('');
              $('cep').focus();
          }
      }
  });
});//fecha função de pesquisa por cep

    </script>
</html>