<?php
 include_once('inc/classes.php');

 $objCliente     = New Cliente();

 $objUsuario      = new Usuario();
 //verificar se o usuario está logado
 $objUsuario->logado(); 


 // CADASTRAR O CLIENTE
 if(isset($_POST['btnCadastrar'])){ 

   $id_cliente = $objCliente->cadastrar($_POST);

   header('location:ficha-cliente-'.$id_cliente);

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
  <div class="container-fluid">
    <!-- LINHA 1 -->
    <div id="row">
      <h2 class="text-center">CADASTAR CLIENTE MENSALISTA</h2>    
        <div class="panel panel-primary">
          <div class="panel-heading"><h2 class="panel-title">Cadastro de Cliente</h2></div>                
            <form method= "POST" >
              <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id_usuario'];?>">
              <input type="hidden" name="id_tipo_cliente" id="id_tipo_cliente" value="2">
              <!-- DADOS DO CLIENTE -->
                <div class="row">
                  <fieldset class="col-md-6">
                    <legend>Dados do Cliente</legend>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="nome">Nome:</label>
                          <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome:" required>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="cpf">CPF:</label>
                          <input type="text" id="cpf" name="cpf" class="form-control" placeholder="CPF:" required>
                          <div id="alerta" class="alert alert-danger">CPF INVÁLIDO</div>
                        </div>
                      </div>
                  </fieldset>
               
                  <fieldset class="col-md-6">
                    <legend>Dados de Contato</legend>                      
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="DDD">DDD:</label>
                        <input type="tel" id="ddd" name="ddd" class="form-control" placeholder="xx" maxlength="2" required>
                      </div>
                    </div>

                    <div class="col-md-6">
                     <div class="form-group"> 
                        <label for="telefone">Telefone ou Celular</label>
                        <input type="tel" id="telefone" name="telefone" class="form-control" placeholder="0 0000-0000" required>
                      </div>
                    </div>
                  </fieldset>
                </div>
              <!-- /DADOS DO CLIENTE -->

              <!-- ENDEREÇO -->                 
                  <div class="row">
                    <fieldset class="col-md-7">
                      <legend> Endereço</legend>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label for="cep">CEP:</label>
                            <input type="text" id="cep" name="cep" class="form-control" placeholder="00000000" required>
                          </div>                        
                        </div>

                        <div class="col-md-8">
                          <div class="form-group">
                            <label for="endereco">Endereço:</label>
                            <input type="text" id="endereco" name="endereco" class="form-control" placeholder="Endereço:" required>
                          </div>
                        </div>

                        <div class="col-md-2">
                          <div class="form-group">
                            <label for="numero">Número:</label>
                            <input type="number" id="numero" name="numero" class="form-control" placeholder="Nº:" required>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="complemento">Complemento:</label>
                            <input type="text" id="complemento" name="complemento" class="form-control" placeholder="complemento:">
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="bairro">Bairro:</label>
                            <input type="text" id="bairro" name="bairro" class="form-control" placeholder="Bairro:" required>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="cidade">Cidade:</label>
                            <input type="text" id="cidade" name="cidade" class="form-control" placeholder="cidade:" required>
                          </div>
                        </div>

                        <div class="col-md-2">
                          <div class="form-group">
                            <label for="uf">UF:</label>
                            <input type="text" id="uf" name="uf" class="form-control" placeholder="UF:" required>
                          </div>
                        </div>
                    </fieldset>
                  </div>
              <!--/ ENDEREÇO -->

                <div class="row">                    
                  <fieldset class="col-md-8">
                    <!-- BOTAO CADASTAR CLIENTE-->
                          <div class="col-md-3">

                            <div class="form-group">
                              <button type="submit" name="btnCadastrar" class=" form-control btn btn-success">Cadastrar novo Cliente</button>
                            </div> 
                          </div> 
                    <!-- /BOTAO CADASTRAR CLIENTE-->

                    <!-- VOLTAR -->
                            <div class="col-md-1">
                              <div class="form-group">
                                <a class="btn btn-warning" href="cliente-mensalistas.php" class="form-control btn btn-success">Voltar</a>
                              </div> 
                            </div>
                    <!-- /VOLTAR -->                  
                  </fieldset>   
                </div>
            </form><!--fim form -->    
        </div>                
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