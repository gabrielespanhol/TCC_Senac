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

   public function nomePeriodo($id_periodo)
    {
        // lista periodo
        
        $stmt = $this->pdo->prepare('SELECT * FROM periodos WHERE id_periodo = :id_periodo;');
        $stmt->bindParam(':id_periodo',$id_periodo);
        $stmt->execute();
        $periodo = $stmt->fetch(PDO::FETCH_ASSOC);
        return $periodo['periodo'];
    } 


    



  
}

?>
