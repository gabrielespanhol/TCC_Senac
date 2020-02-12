<?php 
/**
*- Veiculos
*		- Pesquisar
*			- Placa
*		- Cadastrar
*			- Precisa possuir um cliente, 
*			por padrão é o cliente 1 (um),
*			que representa o cliente AVULSO.
*		- Editar	
*/
class Veiculos extends Conexao
{
	protected $pdo;
	// Atributos
	public $placa;
	public $cor;

	// tirar de pois <------------------------
	public $id_veiculo,$id_marca_modelo,$id_cliente;

	function __construct()
	{
		$this->pdo = Conexao::conexao();
	}
	
	/**
	 *  METODOS
	 * 
	 * @param $placa
	 * @return if ($placa existe no banco de dados)
	 *
	 */

    public function pesquisarPlaca($placa)
    {
    	$stmt = $this->pdo->prepare('SELECT * FROM veiculos where placa = :placa');
        $stmt->bindParam(':placa',$placa);
        $stmt->execute();
        $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);
     //    if a placa exite no banco 
     //    @param $placa
     //    @return dados do veiculo
     //    else
        if ($veiculo != "") {
            return $veiculo;
        } else {
            return 0;
        } // end if
        
    } // end function pesquisarPlaca

    /**//**
     * Description
     * @param $id_cliente 
     * @param $id_marca_modelo 
     * @param $placa 
     * @param $cor 
     * @return id_veiculo
     */

    public function cadastrar($id_marca_modelo,$id_cliente,$placa,$cor)
    {
    	$stmt = $this->pdo->prepare('INSERT INTO veiculos 
    											(id_marca_modelo, id_cliente, placa,cor) 
    											VALUES 
    											(:id_marca_modelo, :id_cliente, :placa,:cor)');

    	$stmt->bindParam(':id_marca_modelo' , $id_marca_modelo);
    	$stmt->bindParam(':id_cliente' , $id_cliente);
    	$stmt->bindParam(':placa' , $placa);
    	$stmt->bindParam(':cor' , $cor);
 		$stmt->execute();
    	$id_veiculo = $this->pdo->lastInsertId();
    	return $id_veiculo;
    } // end function cadrastra veiculo

    


    public function cadastrarPerioDoPagamento($id_cliente,$id_veiculo,$id_periodo,$valor)
    {
        $stmt = $this->pdo->prepare('INSERT INTO pagamentos_mensalistas
                                                (id_cliente,id_veiculo, id_periodo,valor,dt_inicio, dt_termino) 
                                                VALUES 
                                                (:id_cliente,:id_veiculo, :id_periodo,:valor,:dt_inicio, :dt_termino)');

        
        $dt_inicio  = date('Y-m-d');
        $dt_termino = date('Y-m-d', strtotime('+30 days'));

        $stmt->bindParam(':id_cliente' , $id_cliente);
        $stmt->bindParam(':id_veiculo' , $id_veiculo);
        $stmt->bindParam(':id_periodo' , $id_periodo);
        $stmt->bindParam(':valor' , $valor);
        $stmt->bindParam(':dt_inicio' , $dt_inicio);
        $stmt->bindParam(':dt_termino' , $dt_termino);
        $stmt->execute();
        $id_pagamento_mensalista = $this->pdo->lastInsertId();
        return $id_pagamento_mensalista;
    } // end function cadastrarPerioDoPagamento




     /**
     * 
     * @param $id_veiculo 
     * @param $id_marca_modelo 
     * @param $id_cliente 
     * @param $cor 
     * @return id_veiculo que foi editado
     */

    public function editar($id_veiculo,$id_marca_modelo,$id_cliente,$cor)
    {
    
		$stmt = $this->pdo->prepare('UPDATE veiculos SET
												id_marca_modelo = :id_marca_modelo,
    											id_cliente = :id_cliente,
    											cor = :cor
    											WHERE id_veiculo = :id_veiculo');


    	$stmt->bindParam(':id_marca_modelo' , $id_marca_modelo);
    	$stmt->bindParam(':id_cliente' , $id_cliente);
    	$stmt->bindParam(':cor' , $cor);
    	$stmt->bindParam(':id_veiculo' , $id_veiculo);
 		$stmt->execute(); 	
        // $id_veiculo = $stmt->fetch(PDO::FETCH_ASSOC);
        return $id_veiculo;
    }// end function editar


       

    public function tipoCliente($placa)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM estacionamento.veiculos WHERE placa = '".$placa."';");
        $stmt->execute();
        $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("SELECT * FROM estacionamento.clientes WHERE id_cliente = '".$veiculo['id_cliente']."';");
        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        $tipo = $cliente['id_tipo_cliente']; //variavel $tipo recebe o id_tipo_cliente
       
        if ($tipo == 1) { // if (tipo do cliente = 1){ return "cliente avulso"}
            return true; //avulso
            // echo "avulso"; 
        } elseif ($tipo == 2) { // elseif (tipo do cliente = 2){ return "cliente mensalista"}
            return false; //mensal
            // echo "mensal";
        }  
       
    } // end function tipoCliente



     public function listar()
    {
        // lista todos os veiculos ja cadastrados

        $stmt = $this->pdo->prepare('SELECT * FROM veiculos');
        $stmt->execute();
        $listar = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $listar;
    } // end function listar  

    public function listarMarcas()
    {
        // lista todas as marcas
        
        $stmt = $this->pdo->prepare('SELECT * FROM marcas_modelos;');
        $stmt->execute();
        $marcas_modelos = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $marcas_modelos;
    } // end fun  listarMarcas
    
    public function retornaDados($id_veiculo)
    {
            
        // mostra os dados do veiculos recebendo o id_veiculo como parametro

        $stmt = $this->pdo->prepare('SELECT * FROM veiculos where id_veiculo = :id_veiculo');
        $stmt->bindParam(':id_veiculo',$id_veiculo);
        $stmt->execute();
        $id_veiculo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($id_veiculo != "") {
            return $id_veiculo;
        } else {
            return 0;
        } // end if

    } // end function retornaDados

    public function carrosCliente($id_cliente)
    {
 
        // mostra os veiculos do cliente recebendo como parametro o id_cliente

        $stmt = $this->pdo->prepare('SELECT * FROM veiculos where id_cliente = :id_cliente');
        $stmt->bindParam(':id_cliente',$id_cliente);
        $stmt->execute();
        $id_cliente = $stmt->fetchall(PDO::FETCH_ASSOC);

         if ($id_cliente != "") {
            return $id_cliente;
        } else {
            return false;
        } // end if
    } // end function carrosCliente



    /**
     * [nomeMarca description]
     * @param  INT $id_marca_modelo 
     * @return STRING
     */
    public function nomeMarca($id_marca_modelo)
    {
        // lista todas as marcas
        
        $stmt = $this->pdo->prepare('SELECT * FROM marcas_modelos WHERE id_marca_modelo = :id_marca_modelo;');
        $stmt->bindParam(':id_marca_modelo',$id_marca_modelo);
        $stmt->execute();
        $marcas = $stmt->fetch(PDO::FETCH_ASSOC);
        return $marcas['marca'].' - '.$marcas['modelo'];
    } // end function  listarMarcas

    public function listarSaidasHoje()
    {
        // lista todas as marcas
        
        $stmt = $this->pdo->prepare('SELECT * FROM v_saidas_de_hoje;');
        $stmt->execute();
        $saidas = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $saidas;
    } // end function listarSaidasHoje



    

} // end class veiculos
?>