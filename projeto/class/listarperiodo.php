<?php 

class Periodo extends Conexao
{
	protected $pdo;
	//atributos
	
	function __construct()
	{
		$this->pdo=Conexao::conexao();
	}

	public function listarPeriodos()
	{
		$stmt = $this->pdo->prepare('SELECT * FROM periodos;');
 		$stmt->execute();
 		$listarPeriodos = $stmt->fetchall(PDO::FETCH_ASSOC);
 		return $listarPeriodos;
	}


}

?>
