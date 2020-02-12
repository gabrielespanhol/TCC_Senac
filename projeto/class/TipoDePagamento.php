<?php
/**
* 
*/
class TipoPagamento extends Conexao
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
	*		(
	*		    [0] => Array
	*		        (
	*		            [id_tipo_de_pagamento] => 1
	*		            [tipo_pagamento] => Dinheiro
	*		        )
    *
	*		    [1] => Array
	*		        (
	*		            [id_tipo_de_pagamento] => 2
	*		            [tipo_pagamento] => Cartão de Débito
	*		        )
	*
	*		    [2] => Array
	*		        (
	*		            [id_tipo_de_pagamento] => 3
	*		            [tipo_pagamento] => Cartão de Crédito
	*		        )
	*
	*		)
	**/
	public function listar()
	{
		$stmt = $this->pdo->prepare('SELECT * FROM tipos_de_pagamento');
 		$stmt->execute();
 		$tipos_de_pagamento = $stmt->fetchall(PDO::FETCH_ASSOC);
 		return $tipos_de_pagamento;
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