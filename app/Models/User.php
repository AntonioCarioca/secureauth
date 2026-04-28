<?php

namespace App\Models;

use App\Database;

/**
 * Classe responsável pela lógica de negócios, gerenciamento de dados e regras da aplicação.
 */
class User
{	
	/**
	 * Responsável pela criação de um novo usuário
	 *  
	 * @param  string $name     nome do usuário
	 * @param  string $email    email do usuário
	 * @param  string $password senha do usuário
	 * @return bool             confirmação da criação de um novo usuário
	 */
	public static function create(string $name, string $email, string $password): bool
	{
		$pdo = Database::connect();
		$stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
		return $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
	}

	/**
	 * Responsável pela procura de um usuário usando o email
	 * 
	 * @param  string $email email usado para encontrar determinado usuário
	 * @return ?object        retonar nada ou um objeto com as informações do usuário
	 */
	public static function findByEmail(string $email): ?object
	{
		$pdo = Database::connect();
		$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
		$stmt->execute([$email]);
		return $stmt->fetch(\PDO::FETCH_OBJ) ?: null;
	}
}
