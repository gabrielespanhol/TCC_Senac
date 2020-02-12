<?php 

class EntradaSaida extends Conexao
{
	protected $pdo;
	//atributos
	public $id_veiculo, $hora_entrada, $hora_saida, 
	$id_vaga, $id_user; //, $id_cliente;
	//conexão com o banco
	function __construct()
	{
		$this->pdo=Conexao::conexao();
	}

	/**
	*	metodo de registrarEntrada:
	*	registra somente a entrada de um veiculo;
	* 	sem retorno;
	*/
	public function registrarEntrada($id_veiculo, $id_usuario, $id_vaga,$observacoes)
	{
			$entrada = date('Y-m-d H:i:s');
			$id_tipo_pagamento = 1;

			$stmt = $this->pdo->prepare("INSERT INTO entradas_saidas(id_veiculo, id_usuario, id_vaga, id_tipo_pagamento,entrada,observacoes) VALUES (:id_veiculo, :id_usuario, :id_vaga, :id_tipo_pagamento, :entrada,:observacoes);");
		    //preparar as variaveis
		 	$stmt->bindParam(':id_veiculo',$id_veiculo);
		 	$stmt->bindParam(':id_usuario',$id_usuario);
		 	$stmt->bindParam(':id_tipo_pagamento',$id_tipo_pagamento);
		 	$stmt->bindParam(':id_vaga',$id_vaga);
		 	$stmt->bindParam(':entrada',$entrada);
		 	$stmt->bindParam(':observacoes',$observacoes);
		//executa o insert
		$stmt->execute();

		$id_entrada = $this->pdo->lastInsertId();

		//atualizar vaga de "L" (Livre) para "O" (Ocupado)
		//Thomas
		$status = 'O';
		
		$stmt = $this->pdo->prepare('UPDATE vagas SET status = :status  WHERE id_vaga = :id_vaga LIMIT 1');
		
		$stmt->bindParam(':status',$status);
		$stmt->bindParam(':id_vaga',$id_vaga);
		
		$stmt->execute();

		return $id_entrada;
	}

	/**
	 * 
	 * RETORNA OS DADOS DA ENTRADA E SAIDA
	 * @return Array
	 */
	public function dadosEntradaSaida($id_entrada_saida)
	{
		//buscar id_client 
		$stmt = $this->pdo->prepare('SELECT * FROM entradas_saidas WHERE id_entrada_saida = :id_entrada_saida');
 		$stmt->bindParam(':id_entrada_saida', $id_entrada_saida);
 		$stmt->execute();
 		$entrada_saida = $stmt->fetch(PDO::FETCH_ASSOC);

 		return $entrada_saida;
	}

	/**
	 * listarVeiculosEstacionados()
	 * 
	 */

	public function listarVeiculosEstacionados()
	{
		$stmt = $this->pdo->prepare('SELECT * FROM v_veiculos_estacionados;');
 		$stmt->execute();
 		$veiculos_estacionados = $stmt->fetchall(PDO::FETCH_ASSOC);
 		return $veiculos_estacionados;
	}


	//essa função recebe a data de entrada como parametro
	//e retorna uma string com a permanencia do carro
	//no formato "HH:mm": sendo H = hora, m = minuto.
	/**
	 * $entrada datetime - Y-m-d H:i:s
	 * 
	 */
	public function calcularTempoDePermanencia($entrada)
	{
		//variaveis
		$atual = date('Y-m-d H:i:s');

		$formato_hora = '%H'.":".'%i'.":".'%a';
		$data_hora_entrada = date_create($entrada);
		$data_hora_atual   = date_create($atual); // será utilizado para calcular a permanencia

		//calcula a diferença
		$interval = date_diff($data_hora_entrada, $data_hora_atual);

		//retorna o tempo de diferença e converte pra string
		$tempototal = (string) $interval->format($formato_hora);

		//convertendo os dias em horas ↓

 		//separando o $tempototal no array $permanencia_separada com explode()
 		$permanencia_separada = explode(":", $tempototal);
 		//separando os termos em variaveis
 		$dias    = $permanencia_separada[2];
 		$horas   = $permanencia_separada[0];
 		$minutos = $permanencia_separada[1];
 		
 		// total de horas
 		$total_de_horas = $horas+($dias*24);
 		if ($total_de_horas < 10) {
 			$total_de_horas = '0'.$total_de_horas;
 		}

 		if($minutos < 10){
 			$minutos = '0'.$minutos;
 		}
          
 		//preparando string de retorno
 		$retorno = $total_de_horas.":".$minutos;
           
 		//retornando variavel retorno ↓
 		return $retorno;
	}



	/**
	 * função que verifica se o cliente é mensalista,
	 * 	retorna um int com o id_periodo(1..4) ou zero para avulso,
	 *  sendo:
	 *      0 = avulso
	 *		1 = manhã;	dás 00h00 ás 12h59
	 *		2 = tarde;	dás 13h00 ás 17h59
	 *		3 = noite;	dás 18h00 ás 23h59
	 *		4 = integral; (24hrs)
	 */
	public function verificarVeiculoMensalista($id_veiculo)
	{
		
		//buscar id_client 
		$stmt = $this->pdo->prepare('SELECT * FROM veiculos WHERE id_veiculo = :id_veiculo');
 		$stmt->bindParam(':id_veiculo', $id_veiculo);
 		$stmt->execute();
 		$veiculo = $stmt->fetch(PDO::FETCH_ASSOC);
 		

 		$stmt1 = $this->pdo->prepare('SELECT * FROM clientes WHERE id_cliente = :id_cliente');
 		$stmt1->bindParam(':id_cliente', $veiculo['id_cliente']);

 		$stmt1->execute();
 		$cliente = $stmt1->fetch(PDO::FETCH_ASSOC);

 		$tipo = $cliente['id_tipo_cliente']; //variavel $tipo recebe o id_tipo_cliente
 		

 		if ($tipo == 1) {
 			return 0; //avulso
 		} elseif($tipo == 2) {

 			//cria comando SQL pra pegar o id_periodo atraves do ultimo pagamento feito com aquele id_cliente
 			$stmt2 = $this->pdo->prepare('SELECT * FROM pagamentos_mensalistas WHERE id_cliente = :id_cliente order by id_pagamento_mensalista desc');
 			$stmt2->bindParam(':id_cliente', $cliente['id_cliente']);	
 			//executa o comando SQL
 			$stmt2->execute();
 			$retorno = $stmt2->fetch(PDO::FETCH_ASSOC); 
 			/*	retorno recebe a "tabela" que retornou, logo,
 			retorno é um array. 		*/

 			//variavel $id_periodo recebe o id do periodo;
 			$id_periodo = $retorno['id_periodo'];

 			return $id_periodo;
 		} 	
	}


	/**
	 * 
	 */
	public function registrarSaida($id_veiculo, $id_vaga, $id_entrada_saida, $id_usuario_saida, $id_tipo_pagamento,$entrada, $observacoes)
	{
			$valor = $this->exibirValor($id_veiculo, $id_entrada_saida);
			// echo $valor; die();

			//pega a hora atual do sistema
			$saida = date('Y-m-d H:i:s');
			$permanencia = $this->calcularTempoDePermanencia($entrada);

			//prepara o comando de update no banco
			$stmt = $this->pdo->prepare("UPDATE entradas_saidas SET saida = :saida, permanencia = :permanencia, valor = :valor, id_usuario_saida = :id_usuario_saida, id_tipo_pagamento = :id_tipo_pagamento, observacoes = :observacoes WHERE id_entrada_saida = :id_entrada_saida;");
		    //preparar as variaveis
			$stmt->bindParam(':id_tipo_pagamento',$id_tipo_pagamento);
			$stmt->bindParam(':saida',$saida);
			$stmt->bindParam(':permanencia',$permanencia);
			$stmt->bindParam(':valor',$valor);
			$stmt->bindParam(':id_usuario_saida',$id_usuario_saida);
			$stmt->bindParam(':observacoes',$observacoes);
			$stmt->bindParam(':id_entrada_saida',$id_entrada_saida);
			//executa o update
			$stmt->execute();

			//atualizar vaga de "O" (Ocupado) para "L" (Livre)
			$status = 'L';
		
			$stmt = $this->pdo->prepare('UPDATE vagas SET status = :status  WHERE id_vaga = :id_vaga LIMIT 1');
		
			$stmt->bindParam(':status',$status);
			$stmt->bindParam(':id_vaga',$id_vaga);
			//executa o comando ↑
			$stmt->execute();

			return $id_entrada_saida;

	}

	public function calcularValor($permanencia)
    {
      //Atribuir valor a variavel com o array
      $valor_primeira_hora = 10;
      $valor_demais_horas  = 5;

        //separar a quantidade de horas dos minutos
        $tempo = explode(':',$permanencia);
        $horas =  (int)$tempo[0];
        $minutos =(int)$tempo[1];

        // print_r($tempo);
        //verificar se minutos é diferente de zero, para cobrar a hora adicional
        // se o veiculo ficar exatamente X horas e Zero minutos, será cobrada a 
        // primeira hora mais cara e as demais horas no valor da hora.
        // Ex.: 03:00 - três horas
        // cobrar R$ 10,00 da primeira hora e as outras 2 horas R$ 5.00
        //
        // Ex2.: 03:10 - Três horas e 10 minutos, serão cobradas 4 horas
        // cobrar R$ 10,00 da primeira hora e as outras 3 horas R$ 5.00
        if($minutos == 0 && $horas != 0){
          $horas = $horas - 1;
        }

        // echo 'horas: '.$horas.'  - minutos: '. $minutos.'<br>';
        //calcular o valor
        $valor = $valor_primeira_hora + ($horas * $valor_demais_horas);
        // echo 'valor primeira hora'.$valor_primeira_hora.'+ (horas)'.$horas.'*'.$valor_demais_horas.'<br/>';


        //Retorna o valor
        return $valor;
    }

    public function exibirValor($id_veiculo, $id_entrada_saida)
    {
    	//vai receber o id_veiculo pra registrar sua saida (chama o metodo de verificarVeiculoMensalista)
		$id_periodo = $this->verificarVeiculoMensalista($id_veiculo);
		// vai receber os dados da entrada e saida
		$entrada_saida = $this->dadosEntradaSaida($id_entrada_saida);
		//pega a permanencia do carro
		$permanencia = $this->calcularTempoDePermanencia($entrada_saida['entrada']);
		
		// $id_periodo = 0 (zero) - representa avulso
		if ($id_periodo > 0) {
			// ------------------------------== Mensalista ==----------------------------------

			//prepara um select para obter o periodo atual
			$stmt = $this->pdo->prepare("select
	   			(CASE 
	        		WHEN DATE_FORMAT(now(),'%H') >= '18' THEN '3'
	        		WHEN DATE_FORMAT(now(),'%H') >= '12' THEN '2'
	        		ELSE '1'
	    		END) AS periodo;");


			//executa o comando acima ↑
			$stmt->execute();
			//guarda o periodo na variavel ↓
			$periodo = $stmt->fetch(PDO::FETCH_ASSOC);
			// echo " periodo : ";
			// print_r($periodo);
			// echo "ID PERIODO: ";
			// echo $id_periodo."|";
			//verificar se o veiculo esta no seu devido periodo ou é integral 
			if ($id_periodo == $periodo['periodo'] || $id_periodo == 4) {
				//libera o carro sem cobrar nada e altera a vaga pra livre
				$valor = 0;
				// echo "esta no periodo|";
			} elseif ($id_periodo != $periodo['periodo']) {
				$valor = $this->calcularValor($permanencia);
				// echo "não esta no periodo|";
			}

		} else {
			// ------------------------------== Avulso ==----------------------------------
			//chama o metodo de cobrar e registra a saida e libera a vaga e registra o pagamento
			$valor = $this->calcularValor($permanencia);		
		}

		//retorna o valor que o veiculo vai pagar
		return $valor;
    }
	
}
 ?>