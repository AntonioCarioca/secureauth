<?php

namespace App;

use PDO;

/**
 * Classe que efetua a conexão do banco de dados
 */
class Database
{
	/**
	 * Método responsável pela lógica de conexão do banco de dados
	 * 
	 * @return PDO PDO Object
	 */
	public static function connect(): PDO
	{
		// Armazena dados do arquivo database em uma variável
		$config = require_once __DIR__ . '/../config/database.php';
		// Definindo a string DNS
		$dns = "{$config['connection']}:host={$config['host']};dbname={$config['database']};
				charset={$config['charset']}";
		// Criando a conexão PDO
		$pdo = new PDO($dns, $config['username'], $config['password'], [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		]);

		return $pdo;
	} 
}
