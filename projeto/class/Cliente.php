<?php
/**
* 
*/
class Cliente extends Conexao
{
	protected $pdo;

	function __construct()
	{
		$this->pdo = Conexao::conexao();
	}



	# Função para cadastrar clientes
	/**
	 * @param Array $dados
	 *
	 */
	public function cadastrar($dados)
	{
		$hoje = date('Y-m-d h:i:s');
		$stmt = $this->pdo->prepare("INSERT INTO clientes (id_usuario, id_tipo_cliente, nome,cpf, ddd, telefone, cep, endereco, numero, complemento, bairro, cidade, uf, dt_cadastro, dt_atualizacao) VALUES (:id_usuario, :id_tipo_cliente, :nome, :cpf, :ddd, :telefone, :cep, :endereco, :numero, :complemento, :bairro, :cidade, :uf, :dt_cadastro, :dt_atualizacao);");
		$stmt->bindParam(':id_usuario', $dados['id_usuario']);
		$stmt->bindParam(':id_tipo_cliente', $dados['id_tipo_cliente']);
		$stmt->bindParam(':nome', $dados['nome']);
		$stmt->bindParam(':cpf', $dados['cpf']);
		$stmt->bindParam(':ddd', $dados['ddd']);
		$stmt->bindParam(':telefone', $dados['telefone']);
		$stmt->bindParam(':cep', $dados['cep']);
		$stmt->bindParam(':endereco', $dados['endereco']);
		$stmt->bindParam(':numero', $dados['numero']);
		$stmt->bindParam(':complemento', $dados['complemento']);
		$stmt->bindParam(':bairro', $dados['bairro']);
		$stmt->bindParam(':cidade', $dados['cidade']);
		$stmt->bindParam(':uf', $dados['uf']);
		$stmt->bindParam(':dt_cadastro', $hoje);
		$stmt->bindParam(':dt_atualizacao',$hoje);
 		$stmt->execute();
 		$id_cliente = $this->pdo->lastInsertId();
 		return $id_cliente;
	}


	public function listar()
	{
		$stmt = $this->pdo->prepare('SELECT * FROM clientes WHERE id_cliente > 1');
 		$stmt->execute();
 		$clientes = $stmt->fetchall(PDO::FETCH_ASSOC);
 		return $clientes;
	}


	# Função para EDITAR clientes
	/**
	 * @param Array $dados
	 *
	 * update clientes set id_usuario = :id_usuario where 
	 *
	 */
	public function editar($dados)
	{
		$stmt = $this->pdo->prepare("UPDATE clientes set id_usuario = :id_usuario, id_tipo_cliente = :id_tipo_cliente, nome = :nome, cpf = :cpf, ddd = :ddd, telefone = :telefone, cep = :cep, endereco = :endereco, numero = :numero, complemento = :complemento, bairro = :bairro, cidade = :cidade, uf = :uf, dt_cadastro = :dt_cadastro, dt_atualizacao = :dt_atualizacao WHERE id_cliente = :id_cliente ;");
		
			$hoje = date('Y-m-d h:i:s');
			$stmt->bindParam(':id_usuario', $dados['id_usuario']);
			$stmt->bindParam(':id_cliente', $dados['id_cliente']);
			$stmt->bindParam(':id_tipo_cliente', $dados['id_tipo_cliente']);
			$stmt->bindParam(':nome', $dados['nome']);
			$stmt->bindParam(':cpf', $dados['cpf']);
			$stmt->bindParam(':ddd', $dados['ddd']);
			$stmt->bindParam(':telefone', $dados['telefone']);
			$stmt->bindParam(':cep', $dados['cep']);
			$stmt->bindParam(':endereco', $dados['endereco']);
			$stmt->bindParam(':numero', $dados['numero']);
			$stmt->bindParam(':complemento', $dados['complemento']);
			$stmt->bindParam(':bairro', $dados['bairro']);
			$stmt->bindParam(':cidade', $dados['cidade']);
			$stmt->bindParam(':uf', $dados['uf']);
			$stmt->bindParam(':dt_cadastro', $hoje);
			$stmt->bindParam(':dt_atualizacao',$hoje);
 			$stmt->execute(); 		
 			return $dados['id_cliente'];
	}

	# Função para retornar os dados editados
	public function retornaDados($id_cliente)
	{
		$stmt = $this->pdo->prepare('SELECT * FROM clientes WHERE id_cliente = :id_cliente');
		$stmt->bindParam(':id_cliente', $id_cliente);
 		$stmt->execute();
 		$cliente = $stmt->fetch(PDO::FETCH_ASSOC);
 		return $cliente;
	}

	# Função para Lista de veículos
	public function listarVeiculos($id_cliente)
	{
		$stmt = $this->pdo->prepare('SELECT * FROM veiculos WHERE id_cliente = :id_cliente');
		$stmt->bindParam(':id_cliente', $id_cliente);
 		$stmt->execute();
 		$cliente = $stmt->fetchall(PDO::FETCH_ASSOC);
 		return $cliente;
	}

	# Função para PESQUISAR cliente (nome/cpf)
	public function pesquisarCliente($termoPesquisado)
    {
    	$termoPesquisado = "%".$termoPesquisado."%";

    	$stmt = $this->pdo->prepare('SELECT * FROM clientes where nome like :nome 
    															or cpf like :cpf');
        $stmt->bindParam(':nome',$termoPesquisado);
        $stmt->bindParam(':cpf',$termoPesquisado);
        $stmt->execute();
        $resultado = $stmt->fetchall(PDO::FETCH_ASSOC);
     //    if a placa exite no banco 
     //    @param $placa
     //    @return dados do veiculo
     //    else
        if ($resultado != "") {
            return $resultado;
        } else {
            return false;
        }
    }


    /*
	create view vw_historico_uso as
	select
    c.id_cliente,
    c.cpf,
	es.id_entrada_saida,
	v.id_veiculo,
	es.entrada,
	es.saida,
	v.placa
	from entradas_saidas as es
	inner join veiculos v 
	on v.id_veiculo = es.id_veiculo
    inner join clientes c
    on c.id_cliente = v.id_cliente; 
    */

    # Função para Histórico de Uso
    public function historicoUso($id_cliente)
	{
		$stmt = $this->pdo->prepare('SELECT * FROM vw_historico_uso WHERE id_cliente = :id_cliente');
		$stmt->bindParam(':id_cliente', $id_cliente);
 		$stmt->execute();
 		$cliente = $stmt->fetchall(PDO::FETCH_ASSOC);
 		return $cliente;
	}


	/*
	create view vw_extrato_pagamentos as
    select
    c.id_cliente,
    c.cpf,
    es.entrada,
    es.saida,
    es.valor,
	tp.tipo_pagamento,
    tc.tipo
    from entradas_saidas as es
    inner join veiculos v
    on es.id_veiculo = v.id_veiculo
    inner join tipos_de_pagamento tp
    on tp.id_tipo_de_pagamento = es.id_tipo_pagamento
    inner join clientes c
    on c.id_cliente = v.id_cliente
    inner join tipos_de_clientes tc
    on tc.id_tipo_de_cliente = c.id_tipo_cliente;
	*/
	# Função para Extrato de Pagamento
    public function extratoPagamento($id_cliente)
	{
		$stmt = $this->pdo->prepare('SELECT * FROM vw_extrato_pagamentos WHERE id_cliente = :id_cliente');
		$stmt->bindParam(':id_cliente', $id_cliente);
 		$stmt->execute();
 		$cliente = $stmt->fetchall(PDO::FETCH_ASSOC);
 		return $cliente;
	}
}