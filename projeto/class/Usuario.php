<?php

class Usuario extends Conexao
{
	protected $pdo;

	function __construct()
	{
		$this->pdo = Conexao::conexao();
	}


	/**
	 * LISTA OS USAURIOS
	 */
	public function listar()
	{
		$stmt = $this->pdo->prepare('SELECT * FROM usuarios');
 		$stmt->execute();
 		$usuarios = $stmt->fetchall(PDO::FETCH_ASSOC);
 		return $usuarios;
	}

	/**
	* 
	* @param $dados Array
	* @return int 
	*/
	public function cadastrar($dados)
	{
		$stmt = $this->pdo->prepare('INSERT INTO usuarios
									(nome, email, senha,id_nivel_acesso,dt_cadastro,dt_atualizacao)
									VALUES
									(:nome, :email, :senha,:id_nivel_acesso,:dt_cadastro,:dt_atualizacao)');

		//tratar as variaveis
		$agora = date('Y-m-d H:i:s');
		$senha = md5($dados['senha']); //criptografar
		$email = trim(strtolower($dados['email']));
		$id_nivel_acesso = $dados['id_nivel_acesso'];

		$stmt->bindParam(':nome', $dados['nome']);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':senha', $senha);
		$stmt->bindParam(':id_nivel_acesso', $id_nivel_acesso);
		$stmt->bindParam(':dt_cadastro', $agora);
		$stmt->bindParam(':dt_atualizacao', $agora);

		$stmt->execute();
		$id_usuario =  $this->pdo->lastInsertId();
		return $id_usuario;

	}


	/**
	* @param $dados Array
	* @return int
	*/
	public function editar($dados)
	{
		$stmt = $this->pdo->prepare('UPDATE usuarios SET
									nome  = :nome,
									email = :email,
									senha = :senha
									id_nivel_acesso = :id_nivel_acesso,
									dt_atualizacao = :dt_atualizacao
									WHERE id_usuario = :id_usuario;');
		//tratar as variaveis
		$agora = date('Y-m-d H:i:s');
		$senha = md5($dados['senha']); //criptografar
		$email = trim(strtolower($dados['email']));
		$id_nivel_acesso = $dados['id_nivel_acesso'];
		$id_usuario = $dados['id_usuario'];

		$stmt->bindParam(':nome', $dados['nome']);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':senha', $senha);
		$stmt->bindParam(':id_nivel_acesso', $id_nivel_acesso);
		$stmt->bindParam(':dt_cadastro', $agora);
		$stmt->bindParam(':id_usuario', $id_usuario);

		$stmt->execute();
		return $id_usuario;

	}

	/**
	 * $email String
	 * $senha String
	 */
	public function logar($email,$senha)
	{
		//tratar as variaveis
		$senha = md5($senha); //criptografar
		$email = trim(strtolower($email));

		//pesquisar se o usuario e a senha estão corretos
		$stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = :email AND senha = :senha');
 		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':senha', $senha);
 		$stmt->execute();
 		$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

 		//verificar se a pesquisa retornou algum registro
 		if($usuario != '') {
 			//criar uma sessão com os dados so usaurio
 			session_start();
 			$_SESSION['logado']          =  true; //essa variavel controla se o usuario está logado
 			$_SESSION['id_usuario']      = $usuario['id_usuario'];
 			$_SESSION['nome_usuario']    = $usuario['nome'];
 			$_SESSION['id_nivel_acesso'] = $usuario['id_nivel_acesso'];
 			return true;
 		} else {
 			return false;
 		}
	}



	/**
	 * logado
	 * Verifica se o usuario está logado
	 * @return boolean
	 */
	public function logado()
	{
		//inicia a sessão
		session_start();

		// se a variavel de sesão logado não existir ou for diferente de TRUE
		// Destruir a sessão e direcionar para a tela de login
		// 
		if (!$_SESSION['logado'] || $_SESSION['logado']!=true){
			session_unset();
			session_destroy();
			header('location:index.php?n');
		} 
		
	}





}
?>