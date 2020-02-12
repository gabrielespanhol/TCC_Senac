<?php
date_default_timezone_set('America/Sao_Paulo');

/**
 * Classe de conexão ao banco de dados usando PDO no padrão Singleton.
 * Modo de Usar:
 * require_once 'Conexao.php';
 * $db = Conexao::conexao();
 * E agora use as funções do PDO (prepare, query, exec) em cima da variável $db.
 * 
 * Exemplo:
 * $pdo = Conexao::conexao();
 * $stmt = $pdo->prepare('SELECT * FROM tipos_de_pagamento');
 * $stmt->execute();
 * 	while ($tipos_de_pagamento = $stmt->fetch(PDO::FETCH_OBJ)){ 
 * 		print_r($tipos_de_pagamento);
 *   }
 * ou
 * $tipos_de_pagamento = $stmt->fetchall();
 *   foreach ($tipos_de_pagamento as $pagamento) {
 * 	   echo 'Chave/ indice: '.$pagamento['id_tipo_de_pagamento'].'<br>';
 * 	   echo 'Value: '.$pagamento['tipo_pagamento'].'<br>';
 *    }
 * $tipos_de_pagamento = $stmt->fetchall(PDO::FETCH_OBJ)
 * 
 */
class Conexao
{
    # Variável que guarda a conexão PDO.
    protected static $db;

    //nomeDaClasse::metodo();

    # Private construct - garante que a classe só possa ser instanciada internamente.
    private function __construct()
    {
        # Informações sobre o banco de dados:
        // $db_host    = "10.32.48.27";
        $db_host    = "10.32.46.20";
        $db_nome    = "estacionamento";
        $db_usuario = "root";
        $db_senha   = "";
        $db_driver  = "mysql";
        
     
        try
        {
            # Atribui o objeto PDO à variável $db.
            self::$db = new PDO("$db_driver:host=$db_host; dbname=$db_nome", $db_usuario, $db_senha);
            # Garante que o PDO lance exceções durante erros.
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            # Garante que os dados sejam armazenados com codificação UFT-8.
            self::$db->exec('SET NAMES utf8');
        }
        catch (PDOException $e)
        {
            # Então não carrega nada mais da página.
            // die("Connection Error: " . $e->getMessage());
            echo 'Falha na conexão: ' . $e->getMessage();
        }
    }

    # Método estático - acessível sem instanciação.
    public static function conexao()
    {
        # Garante uma única instância. Se não existe uma conexão, criamos uma nova.
        if (!self::$db)
        {
            new Conexao();
        }
        # Retorna a conexão.
        return self::$db;
    }


	





}
?>