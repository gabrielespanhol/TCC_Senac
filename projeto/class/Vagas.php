<?php
/**
* 
*/
class Vaga extends Conexao
{
	protected $pdo;

	function __construct()
	{
		$this->pdo = Conexao::conexao();
	}


	/**
	 * listar()
	 * Retorna a relação de tipos de pagamentos
	 * @return Array
	 * @example 
	 * Array
	**/
	public function listar()
	{
		$stmt = $this->pdo->prepare('SELECT * FROM vagas');
 		$stmt->execute();
 		$vagas = $stmt->fetchall(PDO::FETCH_ASSOC);
 		return $vagas;
	}


	/**
	* LISTA AS VAGAS AVULSAS LIVRES
	*/
	public function avulsasLivres()
	{
		$stmt = $this->pdo->prepare("SELECT * FROM vagas where tipo = 'A' and status = 'L' order by vaga");
 		$stmt->execute();
 		$vagas = $stmt->fetchall(PDO::FETCH_ASSOC);
 		return $vagas;
	}

	/**
	* LISTA AS VAGAS AVULSAS MENSAIS
	*/
	public function mensaisLivres()
	{
		$stmt = $this->pdo->prepare("SELECT * FROM vagas where tipo = 'M' and status = 'L' order by vaga");
 		$stmt->execute();
 		$vagas = $stmt->fetchall(PDO::FETCH_ASSOC);
 		return $vagas;
	}



	/**
	* @param $tipo_de_pagamento String
	* @return int 
	*/
	public function cadastrar($tipo_de_pagamento)
	{
		$stmt = $this->pdo->prepare('INSERT INTO tipos_de_pagamento 
									(tipo_pagamento)
									VALUES
									(:tipo_de_pagamento)');

		$stmt->bindParam(':tipo_de_pagamento', $tipo_de_pagamento);

		$stmt->execute();

		$id_tipo_de_pagamento =  $this->pdo->lastInsertId();

		return $id_tipo_de_pagamento;

	}





}
?>