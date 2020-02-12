<?php

// Classe Mensalista
class Mensalista extends Conexao
{
	//Conexao com o banco
	protected $pdo;
	
    function __construct()
      	{
      		$this->pdo = Conexao::conexao();
      	}

 	// Metodo Cadastrar 
	public function cadastrar($id_cliente, $id_veiculo, $id_periodo, $valor)
 	{ 
 		
 		//Declarar Variaveis (Para Armazenar a data(Acrescentando 30 dias))
 		$dt_inicio  = date('Y-m-d');
 		$dt_termino = date('Y-m-d', strtotime('+30 days'));

    //$this = utilizando este metodo
    //pdo = é a conexão com o banco de dados
    //prepare = é um metodo para preparar a instrução do banco(sql)
 		//Preparar para inserir os valores na tabela
 		$stmt = $this->pdo->prepare('INSERT INTO pagamentos_mensalistas 
 								   (id_cliente,id_veiculo,id_periodo,valor,dt_inicio,dt_termino) 
 								   VALUES
 								   (:id_cliente,:id_veiculo,:id_periodo,:valor,:dt_inicio,:dt_termino)');

 		// O bindparam é um metodo que faz a associação entre a $variavel e o ':parametro'
 		$stmt->bindparam(':id_cliente',$id_cliente);
 		$stmt->bindparam(':id_veiculo',$id_veiculo);
 		$stmt->bindparam(':id_periodo',$id_periodo);
 		$stmt->bindparam(':valor',$valor);
 		$stmt->bindparam(':dt_inicio',$dt_inicio);
 		$stmt->bindparam(':dt_termino',$dt_termino);
 		
 		//Executar
 		$stmt->execute();

 		//Guarda o ultimo Id
 		$id_pagamento_mensalista = $this->pdo->lastinsertid();

 		//Retornar ultimo ID gerado
 		return $id_pagamento_mensalista;
 	}

 	//Metodo Cobrar
 	public function aviso_vencimento()
 	{
 		//Preparar para retornar os valores da tabela(Campos id_pagamento_mensalista, id_cliente, id_veiculo)
 		//DATEDIFF = Subtração de datas(dt_termino, Data atual)
 		//DATE_SUB = Subtrai 5 dias da data atual
 		//Vai retornar apenas as datas que forem >= a um intervalo de 5 dias(Antes de chegar no dia do pagamento).
 		$stmt = $this->pdo->prepare('SELECT id_pagamento_mensalista, id_cliente, id_veiculo, DATEDIFF(dt_termino, curdate()) as vencimento,
 								   DATE_SUB(curdate(), INTERVAL 5 DAY) as teste FROM pagamentos_mensalistas
 								   WHERE dt_termino >= DATE_SUB(curdate(), INTERVAL 5 DAY');

 		//Executar o comando
 		$stmt->execute();

 		//Retornar e guardar na variavel
 		$dt_termino = $stmt->fetchall(PDO::FETCH_ASSOC);
 		return $dt_termino;		
 	}

 	// Metodo reservar vagas
   public function reservarVagaMensalista()
   {
    //$this = utilizando este metodo
    //pdo = é a conexão com o banco de dados
    //prepare = é um metodo para preparar a instrução do banco(sql)

    // 1- Verificar quantas vagas estão livres e são para mensalista.
    $stmt = $this->pdo->prepare("SELECT * FROM vagas WHERE status = 'L' AND tipo = 'M';");

    //Executar o comando
    $stmt->execute();
    
    //fetchall(pdo::fetch_assoc) = retorna todas as linhas
    //Guardar o array na variavel
    $vagas_Mensalista = $stmt->fetchall(PDO::FETCH_ASSOC);

    //2- Fazer um update na tabela vagas transformando todas as vagas em avulsas
    $stmt1 = $this->pdo->prepare("UPDATE vagas SET tipo = 'A' WHERE status = 'L';");

    //Executar o comando
    $stmt->execute();

    //3- Verificar quantos carros Mensalistas por cada periodo precisam ter uma vaga reservada.
    //Case When = Caso Quando o date_format(A hora atual,'%H') menor que 12 é o periodo 1.
    //Contar os clientes da hora atual
      $stmt2 = $this->pdo->prepare("SELECT 
                                      COUNT(*) AS total_por_periodo, id_periodo
                                  FROM
                                      pagamentos_mensalistas
                                  WHERE
                                      dt_termino >= CURDATE()
                                      and id_periodo =
                                          CASE 
                                            WHEN date_format(now(),'%H') < 12 THEN 1
                                            WHEN date_format(now(),'%H') > 11 and date_format(now(),'%H') < 18 THEN 2
                                            ELSE 3
                                          END 
                                  GROUP BY id_periodo;");
      //Executar o comando
      $stmt2->execute();

      //fetch(PDO::FETCH_ASSOC) retorna apenas uma linha
      //Guardando um array na variavel
      $total_do_periodo = $stmt2->fetch(PDO::FETCH_ASSOC);

      //CONTAR OS CLIENTES DE PERIODO INTEGRAL
      //Preparar para executar a instrução no banco
      $stmt3 = $this->pdo->prepare("SELECT 
                                      COUNT(*) AS total_por_periodo, id_periodo
                                  FROM
                                      pagamentos_mensalistas
                                  WHERE
                                      dt_termino >= CURDATE()
                                      and id_periodo = 4
                                  GROUP BY id_periodo;");
     //Executar o comando
      $stmt3->execute();

      //fetch(PDO::FETCH_ASSOC) retorna apenas uma linha
      //Guardando um array na variavel
      $total_do_periodo_integral = $stmt3->fetch(PDO::FETCH_ASSOC);

      //TOTAL DE VAGAS A SEREM RESERVADAS
      //Guardando na variavel o valor do campo do array + o valor do campo do outro array
      $total_de_vagas_para_reserva = $total_do_periodo['total_por_periodo'] + $total_do_periodo_integral['total_por_periodo'];

      //4- RESERVAR AS VAGAS
      //Preparar para executar a instrução no banco
      //Limit = $total_de_vagas_para_reserva(a soma dos valores do periodo atual + periodo integral)
      $stmt4 = $this->pdo->prepare("UPDATE vagas SET tipo ='M' WHERE tipo = 'A' AND status = 'L' LIMIT $total_de_vagas_para_reserva");

      //Executar o comando
      $stmt4->execute();

      //EXIBIR MENSAGEM NO NAVEGADOR
      echo 'OK '.$total_de_vagas_para_reserva .' VAGAS RESERVADAS';
   }
 	
 	// Metodo liberar vagas
 	public function liberarVagaMensalista()
 	{
 		// Declarando uma variavel
 		//$this = utilizando este metodo
 		//pdo = é a conexão com o banco de dados
 		//prepare = é um metodo para preparar a instrução do banco(sql)

    //1- VERIFICAR OS VEICULOS QUE SÃO MENSALISTAS E ESTÃO FORA DO PERIODO.
 		$stmt = $this->pdo->prepare('SELECT * FROM v_liberarvagamensalista;');

    //Executar o comando
    $stmt->execute();

    //Guardar o array na variavel
    $periodoMensalista = $stmt->fetchall(PDO::FETCH_ASSOC);

      
    //2- PEGAR OS VEICULOS RETORNADOS, DAR BAIXA NA ENTRADA ATUAL, E CADASTRAR UMA NOVA ENTRADA COMO AVULSO.

    //Instrução de repetição
    foreach ($periodoMensalista as $veiculo) {
    
      //Declarar variavel que guarda o id da entrada
      $id_entrada_saida = $veiculo['id_entrada_saida'];

      //Preparar para dar um update
      //Registrar uma saida no veiculo com a data/hora atual(Fazendo a diferença da hora atual, e hora de entrada) quando o id_entrada_saida for = a o parametro
      $stmt = $this->pdo->prepare('UPDATE entradas_saidas set saida = now(), permanencia = timediff(entrada, now()) where id_entrada_saida = :id_entrada_saida;');

      //bindparam = Faz a associação entre o parametro e a variavel
      $stmt->bindparam(':id_entrada_saida',$id_entrada_saida);

      //Executar o comando
      $stmt->execute();

      //3 - REGISTRAR UMA NOVA ENTRADA PARA ESSE VEICULO COMO AVULSO

      //Preparando para fazer um insert no banco
      $stmt1 = $this->pdo->prepare("INSERT INTO entradas_saidas (id_veiculo,id_usuario, id_vaga, entrada) VALUES (:id_veiculo,:id_usuario,:id_vaga,:entrada);");
      //Declarar variavel(Atribuir valor)
      //Guardando o formato da data em uma variavel     
      $entrada    = date('Y-m-d H:i:s');

      //Pegando os valores de cada campo do array
      $id_veiculo = $veiculo['id_veiculo'];
      $id_vaga    = $veiculo['id_vaga'];
      $id_usuario = '1';//Usuario padrao = 1

      //bindparam = Faz a associação entre o parametro e a variavel
      $stmt1->bindparam(':entrada',$entrada);
      $stmt1->bindparam(':id_veiculo',$id_veiculo);
      $stmt1->bindparam(':id_vaga',$id_vaga);
      $stmt1->bindparam(':id_usuario',$id_usuario);

      //Executar o comando
      $stmt1->execute();

      //4 - ALTERAR O TIPO DA VAGA PARA AVULSO(Trocar tipo da vaga de 'M', para 'A').

      //Pegando o valor do campo do array
      $id_vaga = $veiculo['id_vaga'];

      //Preparar para inserir o comando no banco
      //Realizar update quando o campo id_vaga for = ao parametro do array
      $stmt2= $this->pdo->prepare("UPDATE vagas SET tipo  ='A'  WHERE id_vaga = :id_vaga;");

      //Faz a associação entre o parametro e a variavel
      $stmt2->bindparam(':id_vaga',$id_vaga);

      //Executar o comando
      $stmt2->execute();
    }
  }  

    /**
     * $permanencia HHH:ii 
     */

    public function calcularValor($permanencia)
    {
      //Atribuir valor a variavel com o array
      $valor_primeira_hora = 20;
      $valor_demais_horas  = 5;

        //separar a quantidade de horas dos minutos
        $tempo = explode(':',$permanencia);
        $horas =  (int)$tempo[0];
        $minutos =(int)$tempo[1];

        print_r($tempo);
        //verificar se minutos é diferente de zero, para cobrar a hora adicional
        // se o veiculo ficar exatamente X horas e Zero minutos, será cobrada a 
        // primeira hora mais cara e as demais horas no valor da hora.
        // Ex.: 03:00 - três horas
        // cobrar R$ 10,00 da primeira hora e as outras 2 horas R$ 5.00
        //
        // Ex2.: 03:10 - Três horas e 10 minutos, serão cobradas 4 horas
        // cobrar R$ 10,00 da primeira hora e as outras 3 horas R$ 5.00
        if($minutos == 0){
          $horas = $horas-1;
        }

        echo 'horas: '.$horas.'  - minutos: '. $minutos.'<br>';
        //calcular o valor
        $valor = $valor_primeira_hora + ($horas * $valor_demais_horas);

        //Retorna o valor
        return $valor;
    }


  /**
   * @param  int - $id_cliente
   * @param  int - $id_veiculo
   * @return date
   */
    public function validadeMensalista($id_cliente,$id_veiculo)
    {
      // $hoje = date('Y-m-d H:i:s');
      // SELECT * FROM pagamentos_mensalistas where id_cliente = 1006 and id_veiculo= 155 and dt_termino >= curdate();
      $hoje = date('Y-m-d');
      $stmt = $this->pdo->prepare('SELECT * FROM pagamentos_mensalistas WHERE id_cliente = :id_cliente AND id_veiculo = :id_veiculo and dt_termino >= :hoje');
      
      $stmt->bindParam(':id_cliente', $id_cliente);
      $stmt->bindParam(':id_veiculo', $id_veiculo);
      $stmt->bindParam(':hoje', $hoje);
      $stmt->execute();
      $validade = $stmt->fetch(PDO::FETCH_ASSOC);
      return $validade;
    }



}
?>